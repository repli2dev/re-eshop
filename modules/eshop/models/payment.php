<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model - payment
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Payment_Model extends Model {

    /**
     * Table name
     */
    const TN_PAYMENT = "shop_payment";
	
	/**
	 * Return default method of payment
	 * @return integer id of default method
	 */
	public function get_default(){
		$row = (array) $this->db->select('id')->from(self::TN_PAYMENT)->where(array('default' => 1,'hidden' => 0))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['id'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return all methods of payment
	 * @return array query data
	 */
	public function get_all(){
		$data = $this->db->select('*')->from(self::TN_PAYMENT)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Callback - check if payment exists in db
	 * @return void
	 * @param integer id of payment method 
	 */
	public function _exists(Validation $post){
		// If add->rules validation found any errors, get me out of here!
		if (array_key_exists('payment', $post->errors()))
			return;
		// Check if shipping method exists
		$data = $this->db->select('id')->from(self::TN_PAYMENT)->where('id',$post['payment'])->get();
		if (count($data) <= 0){
			// Add a validation error, this will cause $post->validate() to return FALSE
			$post->add_error( 'payment', 'required');
		}
	}
	
	/**
	 * Return type of payment method (pre,post)
	 * @return string type
	 * @param integer id of payment method
	 */
	public function get_type($id){
		$row = (array) $this->db->select('type')->from(self::TN_PAYMENT)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['type'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return name of payment method
	 * @return string name
	 * @param integer id of payment method
	 */
	public function get_name($id){
		$row = (array) $this->db->select('name')->from(self::TN_PAYMENT)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['name'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return info of payment method
	 * @return string info
	 * @param integer id of payment method
	 */
	public function get_info($id){
		$row = (array) $this->db->select('info')->from(self::TN_PAYMENT)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			if(!empty($row['info'])){
				return $row['info'];
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Add new payment
	 * @return integer id of new payment 
	 * @param array $post array with new values
	 */
	public function add_data($post){
		return $this->db->insert(self::TN_PAYMENT,array('name' => $post['name'],'hidden' => $post['hidden'],'default' => $post['default'],'info' => $post['info'],'type' => $post['type']))->insert_id();		
	}
	
	/**
	 * Edit payment
	 * @return void
	 * @param array $post array with new values
	 * @param integer id of changed payment
	 */
	public function change_data($post,$id){
		$this->db->update(self::TN_PAYMENT,array('name' => $post['name'],'hidden' => $post['hidden'],'default' => $post['default'],'info' => $post['info'],'type' => $post['type']),array('id' => $id));		
	}
	
	/**
	 * Delete payment
	 * @param integer id of payment
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_PAYMENT,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return one payment method
	 * @return array query dat
	 * @param integer ID of payment method
	 */
	public function get_one($id){
		$data = $this->db->select('*')->from(self::TN_PAYMENT)->where('id',$id)->get();
		$data->result(FALSE);
		return $data;
	}
}
