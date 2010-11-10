<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for page module
 * 
 * @package    Page
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class page_Core {
	
	/**
	 * Print all categories on root level
	 * @return void
	 */
	public function block_page($selected = NULL){
		// Create instance of model and fetch data
		$page = new Page_Model;
		$data = $page->get_menu();
		// create view
		$template = new View('block_pages');
		$template->data = $data;
		$template->selected = $selected;
		$template->render(TRUE);
	}
}
?>
