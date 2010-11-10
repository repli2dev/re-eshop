<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for user db table
 *
 * @package    User
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class User_Model extends Model {

	// Name of db table
	const TN_USERS = "users";

	/**
	  * Look if email and password match with db
	  * @param Validation Validation object
	  * @param string field that all goes on
	  * @return boolean
	  */
	public function _user_match(Validation $array, $field){
		// Questing database for this user
		$user_exists = $this->db->from(self::TN_USERS)->where('password',sha1($array[$field]))->where('email',$array['email'])->count_records();

		if($user_exists != 1){
			$array->add_error($field,'mismatch');
		} else {
			return TRUE;
		}
	}

	/**
	 * Look if email and hash match with db
	 * @param Validation Validation object
	 * @param string field that all goes on
	 * @return boolean
	 */
	public function _code_match(Validation $array, $field){
		// Questing database for this user
		$user_exists = $this->db->from(self::TN_USERS)->where('email',$array[$field])->where('hash',$array['code'])->count_records();

		if($user_exists != 1){
			$array->add_error($field,'mismatch');
		} else {
			return TRUE;
		}
	}

	/**
	 * Look if email and password match
	 * @param Validation Validation object
	 * @param string field that all goes on
	 * @return boolean
	 */
	public function _password_match(Validation $array, $field){
		// Questing database for this user
		$user_exists = $this->db->from(self::TN_USERS)->where('email',$array['email'])->where('password',sha1($array[$field]))->count_records();

		if($user_exists != 1){
		 	$array->add_error($field,'old_wrong');
		} else {
		   	return TRUE;
		}
	}

	/**
	 * Look if email is in db
	 * @param Validation Validation object
	 * @param string field that all goes on
	 * @return boolean
	 */
	public function _email_exists(Validation $array, $field){
		// Questing database for this email
		$user_exists = $this->db->from(self::TN_USERS)->where('email',$array['email'])->count_records();

		if($user_exists != 1){
			$array->add_error($field,'not_exists');
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Return TRUE if user is not banned otherwise add error to form
	 * @param Validation Validation object
	 * @param string field that all goes on
	 * @return boolean
	 */
	public function _not_banned(Validation $array, $field){
		// Questing database for status of this user
		$permission = self::get_permission($array['email']);

		if($permission == 0){
			$array->add_error($field,'banned');
		} else {
			return TRUE;
		}
	}

	/**
	 * Check if mail do not exists in db
	 * @param Validation Validation object
	 * @param string field that all goes on
	 * @return boolean
	 */
	public function _email_not_exists(Validation $array, $field){
		// Questing database for this email
		$user_exists = $this->db->from(self::TN_USERS)->where('email',$array['email'])->count_records();

		if($user_exists == 1){
		 	$array->add_error($field,'exists');
		} else {
			return TRUE;
		}
	}

	/**
	 * Fetch permission of user from db
	 * @param string Email of user
	 * @return int
	 */
	public function get_permission($email){
		$row = (array) $this->db->select('permission')->from(self::TN_USERS)->where('email',$email)->limit(1)->get()->current();
		return $row['permission'];
	}

	/**
	* Return name of user from db (by email)
	* @param string email of user
	* @return string name of user
	*/
	public function get_name($email){
		$row = (array) $this->db->select('name')->from(self::TN_USERS)->where('email',$email)->limit(1)->get()->current();
		return $row['name'];
	}
	
	/**
	* Return id of user from db (by email)
	* @param string email of user
	* @return integer id of user
	*/
	public function get_id($email){
		$row = (array) $this->db->select('id')->from(self::TN_USERS)->where('email',$email)->limit(1)->get()->current();
		return $row['id'];
	}

	/**
	* Translate level of permission to human readable format
	* @param int level of permissions
	* @return string permission in readable format
	*/
	public function text_permission($permission){
		switch($permission){
		case 0: return Kohana::lang('user.banned');
			break;
		case 1: return Kohana::lang('user.ordinary');
			break;
		case 2: return Kohana::lang('user.got');
			break;
		}
	}

	/**
	 * New security hash for changing password
	 * @param string email of user
	 * @param string new hash
	 * @return void
	 */
	public function change_hash($email,$hash){
		$this->db->update(self::TN_USERS,array('hash' => $hash,'hash_time' => date("Y-m-d H:i:s")),array('email' => $email));
	}

	/**
	 * Change password of user (by email).
	 * @param string email of user
	 * @param string new password
	 * @return void
	 */
	public function change_password($email,$new){
		$this->db->update(self::TN_USERS,array('hash' => '','hash_time' => '','password' => sha1($new)),array('email' => $email));
	}

	/**
	 * Change data of user (only name)
	 * @param array array with post values
	 * @param string value of user in db
	 * @return void
	 */
	public function change_data($post,$email){
		$this->db->update(self::TN_USERS,array('name' => $post['fullname']),array('email' => $email));
	}

	/**
	 * Add user to db
	 * @param array Array with new data
	 * @return void
	 */
	public function register($post){
		$data = array(
			'created'  => date('Y-m-d H:i:s'),
			'email' => $post['email'],
			'password' => sha1($post['password']),
			'name' => $post['fullname'],
			'permission' => 1,
		);
		$this->db->insert(self::TN_USERS,$data);
	}
}
?>
