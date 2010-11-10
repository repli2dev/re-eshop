<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for users module
 * 
 * @package    User
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class user_Core {
	/**
	 * @var Login session model
	 */
	var $session;
	
	/**
	 * Return TRUE if user is permissed to access admin content
	 * @return boolean
	 */
  	public function is_got(){
  		$this->session = new LogSession_Model;
  		if($this->session->get_permission() == 2){
  			return TRUE;
  		} else {
  			return FALSE;
  		}
  	}
	
	/**
	 * Return TRUE if there is logged user
	 * @return boolean
	 */
	public function is_logged(){
		$this->session = new LogSession_Model;
		if($this->session->get_permission() > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/** 
	 * Return email of current user
	 * @return string email of user
	 */
	public function user_email(){
		$this->session = new LogSession_Model;
		return $this->session->who_is_logged();
	}
	
	/**
	 * Return ID of current user
	 * @return integer ID of user
	 */
	public function user_id(){
		$user = new User_Model;
		return $user->get_id(self::user_email());
	}
	
	/**
	 * Return text name of permission level
	 * @return string
	 * @param integer level of permission
	 */
	public function text_permission($permission){
		$user = new User_Model;
		return $user->text_permission($permission);
	}
}
?>
