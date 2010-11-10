<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for user sessions
 *
 * @package    User
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class LogSession_Model extends Model {
	
	/**
	 * @var Session instance
	 */
	private $session;

	/**
	 * Create new session
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
		// Create session
		$this->session = Session::instance();
	}

	/**
	 * Destroy whole session
	 * @return void
	 */
	public function destroy(){
		$this->session->delete('magicKey');
		$this->session->delete('permissionValue');
		$this->session->destroy();
	}

	/**
	 * Return name of user who is already in
	 * @return string (or FALSE) name of current user
	 */
	public function who_is_logged(){
	 	return $this->session->get('magicKey',FALSE);
	}

	/**
	 * Return permission of logged user or FALSE
	 * @return int level of permissions
	 */
	public function get_permission(){
		return $this->session->get('permissionValue',FALSE);
	}

	/**
	 * Log user in
	 * @param string email of current user
	 * @param int permission
	 */
	public function setLogged($user,$permission){
		$this->session->set('magicKey',$user);
		$this->session->set('permissionValue',$permission);
	}
}
