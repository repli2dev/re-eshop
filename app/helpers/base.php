<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for base controller
 * 
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class base_Core {
	
	/**
	 * Remove old files from upload directory
	 * @return void
	 */
	public function remove_old_uploads(){
		$dir = "./data/upload/";
		$dir2 = opendir($dir);
		while ($file = readdir($dir2)){
			if($file != "." AND $file != ".." AND $file != ".svn"){
				$time = filemtime($dir.$file);
				if($time < time()-(3600*24)){ // Delete all files which are older than day
					unlink($dir.$file);
				}
			}
		}
	}
	
	/**
	 * Print errors
	 * @return void
	 * @param array of errors
	 */
	public function errors($errors){
		$template = new View('errors');
		$template->errors = $errors;
		$template->render(TRUE);
	}
	
	/**
	 * Print messages about success
	 * @return void
	 * @param array of success
	 */
	public function success($success){
		$template = new View('success');
		$template->success = $success;
		$template->render(TRUE);
	}
	
	/**
	 * Remove links which have permission higher than current user
	 * @param array of links
	 * @return array of filtered links 
	 */
	public function links_filter($links){
		if(class_exists('LogSession_Model')){
			$session = new LogSession_Model;
			$current_permission = $session->get_permission();
			$new = array();
			foreach($links as $row){
				if($row[3] <= $current_permission){
					$new[] = $row;
				}
			}
			return $new;
		} else {
			return $links;
		}
	}
	
	/**
	 * Print blocks from array
	 * @return void
	 * @param array of methods which provide that blocks
	 */
	public function blocks($blocks){
		if(count($blocks) > 0){
			foreach($blocks as $row){
				eval($row[1]);	
			}
		}
	}
}
?>