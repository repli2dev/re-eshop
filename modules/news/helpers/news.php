<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for news module
 * 
 * @package    News
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class news_Core {
	
	/**
	 * Print latest 3 news
	 * @return void
	 */
	public function block_news(){
		// Creating instance of model and fetching data
		$news = new News_Model;
		$data = $news->get(1,3);
		// creating view
		$template = new View('block_news');
		$template->data = $data;
		$template->render(TRUE);
	}
	
	/**
	 * Print data
	 * @return void
	 * @param array query data
	 */
	public function items($data){
		// View
		$template = new View('news_items');
		$template->data = $data;
		$template->render(TRUE);
	}
}
?>
