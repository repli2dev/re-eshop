<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - payment
 *  
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class payment_Core {
	
	/**
	 * Return human readable name of payment
	 * @return string 
	 * @param integer
	 */
	public function get_name($id){
		$payment = new Payment_Model;
		return $payment->get_name($id);
	}
	
	/**
	 * Return type of payment method
	 * @return string
	 * @param integer
	 */
	public function get_type($id){
		$payment = new Payment_Model;
		return $payment->get_type($id);
	}
}
?>
