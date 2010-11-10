<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Base controller - auto render when finished
 * Use this instead of Controller
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */


abstract class Base_Controller extends Controller {

	// Default template name - in re-eshop it is index
	public $template = '@layout';

	// Auto render controller when finish
	public $auto_render = TRUE;

	// Title of page
	public $title = NULL;

	// Breadcrumb
  	public $breadcrumb = array();
	
	// Javascripts to include
	public $javascript = array();
	
	// Other CSSs to include
	public $css = array();
	
	// RSS feeds to include
	public $feed = array();
	
	// Links
	public $links = array();
	
	// Blocks
	public $blocks_left = array();
	public $blocks_top = array();
	public $blocks_right = array();
        
	/**
	 * Template loading and setup routine.
	 * @return void
	 */
	public function __construct(){
		parent::__construct();

		// Load the template
		$this->template = new View($this->template);
		
		// Feed $feed
		$this->feed = Kohana::config('rss.feeds');
		
		// Links
		$this->links = Kohana::config('links.links');
		$this->links = base::links_filter($this->links);
		sort($this->links);
		
		// Blocks
		$this->blocks_left = Kohana::config('blocks.left');
		$this->blocks_top = Kohana::config('blocks.top');
		$this->blocks_right = Kohana::config('blocks.right');
		if(count($this->blocks_left) > 0){
			 sort($this->blocks_left);
		}
		if(count($this->blocks_top) > 0){
			sort($this->blocks_top);
		}
		if(count($this->blocks_right) > 0){
			sort($this->blocks_right);
		}

		if ($this->auto_render == TRUE){
			// Render the template immediately after the controller method
			Event::add('system.post_controller', array($this, '_render'));
		}
		
		// Remove old files from upload directory
		base::remove_old_uploads();
	}

	/**
	 * Render loaded template.
	 * @return void
	 */
	public function _render(){
		// Assign title and breadcrumb to template
		$this->template->title = $this->title;
		$this->template->breadcrumb = $this->breadcrumb;
		$this->template->pageId = url::current();
		
		// Assign null content if content is empty (all variables need to be initialized)
		if(empty($this->template->content)){
			$this->template->content = NULL;
		}
		if ($this->auto_render == TRUE){
			// Render the template
			$this->template->render(TRUE);
		}
	}

    /**
     * Add one part of breadcrumb
 	 * @param string text of link
 	 * @param string address of link
 	 * @return void
     */
    public function add_breadcrumb($text,$link){
        $this->breadcrumb[] = array('text' => $text, 'link' => $link);
    }
	
	/**
     * Set title of page
 	 * @param string new title of page
 	 * @return void
     */
    public function set_title($title){
        $this->title = $title;
    }

    /**
     * Return all breadcrumbs
     * @return string formatted breadcrumbs
     */
	public function get_breadcrumbs(){
	        $breadcrumbs = "";
	        while(current($this->breadcrumb)){ // Get through all breadcrumbs
	            $temp = current($this->breadcrumb);
	            
	            if(key($this->breadcrumb) < count($this->breadcrumb)-1){ // Set last breadcrumb as non-link
	            	if($temp['link'] != NULL){
	                	$breadcrumbs .= html::anchor($temp['link'],'<strong>'.$temp['text'].'</strong>');
					} else {
						$breadcrumbs .= $temp['text'];	
					}
	                $breadcrumbs .= " » ";
	            } else {
	                $breadcrumbs .= $temp['text'];
	            }
	            next($this->breadcrumb);
	        }
	        return $breadcrumbs;
	}
	
	/**
	 * Add javascript file for the page
	 * @param string filename
	 * @return void
	 */
	public function add_javascript($file){
		if(!in_array($file,$this->javascript)){ // Add only if is it not in array yet
			$this->javascript[] = $file;
		}
	}
	
	/**
	 * Add css file for the page
	 * @param string filename
	 * @return void
	 */
	public function add_css($file){
		if(!in_array($file,$this->css)){ // Add only if is it not in array yet
			$this->css[] = $file;
		}
	}
}
?>
