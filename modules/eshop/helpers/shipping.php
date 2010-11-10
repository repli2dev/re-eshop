<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - shipping
 *  
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class shipping_Core {
	
	/**
	 * Return human readable name of payment
	 * @return string 
	 * @param string
	 */
	public function get_name($id){
		$shipping = new Shipping_Model;
		return $shipping->get_name($id);
	}
}
?>
