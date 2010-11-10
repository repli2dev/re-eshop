<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - cart 
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class cart_Core {
	
	/**
	 * Print sumary of cart
	 * @return void
	 */
	public function block_cart(){
		// Check user permission
		if(user::is_logged()){
			// Model, get data
			$cart = new Cart_Model;
			$count = $cart->count_cart();
			$total = $cart->get_total();
		} else {
			$count = 0;
			$total = 0;
		}
		
		// View
		$template = new View('block_cart');
		$template->count = $count;
		$template->total = $total;
		$template->render(TRUE);
	}
	
	/**
	 * Delete old items from cart
	 * @return void
	 */
	public function delete_old(){
		$cart = new cart_Model;
		$cart->delete_old();
	}
}
?>
