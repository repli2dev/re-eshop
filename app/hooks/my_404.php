<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * On error 404 show own error message
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class my_404{
	
    /**
     * Replace original trigger with new one, pointing to this class
	 * @return void
     */
    public function __construct(){
        Event::clear('system.404', array('Kohana', 'show_404'));
        Event::add('system.404', array($this, 'show_404'));
    }

    /**
     * Display the new error
     * @return void
     */
    public function show_404(){
    	// Redirect to error
        url::redirect('/error404/');
    }
}
new my_404();
?>
