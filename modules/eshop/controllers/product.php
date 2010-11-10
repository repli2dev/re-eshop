<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller of products
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Product_Controller extends Base_Controller {
	
	/**
	 * @var cats model
	 */
	private $cats;
	
	/**
	 * @var products model
	 */
	private $products;
	
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.detail'), '/');
		
		// Models
		$this->cats = new Cat_Model;
		$this->products = new Product_Model;
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
		// Adding extra js file and related stuff
		$this->add_javascript('/libs/jquery/jquery.js');
		$this->add_javascript('/libs/slimbox/js/slimbox2.js');
		$this->add_css('/libs/slimbox/css/slimbox2.css');
	}
	
	/**
	 * Show product - by id
	 * @return void
	 */
	public function index($id){
		// View
		$this->template->content = new View('product_detail');
		// Fetch and bind data
		$row = $this->products->get_one($id);
		$this->template->content->name = $row['name'];
		$this->template->content->id = $id;
		$this->template->content->short_description = $row['short_description'];
		$this->template->content->description = $row['description'];
		$this->template->content->price = $row['price'];
		$this->template->content->tip = $row['tip'];
		$this->template->content->discount = $row['discount'];
		$this->template->content->manufacturer = $row['manufacturer'];
		$this->template->content->news = $row['news'];
		
		// Settings
		$this->set_title(Kohana::lang("eshop.detail").': '. $row['name']);
		$this->add_breadcrumb($row['name'], '/product/'.$row['id'].'/');
	}
	
	/** 
	 * Add product
	 * @param integer id of parent category
	 * @return void
	 */
	public function add($cat = 0){
		// Check user permission
		if(user::is_got()){
			// Model
			$manufacturer = new Manufacturer_Model;
			
			// Setings
			$this->set_title(Kohana::lang('eshop.add_product'));
			$this->add_breadcrumb(Kohana::lang('eshop.add_product'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Default values
			$form = array(
				'name' => '',
				'cat'  => $cat,
				'manufacturer' => '',
				'short_description' => '',
				'description' => '',
				'price' => '',
				'discount' => 0,
				'tip' => 0,
				'news' => 0
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required');
				$post->add_rules('cat', 'required');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$id = $this->products->add_data($post);
					url::redirect('/product/'.$id.'/'.string::to_url(product::get_name($id)));
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('product_errors');
				}
			}
			// View
			$this->template->content = new View('admin/product_add');
			$selection = $this->cats->add_names($this->cats->get_all_cats());
			$this->template->content->selection = $selection;
			$selection2 = $manufacturer->get_selection();
			$this->template->content->selection2 = $selection2;
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/** 
	 * Edit product
	 * @param integer id of product
	 * @return void
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Model
			$manufacturer = new Manufacturer_Model;
			// Settings
			$this->set_title(Kohana::lang('eshop.edit_product'));
			$this->add_breadcrumb(Kohana::lang('eshop.edit_product'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Fetch default values
			$row = $this->products->get_one($id);
			$form = array(
				'name' => $row['name'],
				'cat'  => $this->products->get_product_cat($id),
				'short_description' => $row['short_description'],
				'manufacturer' => $row['manufacturer'],
				'description' => $row['description'],
				'price' => $row['price'],
				'discount' => $row['discount'],
				'tip' => $row['tip'],
				'news' => $row['news']
			);
			$errors = array();
			// validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required');
				$post->add_rules('cat', 'required');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$this->products->change_data($post,$id);
					url::redirect('/product/'.$id.'/'.string::to_url(product::get_name($id)));
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('products_errors');
				}
			}
			// View
			$this->template->content = new View('admin/product_edit');
			$selection = $this->cats->add_names($this->cats->get_all_cats());
			$this->template->content->selection = $selection;
			$selection2 = $manufacturer->get_selection();
			$this->template->content->selection2 = $selection2;
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Delete product
	 * @param integer id of product
	 * @return void
	 */
	public function delete($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.delete_product'));
			$this->add_breadcrumb(Kohana::lang('eshop.delete_product'), url::current());
			
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$cat = $this->products->get_product_cat($id);
					$cat = $cat[0];
					$status = $this->products->delete_data($id);
					// Also delte images if deletition was successful
					if($status == TRUE){
						gallery::delete_images($id,'products');
					}
					url::redirect('/cat/'.$cat.'/'.cat::get_name($cat));
				} else {
					url::redirect('/product/'.$id.'/'.string::to_url(product::get_name($id)));
				}
			}
			// page
			$this->template->content = new View('admin/product_delete');
		} else {
			url::redirect('/denied');
		}
	}
	
	public function feed(){
		$this->template = new View('product_feed');
		$this->template->products = $this->products->getAll();
	}
}
?>
