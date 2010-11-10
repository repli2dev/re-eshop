<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - category
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class cat_Core {
	
	/**
	 * Print all categories on root level
	 * @return void
	 */
	public function block_cats($selected = NULL){
		// Creating instance of model and fetching data
		$cats = new Cat_Model;
		$data = $cats->get_all(0);
		
		// View
		$template = new View('block_cats');
		$template->data = $data;
		$template->render(TRUE);
	}
	
	/**
	 * Return ID of parent cat
	 * @return integer id of parent cat
	 */
	public function get_parent($id){
		// Creating instance of model and fetching data
		$cats = new Cat_Model;
		$data = $cats->get_one($id);
		return $data['parent'];
	}
	
	/** 
	 * Return name of cat 
	 * @return string name of cat
	 */
	public function get_name($id){
		// Creating instance of model and fetching data
		$cats = new Cat_Model;
		$data = $cats->get_one($id);
		if(!isset($data['name'])){
			return NULL;
		} else { 
			return $data['name'];
		}
	}
	
	/**
	 * Print data 
	 * @return void
	 * @param array query data
	 */
	public function items($data){
		// View
		$template = new View('cat_items');
		$template->data = $data;
		$template->render(TRUE);
	}
}
?>
