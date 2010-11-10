<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for static pages (from db)
 * 
 * @package    Page
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Page_Controller extends Base_Controller {
	
	/**
	 * @var page model
	 */
	private $page;
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('page.page'), NULL);
		
		// Models
		$this->page = new Page_Model;
	}

	/**
	 *  Show page with given url
	 * @param string url of page
	 * @return void
	 */
	public function index($url){
		if($url == "add"){
			self::add();
		} else {
			if(!$this->page->page_exists($url)){
				url::redirect('error404');
			}
			// Get data
			$row = $this->page->get_one($url);
			
			// Settings 
			$this->set_title($row['heading']);
			$this->add_breadcrumb($row['heading'], url::current());
			
			// View
			$this->template->content = new View('page');
			$this->template->content->heading = $row['heading'];
			$this->template->content->text = $row['text'];
			$this->template->content->url = $row['url'];  
			$this->template->content->lastChange =  $row['last_change'];
		}
	}

	/**
	 *  Edit page with given url.
	 * @param string url of page
	 * @return void
	 */
	public function edit($url){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('page.edit_page'));
			$this->add_breadcrumb(Kohana::lang('page.edit_page'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Fetch data & default values
			$row = $this->page->get_one($url); 
			$form = array(
				'heading' => $row['heading'],
				'url'  => $row['url'],
				'page_text'  => $row['text'],
				'display_menu' => $row['menu']
			);
			$errors = array();
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('heading','required');
				$post->add_rules('page_text','required');
				if($post->validate()){
					// Everything seems to be ok, update db
					$this->page->change_data($post);
					url::redirect('/page/'.$url);
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('page_errors');
				}
			}
			// View
			$this->template->content = new View('admin/page_edit');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 *  Add page
	 * @return void
	 */
	public function add(){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('page.add_page'));
			$this->add_breadcrumb(Kohana::lang('page.add_page'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Default values
			$form = array(
				'heading' => '',
				'url'  => '',
				'page_text'  => '',
				'display_menu' => 0
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('heading','required');
				$post->add_rules('url', 'required','alpha_dash');
				$post->add_rules('page_text','required');
				$post->add_callbacks('url', array($this->page, '_url_is_free'));
				if($post->validate()){
					// Everything seems to be ok, insert into db
					$this->page->add_data($post);
					url::redirect('/page/'.$post['url']);
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('page_errors');
				}
			}
			// View
			$this->template->content = new View('admin/page_add');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 *  Delete page with given url
	 * @return void
	 */
	public function delete($url){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('page.delete_page'));
			$this->add_breadcrumb(Kohana::lang('page.delete_page'), url::current());
	 
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$this->page->delete_data($url);
					url::redirect('/');
				} else {
					url::redirect('/page/'.$url);
				}
			}
			// View
			$this->template->content = new View('admin/page_delete');
		} else {
			url::redirect('/denied');
		}
	}
}
?>
