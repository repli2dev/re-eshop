<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * On every controller check for old cart items
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class my_cart{
    /**
     * Add trigger
     */
    public function __construct(){
        // Add event for autoremoving old items from cart
		Event::add('system.pre_controller', array('cart', 'delete_old'));
    }
}
new my_cart();
?>