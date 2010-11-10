<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Sets the default route for static pages
 * 
 * @package    Page
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

$config['page/([a-zA-Z0-9\-\_]+)'] = 'page/index/$1';