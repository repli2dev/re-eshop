<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Default controller - main page.
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Index_Controller extends Base_Controller {
	
	/**
	 * Main page
	 * @return void
	 */
	public function index(){
		// Page settings
		$this->set_title(Kohana::lang('index.recycleshop'));
        $this->add_breadcrumb(Kohana::lang('index.home'), url::current());
		
		// View
		$this->template->content = new View('index');
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
	}

}
