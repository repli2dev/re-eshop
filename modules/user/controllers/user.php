<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for user actions like register, login, change of password...
 * 
 * @package    User
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class User_Controller extends Base_Controller {

	/**
	 * @var Login Session model
	 */
	private $LogSession;
	
	/**
	 * @var User model
	 */
	private $User;

	/**
	 * Stuff shared for all controller
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
		
		// Create models
		$this->LogSession = new LogSession_Model;
		$this->user = new User_Model;

		$this->add_breadcrumb(Kohana::lang('user.user'), 'user');
	}

	/**
	 * Decide what to do - show profile or login screen?
	 * @return void
	 */
	public function index(){
		if(!user::is_logged()){
			// User is logged means show profile
			url::redirect('/user/profile');
		} else {
			// User is not logged means show login screen
			url::redirect('/user/login');
		}
	}

	/**
	 * Register
	 * @return void
	 */
	public function register(){
		// Check if user is not logged
		if(!user::is_logged()){
			// Page settings
			$this->set_title(Kohana::lang('user.register'));
			$this->add_breadcrumb(Kohana::lang('user.register'), url::current());
			// Default values
			$form = array(
				'email'      => '',
				'fullname'  => '',
				'password'  => '',
				'password2'  => '',
			);
			$errors = $form;
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('email','required', 'email');
				$post->add_callbacks('email', array($this->user, '_email_not_exists'));
				$post->add_rules('fullname', 'required');
				$post->add_rules('password', 'required');
				$post->add_rules('password2', 'required');
				$post->add_rules('password', 'matches[password2]');
				$post->add_rules('password','length[6,128]');
				if($post->validate()){
					// Everything seems to be ok - register
					$this->user->register($post);
					// send email
					$mail = new View('mail_new_account');
					$mail->post = $post;
					mail::send($post['email'],Kohana::lang('user.new_account'),$mail);
					url::redirect('/user/login/ready');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('users_register_errors');
				}
			}
			// page
			$this->template->content = new View('register');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/user/profile');
		}
	}

	/**
	 * Login
	 * @return void
	 */
	public function login($state = NULL){
		// messages about success
		$success = array();
		if($state == "ready") $success[] = Kohana::lang('user.succesfully_registered');
		if($state == "renewed") $success[] = Kohana::lang('user.succesfully_renewed');
		if($state == "login") $success[] = Kohana::lang('user.please_login');
		if(!user::is_logged()){
			// Set title
			$this->set_title(Kohana::lang('user.login'));
			$this->add_breadcrumb(Kohana::lang('user.login'), url::current());
			// default values
			$form = array(
				'email'      => '',
				'password'  => '',
			);
			$errors = $form;
			// validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('email','required', 'email');
				$post->add_rules('password', 'required');
				$post->add_callbacks('password', array($this->user, '_user_match'));
				$post->add_callbacks('email', array($this->user, '_not_banned'));
				if($post->validate()){
					// Everything seems to be ok, log in
					$this->LogSession->setLogged($post['email'],$this->user->get_permission($post['email']));
					url::redirect('/user/profile');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('users_login_errors');
					$success = array();
				}
			}
			// page
			$this->template->content = new View('login');
			$this->template->content->state = $state;
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
			$this->template->content->success = $success;
		} else {
			// User is already logged
			url::redirect('/user/profile');
		}
	}

	/**
	 * Send code
	 * @return void
	 */
	public function password(){
		if(!user::is_logged()){
			$this->add_breadcrumb(Kohana::lang('user.forgot_password'), url::current());
			$this->set_title(Kohana::lang('user.forgot_password'));
			// default values
			$form = array(
				'email'      => '',
			);
			$errors = $form;
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('email','required', 'email');
				$post->add_callbacks('email', array($this->user, '_email_exists'));
				$post->add_callbacks('email', array($this->user, '_not_banned'));
				if($post->validate()){
					// create hash
					$hash = string::random_code(28);
					// save it to db
					$this->user->change_hash($post['email'],$hash);
					// send email to user
					$mail = new View('mail_changing_password');
					$mail->hash = $hash;
					mail::send($post['email'],Kohana::lang('user.changing_password'),$mail);
					// redirect user to next page
					url::redirect('/user/renew');
			} else {
				// Repopulate form with error and original values
				$form = arr::overwrite($form, $post->as_array());
				$errors = $post->errors('users_forget_errors');
			}
			}
			$this->template->content = new View('forgot');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/user/profile');
		}
	}
	/**
	 * New password
	 * @return void
	 */
	public function renew(){
		if(!user::is_logged()){
			$this->add_breadcrumb(Kohana::lang('user.renew_password'), url::current());
	 		$this->set_title(Kohana::lang('user.renew_password'));
			// default values
			$form = array(
				'email'      => '',
				'code'  => '',
			);
			$errors = $form;
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('email','required', 'email');
				$post->add_rules('code','required');
				$post->add_callbacks('email', array($this->user, '_code_match'));
				$post->add_callbacks('email', array($this->user, '_not_banned'));
				if($post->validate()){
					// create new password and save it
					$new = string::random_code();
					$this->user->change_password($post['email'],$new);
					// send email to user
					$mail = new View('mail_renew_password');
					$mail->new = $new;
					mail::send($post['email'],Kohana::lang('user.new_password'),$mail);
					// redirect user to next page
					url::redirect('/user/login/renewed');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('users_renew_errors');
				}
		    }
		$this->template->content = new View('renew');
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		} else {
			url::redirect('/user/profile');
		}
	}

	/**
	 * View profile
	 * @return void
	 */
	public function profile(){
		 if(user::is_logged()){
			$this->add_breadcrumb(Kohana::lang('user.yourprofile'), url::current());
			$this->set_title(Kohana::lang('user.yourprofile'));
			$this->template->content = new View('profile');
			$this->template->content->email = $this->LogSession->who_is_logged();
			$this->template->content->name = $this->user->get_name($this->LogSession->who_is_logged());
			$this->template->content->permission = $this->user->text_permission($this->LogSession->get_permission());
		 } else {
			// User is not suppose to be here, redirect
			url::redirect('/user/login');
		 }
	}

	/**
	 * Settings
	 * @return void
	 */
	public function setting($state = NULL){
		if(user::is_logged()){
			// Messages about success
			$success = array();
			if($state == "changed") $success[] = Kohana::lang('user.successfully_changed');
			$this->add_breadcrumb(Kohana::lang('user.settings'), url::current());
			$this->set_title(Kohana::lang('user.settings'));
			// default values
			$form = array(
				'password' => '',
				'password2' => '',
				'password3' => '',
			);
			$form['fullname'] = $this->user->get_name($this->LogSession->who_is_logged());
			//$errors = $form;
			$errors = array();
			// change data
			if ($_POST){
				$post = new Validation($_POST);
				$post->add_rules('password3', 'required'); // old password is always required
				$post->add_rules('fullname', 'required');

				$post->add_rules('password', 'depends_on[password2]');
				$post->add_rules('password2', 'depends_on[password]');
				$post->add_rules('password','length[6,128]');
				$post->add_rules('password', 'matches[password2]','depends_on[password]','depends_on[password2]');

				$post['email'] = $this->LogSession->who_is_logged();
				$post->add_callbacks('password3', array($this->user, '_password_match'));
				// Some filters
				$post->pre_filter('trim', TRUE);
				if($post->validate()){
					$this->user->change_data($post,$this->LogSession->who_is_logged());
					if(!empty($post['password'])){
						$this->user->change_password($this->LogSession->who_is_logged(),$post['password']);
					}
					    url::redirect('/user/setting/changed');
					} else {
						// Repopulate form with error and original values
						$form = arr::overwrite($form, $post->as_array());
						$errors = $post->errors('users_settings_errors');
						$success = array();
					}
			}

			$this->template->content = new View('setting');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
			$this->template->content->success = $success;
		} else {
			// User is not suppose to be here, redirect
			url::redirect('/user/login');
		}
	}

	/**
	 *
	 * Loggin user out
	 * @return void
	 */
	public function logout(){
		$this->LogSession->destroy();
		url::redirect('/user');
	}
}
?>
