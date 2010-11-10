<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for manufacturers
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Manufacturer_Controller extends Base_Controller {
	
	/**
	 * @var manufacturers model
	 */
	private $manufacturers;
		
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.manufacturers'), '/manufacturer');
		
		// Models
		$this->manufacturer = new Manufacturer_Model;
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
	}
	
	/**
	 * Show manufacturers
	 * @return void
	 */
	public function index(){
		// Check user permission
		if(user::is_got()){
			// Fetch and bind data
			$data = $this->manufacturer->get_all();
			
			// Settings
			$this->add_breadcrumb(Kohana::lang('eshop.all'), NULL);
			$this->set_title(Kohana::lang('eshop.manage_manufacturers'));
			
			// View
			$this->template->content = new View('admin/manufacturer');
			$this->template->content->data = $data;
		} else {
			url::redirect('/denied');
		}
	}
	
	/** 
	 * Add manufacturer
	 * @return void
	 */
	public function add(){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.add_manufacturer'));
			$this->add_breadcrumb(Kohana::lang('eshop.add'), url::current());
			
			// Default values
			$form = array(
				'name' => '',
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
					$id = $this->manufacturer->add_data($post);
					url::redirect('/manufacturer');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('manufacturer_errors');
				}
			}
			// View
			$this->template->content = new View('admin/manufacturer_add');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Edit manufacturer
	 * @return void
	 * @param integer id of manufacturer
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.edit_manufacturer'));
			$this->add_breadcrumb(Kohana::lang('eshop.edit'), url::current());
			
			// Fetch values
			$row = $this->manufacturer->get_one($id);
			$form = array(
				'name' => $row[0]['name'],
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
					$this->manufacturer->change_data($post,$id);
					url::redirect('/manufacturer');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('manufacturer_errors');
				}
			}
			// View
			$this->template->content = new View('admin/manufacturer_edit');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}

	/**
	 * Delete manufacturer
	 * @return void
	 * @param integer id of manufacturer
	 */
	public function delete($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.delete_manufacturer'));
			$this->add_breadcrumb(Kohana::lang('eshop.delete'), url::current());
			
			$errors = array();
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$this->manufacturer->delete_data($id);
					url::redirect('/manufacturer');
				} else {
					url::redirect('/manufacturer');
				}
			}
			// View
			$this->template->content = new View('admin/manufacturer_delete');
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}	
}
?>
