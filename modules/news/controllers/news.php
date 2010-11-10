<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for news module (stored in db)
 * 
 * @package    News
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class News_Controller extends Base_Controller {
	
	/**
	 * @var news model
	 */
	private $news;
	
	const PER_PAGE = 10;
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('news.news'), 'news');
		
		// Model
		$this->news = new News_Model;
		
		// Adding extra js file and related stuff
		$this->add_javascript('/libs/jquery/jquery.js');
		$this->add_javascript('/libs/slimbox/js/slimbox2.js');
		$this->add_css('/libs/slimbox/css/slimbox2.css');
	}
	
	/**
	 * Show latest PER_PAGE news on page
	 * @return void
	 * @param page number of page
	 */
	public function index($page = 1){
		$this->set_title(Kohana::lang('news.news'));
		if($page == 1){
			$this->add_breadcrumb(Kohana::lang('news.latest'), url::current());	
		} else {
			$this->add_breadcrumb(Kohana::lang('news.page_no').' '.$page, url::current());
		}
		
		// View
		$this->template->content = new View('news');
		$data = $this->news->get($page,self::PER_PAGE);
		$this->template->content->data = $data;
		
		//Pagination
		$this->pagination = new Pagination(array(
		    'uri_segment'    => 'index',
		    'total_items'    => $this->news->count(),
		    'items_per_page' => self::PER_PAGE,
		    'style'          => 'digg'
		));
	}
	/**
	 * Show only one news.
	 * @return void
	 */
	public function detail($id){
		// Get data
		$row = $this->news->get_one($id);
		
		// Settings
		$this->add_breadcrumb(Kohana::lang('news.detail'), url::current());
		$this->set_title($row['heading']);
		
		// View
		$this->template->content = new View('news_detail');
		$this->template->content->row = $row;
	}
	
	/**
	 * RSS feed of news.
	 * @return void
	 */
	public function rss(){
		// Special view for rss 
		$this->template = new View('rss');
		$this->template->time =  StrFTime("%a, %d %b %Y %H:%M:%S %z", Time()); // time of generation
		$this->template->description = Kohana::lang('news.rss_description');
		$this->set_title(Kohana::lang('news.news'));
		$this->template->lang = '';
		$this->template->address = url::base();
		$this->template->items = $this->news->get(1,self::PER_PAGE);
	}
	
	/**
	 * Add page
	 * @return void
	 */
	public function add(){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('news.add_news'));
			$this->add_breadcrumb(Kohana::lang('news.add_news'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Default values
			$form = array(
				'heading' => '',
				'perex'  => '',
				'news_text'  => '',
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('heading','required');
				$post->add_rules('perex', 'required');
				$post->add_rules('news_text','required');
				if($post->validate()){
					// Everything seems to be ok, insert into db
					$id = $this->news->add_data($post);
					url::redirect('/news/detail/'.$id);
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('news_errors');
				}
			}
			// View
			$this->template->content = new View('admin/news_add');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Edit page
	 * @return void
	 * @param integer id of news
	 */
	public function edit($id){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('news.edit_news'));
			$this->add_breadcrumb(Kohana::lang('news.edit_news'), url::current());
			
			// Load tinymce
			$this->add_javascript('/libs/tinymce/tiny_mce.js');
			$this->add_javascript('/libs/tinymce/poorEditor.js');
			$this->add_javascript('/libs/tinymce/richEditor.js');
			
			// Fetch one and load to array of default values
			$row = $this->news->get_one($id);
			$form = array(
				'heading' => $row['heading'],
				'perex'  => $row['perex'],
				'news_text'  => $row['text'],
			);
			$errors = array();
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('heading','required');
				$post->add_rules('perex', 'required');
				$post->add_rules('news_text','required');
				if($post->validate()){
					// Everything seems to be ok, update db
					$this->news->change_data($post,$id);
					url::redirect('/news/detail/'.$id);
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('news_errors');
				}
			}
			// View
			$this->template->content = new View('admin/news_edit');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Delete page
	 * @return void
	 * @param id of news
	 */
	public function delete($id){
		// Check for user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('news.delete_news'));
			$this->add_breadcrumb(Kohana::lang('news.delete_news'), url::current());
			
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = delete
					$status = $this->news->delete_data($id);
					// Also delte images if deletition was successful
					if($status == TRUE){
						gallery::delete_images($id,'news');
					}
					url::redirect('/news');
				} else {
					url::redirect('/news/detail/'.$id);
				}
			}
			// View
			$this->template->content = new View('admin/news_delete');
		} else {
			url::redirect('/denied');
		}
	}
	
}
?>
