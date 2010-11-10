<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for categories
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Cat_Controller extends Base_Controller {
	
	/**
	 * Products per page
	 */
	const PER_PAGE = 20;
	
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
		$this->add_breadcrumb(Kohana::lang('eshop.cat'), '/');
		
		// Models
		$this->cats = new Cat_Model;
		$this->products = new Product_Model;
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
	}
	
	/**
	 * Show category - by id
	 * @return void
	 * @param integer id of category
	 * @param integer number of page
	 */
	public function index($id,$page = 1){
		// View
		$this->template->content = new View('cat');
		// Fetch and bind data
		$row = $this->cats->get_one($id);
		$subcats = $this->cats->get_all($id);
		$products = $this->products->get($page,self::PER_PAGE,$this->cats->get_all_cats_in_depth($id));
		$this->template->content->name = $row['name'];
		$this->template->content->id = $id;
		$this->template->content->subcats = $subcats;
		$this->template->content->products = $products;
		
		// Settings
		$this->set_title(Kohana::lang("eshop.cat").': '. $row['name']);
		$this->add_breadcrumb($row['name'], '/cat/'.$row['id'].'/');
		
		if($page == 1){
			$this->add_breadcrumb(Kohana::lang('eshop.latest'), url::current());	
		} else {
			$this->add_breadcrumb(Kohana::lang('eshop.page_no').' '.$page, url::current());
		}
		
		//Pagination
		$this->pagination = new Pagination(array(
		    'uri_segment'    => 'page',
		    'total_items'    => $this->products->count($this->cats->get_all_cats_in_depth($id)),
		    'items_per_page' => self::PER_PAGE,
		    'style'          => 'digg'
		));
	}
	
	/** 
	 * Add category
	 * @param integer id of parent category
	 * @return void
	 */
	public function add($parent = 0){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.add_cat'));
			$this->add_breadcrumb(Kohana::lang('eshop.add_cat'), url::current());
			
			// Default values
			$form = array(
				'name' => '',
				'parent'  => $parent,
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required');
				$post->add_rules('parent', 'required','numeric');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$id = $this->cats->add_data($post);
					url::redirect('/cat/'.$id.'/'.cat::get_name($id));
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('cat_errors');
				}
			}
			// View
			$this->template->content = new View('admin/cat_add');
			$selection = array(Kohana::lang('eshop.top_level'));
			$selection = $selection + $this->cats->add_names($this->cats->get_all_cats());
			$this->template->content->selection = $selection;
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Edit category
	 * @return void
	 * @param integer id of category
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.edit_cat'));
			$this->add_breadcrumb(Kohana::lang('eshop.edit_cat'), url::current());
			
			// Fetch values
			$row = $this->cats->get_one($id);
			$form = array(
				'name' => $row['name'],
				'parent'  => $row['parent'],
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('name','required');
				$post->add_rules('parent', 'required','numeric');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$this->cats->change_data($post,$id);
					url::redirect('/cat/'.$id.'/'.cat::get_name($id));
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('cat_errors');
				}
			}
			// View
			$this->template->content = new View('admin/cat_edit');
			$selection = array(Kohana::lang('eshop.top_level'));
			$selection = $selection + $this->cats->add_names($this->cats->get_all_cats());
			$this->template->content->selection = $selection;
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}

	/**
	 * Delete category
	 * @return void
	 * @param integer id of category
	 */
	public function delete($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.delete_cat'));
			$this->add_breadcrumb(Kohana::lang('eshop.delete_cat'), url::current());
			
			$errors = array();
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					if(count($this->cats->get_children($id)) != 0 OR count($this->products->get(1,1,$id))){
						$errors[] = Kohana::lang('eshop.cannot_be_deleted');
					} else {
						$parent = cat::get_parent($id);
						$this->cats->delete_data($id);
						if($parent == 0){
							url::redirect('/');	
						} else {
							url::redirect('/cat/'.$parent.'/'.cat::get_name($parent));	
						}
					}
				} else {
					url::redirect('/cat/'.$id.'/'.cat::get_name($id));
				}
			}
			// View
			$this->template->content = new View('admin/cat_delete');
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}	
}
?>
