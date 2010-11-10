<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - products
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class product_Core {
	/** 
	 * Return name of product 
	 * @return string name of product
	 */
	public function get_name($id){
		// Creating instance of model and fetching data
		$products = new Product_Model;
		$data = $products->get_one($id);
		if(!isset($data['name'])){
			return NULL;
		} else { 
			return $data['name'];
		}
	}
	/** 
	 * Return price of product 
	 * @return integer price of product
	 */
	public function get_price($id){
		// Creating instance of model and fetching data
		$products = new Product_Model;
		$data = $products->get_one($id);
		if(!isset($data['price'])){
			return NULL;
		} else { 
			return $data['price'];
		}
	}
	
	/**
	 * Print X products in tip
	 * @return void
	 * @param string flag (column) which has to be set to TRUE
	 * @param integer number of products
	 */
	public function block_flag($flag,$num){
		// Creating instance of model and fetching data
		$products = new Product_Model;
		$data = $products->get_flag($flag,$num);
		
		// View
		$template = new View('block_flag');
		$template->data = $data;
		$template->render(TRUE);
	}
}
?>
