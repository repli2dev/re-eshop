<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model - manufacturer
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Manufacturer_Model extends Model {

    /**
     * Table name
     */
    const TN_MANUFACTURER = "shop_manufacturer";
	
	
	/**
	 * Return all manufacturers
	 * @return array query data
	 */
	public function get_all(){
		$data = $this->db->select('*')->from(self::TN_MANUFACTURER)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Return one manufacturer
	 * @return array query dat
	 * @param integer ID of manufacturer
	 */
	public function get_one($id){
		$data = $this->db->select('*')->from(self::TN_MANUFACTURER)->where('id',$id)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Add new manufacturer
	 * @return integer id of new manufacturer 
	 * @param object $post array with new values
	 */
	public function add_data($post){
		return $this->db->insert(self::TN_MANUFACTURER,array('name' => $post['name']))->insert_id();		
	}
	
	/**
	 * Edit manufacturer
	 * @return void
	 * @param array $post array with new values
	 * @param id of changed category
	 */
	public function change_data($post,$id){
		$this->db->update(self::TN_MANUFACTURER,array('name' => $post['name']),array('id' => $id));		
	}
	
	/**
	 * Delete manufacturer
	 * @param integer id of manufacturer
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_MANUFACTURER,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return manufacturers suitable for <select>
	 * @return array data
	 */
	public function get_selection(){
		$selection = self::get_all();
		$new[0] = '-';
		foreach($selection as $row){
			$new[$row['id']] = $row['name'];
		} 
		return $new;
	}
	
	/**
	 * Return name of manufacturer
	 * @return string name
	 * @param integer id of manufacturer
	 */
	public function get_name($id){
		$row = (array) $this->db->select('name')->from(self::TN_MANUFACTURER)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['name'];
		} else {
			return FALSE;
		}
	}
}
