<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Permission denied controller
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Denied_Controller extends Base_Controller {

	/**
	 * Permission denied page
	 * @return void 
	 */
	public function index(){
		// Page settings
		$this->add_breadcrumb(Kohana::lang('denied.denied'), url::current());
		$this->set_title(Kohana::lang('denied.denied'));
		
		// View
		$this->template->content = new View('denied');
	}

}
