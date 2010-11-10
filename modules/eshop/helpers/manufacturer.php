<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for eshop module - manufacturer
 *  
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class manufacturer_Core {
	
	/**
	 * Return human readable name of manufacturer
	 * @return string 
	 * @param integer id of manufacturer
	 */
	public function get_name($id){
		$manufacturer = new Manufacturer_Model;
		return $manufacturer->get_name($id);
	}
}
?>
