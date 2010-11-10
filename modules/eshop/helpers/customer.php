<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - customer
 *  
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class customer_Core {
	
	/**
	 * Return human readable status of order
	 * @return string 
	 * @param string
	 */
	public function order_status($status){
		if($status == "none"){
			return Kohana::lang('eshop.none');
		} else
		if($status == "done"){
			return Kohana::lang('eshop.done');
		} else
		if($status == "cancel"){
			return Kohana::lang('eshop.cancel');
		}
	}
	
	/**
	 * Return human readable status of payment
	 * @return string 
	 * @param string
	 */
	public function payment_status($status){
		if($status == "none"){
			return Kohana::lang('eshop.none');
		} else
		if($status == "paid"){
			return Kohana::lang('eshop.paid');
		}
	}
}
?>
