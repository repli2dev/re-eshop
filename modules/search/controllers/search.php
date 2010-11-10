<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Search controller
 * 
 * @package    Search
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Search_Controller extends Base_Controller {
	
	/**
	 * @var products model
	 */
	private $products;
	
	/**
	 * @var pages model
	 */
	private $page;
	
	/**
	 * @var news model
	 */
	private $news;
	
	const PER_PAGE = 5;
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('search.search'), '/search');
		$this->products = new Product_Model;
		$this->page = new Page_Model;
		$this->news = new News_Model;
		
		// Adding extra css file
		$this->css[] = '/modules/eshop/css/eshop.css';
	}
	
	/**
	 * Show latest PER_PAGE news on page
	 * @return void
	 */
	public function index($module = NULL,$page = 1){
		$this->set_title(Kohana::lang('search.search'));
		if($page == 1){
			$this->add_breadcrumb(Kohana::lang('search.the_best_results'), url::current());	
		} else {
			$this->add_breadcrumb(Kohana::lang('search.page_no').' '.$page, url::current());
		}
		
		// Default values
		$form = array(
			'value' => '',
		);
		$errors = array();
		if ($_POST){
			$post = new Validation($_POST);
			// Some filters
			$post->pre_filter('trim', TRUE);
			// Rules
			$post->add_rules('value','required');
			if($post->validate()){
				$form = arr::overwrite($form, $post->as_array());
			} else {
				// Repopulate form with error and original values
				$form = arr::overwrite($form, $post->as_array());
				$errors = $post->errors('search_errors');
			}
		}
		$this->template->content = new View('search');
		$data = $this->products->search($post['value']);
		$data2 = $this->page->search($post['value']);
		$data3 = $this->news->search($post['value']);
		$this->template->content->data = $data;
		$this->template->content->data2 = $data2;
		$this->template->content->data3 = $data3;
		$this->template->content->form = $form;
		$this->template->content->errors = $errors;
		
	}
}
?>
