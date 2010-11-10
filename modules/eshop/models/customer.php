<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for products
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Customer_Model extends Model {

    /**
     * Tables
     */
    const TN_EXTEND = "shop_user_extend";
	const TN_USER = "users";
	
	/**
	 * Return user profile
	 * @return array query data
	 * @param string user email
	 */
	public function get_one($email){
		$user = new User_Model;
		$id = $user->get_id($email);
		$data = (array) $this->db->select('*')->from(self::TN_EXTEND)->where('user',$id)->get()->current();
		return $data;
	}
	
	/**
	 * Return TRUE if user profile exists
	 * @return boolean 
	 * @param string email of user
	 */
	public function profile_exists($email){
		$user = new User_Model;
		$id = $user->get_id($email);
		$num = (int) $this->db->select('*')->from(self::TN_EXTEND)->where('user',$id)->get()->count();
		if($num > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return user whole profile
	 * @return array query data
	 * @param integer user id
	 */
	public function get_profile($id){
		$data = (array) $this->db->select('*')->from(self::TN_EXTEND)->where('user',$id)->join(self::TN_USER,self::TN_EXTEND.'.user',self::TN_USER.'.id')->get()->current();
		return $data;
	}
	
	/**
	 * Change user profile
	 * @param array post data
	 * @param string user id
	 */
	public function change_data($post,$email){
		$user = new User_Model;
		$id = $user->get_id($email);
		if(self::profile_exists($email)){ //update data
			$data = array(
				'customer_street' => $post['customer_street'],
				'customer_city' => $post['customer_city'],
				'customer_postal_code' => $post['customer_postal_code'], 
				'customer_phone' => $post['customer_phone'],
				'billing_name' => $post['billing_name'],
				'billing_street' => $post['billing_street'],
				'billing_city' => $post['billing_city'],
				'billing_postal_code' => $post['billing_postal_code'],
				'billing_identity_number' => $post['billing_identity_number'],
				'billing_vat_number' => $post['billing_vat_number'],
			);
			$this->db->update(self::TN_EXTEND,$data,array('user' => $id));
		} else { //create data
			$data['user'] = $id;
			$this->db->insert(self::TN_EXTEND,$data);
		}
	}
	
	/**
	 * Return data for one page of users
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 */
	public function get($page,$per_page){
		$page = $page-1;
		$data = $this->db->select('*')->from(self::TN_USER)->where(1)->orderby('name','ASC')->limit($per_page,$page*$per_page)->get();
		$data->result(FALSE); // Make array from object
		return $data;
	}
	
	/**
	 * Count users in database
	 * @return integer number of users
	 */
	public function count(){
		$num = $this->db->select('id')->from(self::TN_USER)->where(1)->get()->count();
		return $num;
	}
	
	/**
	 * Ban user
	 * @return void 
	 * @param integer ID of user
	 */
	public function ban($user){
		$this->db->update(self::TN_USER,array('permission' => 0),array('id' => $user));
	}
	
	/**
	 * Unban user
	 * @return void 
	 * @param integer ID of user
	 */
	public function unban($user){
		$this->db->update(self::TN_USER,array('permission' => 1),array('id' => $user));
	}
	
	/**
	 * Return TRUE if user has filled all necessary informations for checkout
	 * @return boolean
	 */
	public function has_info(){
		$user = user::user_id();
		$profile = self::get_profile($user);
		if($profile['name'] AND $profile['customer_street'] AND $profile['customer_city'] AND $profile['customer_postal_code']){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
