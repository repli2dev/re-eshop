<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Error 404 controller
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Error404_Controller extends Base_Controller {

	/**
	 * Error 404 page
	 * @return void
	 */
	public function index(){
		// Page settings
		$this->add_breadcrumb(Kohana::lang('error404.error'), url::current());
		$this->set_title(Kohana::lang('error404.heading'));
		
		// View
		$this->template->content = new View('error404');
	}

}