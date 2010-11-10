<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Links to menu
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
$config['links'][] = array(25, Kohana::lang('eshop.cart'),'/cart/show',1);
$config['links'][] = array(30, Kohana::lang('eshop.customer_profile'),'/customer/profile',1);
$config['links'][] = array(35, Kohana::lang('eshop.customer_orders'),'/customer/orders',1);
$config['links'][] = array(40, Kohana::lang('eshop.manage_customers'),'/customer/show',2);
$config['links'][] = array(45, Kohana::lang('eshop.manage_orders'),'/order/index',2);
$config['links'][] = array(50, Kohana::lang('eshop.manage_manufacturers'),'/manufacturer/index',2);
$config['links'][] = array(50, Kohana::lang('eshop.manage_payments'),'/payment/index',2);
$config['links'][] = array(50, Kohana::lang('eshop.manage_shippings'),'/shipping/index',2);
?>