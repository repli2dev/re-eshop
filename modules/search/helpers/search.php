<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for search module
 * 
 * @package    Search
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class search_Core {
	
	/**
	 * Print search form - compact version - block
	 * @return void
	 */
	public function block_search(){
		// Creating instance of model and fetching data
		$template = new View('block_search');
		$template->render(TRUE);
	}
}
?>
