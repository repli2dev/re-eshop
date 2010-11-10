<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model - shipping
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Shipping_Model extends Model {

    /**
     * Table name
     */
    const TN_SHIPPING = "shop_shipping";
	
	/**
	 * Return default method of shipping
	 * @return integer id of default method
	 */
	public function get_default(){
		$row = (array) $this->db->select('id')->from(self::TN_SHIPPING)->where(array('default' => 1,'hidden' => 0))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['id'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return all methods of shipping
	 * @return array query data
	 */
	public function get_all(){
		$data = $this->db->select('*')->from(self::TN_SHIPPING)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Callback - check if shipping exists in db
	 * @return void
	 * @param integer id of shipping method 
	 */
	public function _exists(Validation $post){
		// If add->rules validation found any errors, get me out of here!
		if (array_key_exists('shipping', $post->errors()))
			return;
		// Check if shipping method exists
		$data = $this->db->select('id')->from(self::TN_SHIPPING)->where('id',$post['shipping'])->get();
		if (count($data) <= 0){
			// Add a validation error, this will cause $post->validate() to return FALSE
			$post->add_error( 'shipping', 'required');
		}
	}
	
	/**
	 * Return name of shipping method
	 * @return string name
	 * @param integer id of shipping method
	 */
	public function get_name($id){
		$row = (array) $this->db->select('name')->from(self::TN_SHIPPING)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['name'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Add new shipping
	 * @return integer id of new shipping 
	 * @param array $post array with new values
	 */
	public function add_data($post){
		return $this->db->insert(self::TN_SHIPPING,array('name' => $post['name'],'hidden' => $post['hidden'],'default' => $post['default']))->insert_id();		
	}
	
	/**
	 * Edit shipping
	 * @return void
	 * @param array $post array with new values
	 * @param integer id of changed shipping
	 */
	public function change_data($post,$id){
		$this->db->update(self::TN_SHIPPING,array('name' => $post['name'],'hidden' => $post['hidden'],'default' => $post['default']),array('id' => $id));		
	}
	
	/**
	 * Delete shipping
	 * @param integer id of shipping
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_SHIPPING,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return one shipping method
	 * @return array query dat
	 * @param integer ID of shipping method
	 */
	public function get_one($id){
		$data = $this->db->select('*')->from(self::TN_SHIPPING)->where('id',$id)->get();
		$data->result(FALSE);
		return $data;
	}
}
