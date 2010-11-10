<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for shippings
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class shipping_Controller extends Base_Controller {
	
	/**
	 * @var shippings model
	 */
	private $shippings;
		
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.shippings'), '/shipping');
		
		// Models
		$this->shipping = new shipping_Model;
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
	}
	
	/**
	 * Show shippings
	 * @return void
	 */
	public function index(){
		// Check user permission
		if(user::is_got()){
			// Fetch and bind data
			$data = $this->shipping->get_all();
			
			// Settings
			$this->add_breadcrumb(Kohana::lang('eshop.all'), NULL);
			$this->set_title(Kohana::lang('eshop.manage_shippings'));
			
			// View
			$this->template->content = new View('admin/shipping');
			$this->template->content->data = $data;
		} else {
			url::redirect('/denied');
		}
	}
	
	/** 
	 * Add shipping
	 * @return void
	 */
	public function add(){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.add_shipping'));
			$this->add_breadcrumb(Kohana::lang('eshop.add'), url::current());
			
			// Default values
			$form = array(
				'name' => '',
				'hidden' => 0,
				'default' => 0
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
					$id = $this->shipping->add_data($post);
					url::redirect('/shipping');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('shipping_errors');
				}
			}
			// View
			$this->template->content = new View('admin/shipping_add');
			$this->template->content->form = $form;
			$this->template->content->selection = array(0 => Kohana::lang('eshop.no'),1 => Kohana::lang('eshop.yes'));
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Edit shipping
	 * @return void
	 * @param integer id of shipping
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.edit_shipping'));
			$this->add_breadcrumb(Kohana::lang('eshop.edit'), url::current());
			
			// Fetch values
			$row = $this->shipping->get_one($id);
			$form = array(
				'name' => $row[0]['name'],
				'hidden' => $row[0]['hidden'],
				'default' => $row[0]['default']
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
					$this->shipping->change_data($post,$id);
					url::redirect('/shipping');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('shipping_errors');
				}
			}
			// View
			$this->template->content = new View('admin/shipping_edit');
			$this->template->content->form = $form;
			$this->template->content->selection = array(0 => Kohana::lang('eshop.no'),1 => Kohana::lang('eshop.yes'));
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}

	/**
	 * Delete shipping
	 * @return void
	 * @param integer id of shipping
	 */
	public function delete($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.delete_shipping'));
			$this->add_breadcrumb(Kohana::lang('eshop.delete'), url::current());
			
			$errors = array();
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$this->shipping->delete_data($id);
					url::redirect('/shipping');
				} else {
					url::redirect('/shipping');
				}
			}
			// View
			$this->template->content = new View('admin/shipping_delete');
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}	
}
?>
