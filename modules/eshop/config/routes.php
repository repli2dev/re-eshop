<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Sets routes for eshop
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
$config['cat/([0-9]+)'] = 'cat/index/$1';
$config['cat/([0-9]+)/([a-zA-Z0-9\-]+)'] = 'cat/index/$1';
$config['cat/([0-9]+)/([a-zA-Z0-9\-]+)/page/([0-9]+)'] = 'cat/index/$1/$3';

$config['product/([0-9]+)'] = 'product/index/$1';
$config['product/([0-9]+)/(.*)'] = 'product/index/$1';

