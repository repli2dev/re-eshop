<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for payments
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class payment_Controller extends Base_Controller {
	
	/**
	 * @var payments model
	 */
	private $payments;
		
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.payments'), '/payment');
		
		// Models
		$this->payment = new payment_Model;
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
	}
	
	/**
	 * Show payments
	 * @return void
	 */
	public function index(){
		// Check user permission
		if(user::is_got()){
			// Fetch and bind data
			$data = $this->payment->get_all();
			
			// Settings
			$this->add_breadcrumb(Kohana::lang('eshop.all'), NULL);
			$this->set_title(Kohana::lang('eshop.manage_payments'));
			
			// View
			$this->template->content = new View('admin/payment');
			$this->template->content->data = $data;
		} else {
			url::redirect('/denied');
		}
	}
	
	/** 
	 * Add payment
	 * @return void
	 */
	public function add(){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.add_payment'));
			$this->add_breadcrumb(Kohana::lang('eshop.add'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			
			// Default values
			$form = array(
				'name' => '',
				'type' => 'post',
				'hidden' => 0,
				'default' => 0,
				'info' => ''
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required','length[0,255]');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$id = $this->payment->add_data($post);
					url::redirect('/payment');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('payment_errors');
				}
			}
			// View
			$this->template->content = new View('admin/payment_add');
			$this->template->content->form = $form;
			$this->template->content->selection = array(0 => Kohana::lang('eshop.no'),1 => Kohana::lang('eshop.yes'));
			$this->template->content->selection2 = array('pre' => Kohana::lang('eshop.inside'), 'post' => Kohana::lang('eshop.outside'));
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Edit payment
	 * @return void
	 * @param integer id of payment
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.edit_payment'));
			$this->add_breadcrumb(Kohana::lang('eshop.edit'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			
			// Fetch values
			$row = $this->payment->get_one($id);
			$form = array(
				'name' => $row[0]['name'],
				'type' => $row[0]['type'],
				'hidden' => $row[0]['hidden'],
				'default' => $row[0]['default'],
				'info' => $row[0]['info']
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required','length[0,255]');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$this->payment->change_data($post,$id);
					url::redirect('/payment');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('payment_errors');
				}
			}
			// View
			$this->template->content = new View('admin/payment_edit');
			$this->template->content->form = $form;
			$this->template->content->selection = array(0 => Kohana::lang('eshop.no'),1 => Kohana::lang('eshop.yes'));
			$this->template->content->selection2 = array('pre' => Kohana::lang('eshop.inside'), 'post' => Kohana::lang('eshop.outside'));
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}

	/**
	 * Delete payment
	 * @return void
	 * @param integer id of payment
	 */
	public function delete($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.delete_payment'));
			$this->add_breadcrumb(Kohana::lang('eshop.delete'), url::current());
			
			$errors = array();
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$this->payment->delete_data($id);
					url::redirect('/payment');
				} else {
					url::redirect('/payment');
				}
			}
			// View
			$this->template->content = new View('admin/payment_delete');
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}	
}
?>
