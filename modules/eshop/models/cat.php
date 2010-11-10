<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for categories
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Cat_Model extends Model {

    /**
     * Table name
     */
    const TN_CAT = "shop_cat";

	/**
	 * Return all categories with defined parent
	 * @return array query data
	 * @param integer parent of ID cat
	 */
	public function get_all($parent){
		$data = $this->db->select('id','name')->from(self::TN_CAT)->where('parent',$parent)->orderby('name','ASC')->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
	
	/**
	 * Return one category
	 * @return array query data
	 * @param integer ID of cat
	 */
	public function get_one($id){
		$data = (array) $this->db->select('id','name','parent')->from(self::TN_CAT)->where('id',$id)->get()->current();
		return $data;
	}
	
	/**
	 * Return TRUE if cat has any child(ren)
	 * @return 
	 * @param integer $id
	 */
	public function has_child($id){
		$data = $this->get_children($id);
		if(count($data) > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return IDs of nearest children
	 * @return array of children id
	 * @param integer id of parent
	 */
	public function get_children($id){
		$data = $this->db->select('id')->from(self::TN_CAT)->where('parent',$id)->orderby('name','ASC')->get();
		$data->result(FALSE); // make array from object
		return $data;	
	}
	
	/**
	 * Return array with ID of cat and all of its subcats and their subcats...
	 * @return array with all subcats (to infinity depth)
	 * @param object $id
	 */
	public function get_all_cats_in_depth($id){
		$cat = new Cat_Model; // FIXME: Test if self:: is enough
		$all_cats[] = $id;
		if($cat->has_child($id)){
			$children = $cat->get_children($id);
			foreach($children as $child){
				$temp = self::get_all_cats_in_depth($child['id']); //recursion
				$all_cats = array_merge($all_cats,$temp);
				unset($temp);
			}
			unset($children);
		}
		return $all_cats;
	}
	
	/**
	 * Return ID of all cats
	 * @return array
	 */
	public function get_all_cats(){
		$cat = new Cat_Model;
		$root = $cat->get_all(0); //get all on root level
		$all_cats[] = '';
		foreach($root as $row){
			$temp = self::get_all_cats_in_depth($row['id']);
			$all_cats = array_merge($all_cats,$temp);
			unset($temp); 
		}
		return array_filter($all_cats); // also filter empty values	
	}
	
	/**
	 * Return array with ID and names 
	 * @return 
	 * @param object $ids
	 */
	public function add_names($ids){
		foreach($ids as $row){
			$ids[$row] = cat::get_name($row);
		}
		// solving problem with gaps
		$new = array();
		foreach($ids as $key => $value){
			if(!is_numeric($value)){
				$new[$key] = $value;
			}
		}
		return $new;
	}
	
	/**
	 * Add new category
	 * @return id of new category 
	 * @param object $post array with new values
	 */
	public function add_data($post){
		return $this->db->insert(self::TN_CAT,array('name' => $post['name'], 'parent' => $post['parent']))->insert_id();		
	}
	
	/**
	 * Edit category
	 * @return void
	 * @param object $post array with new values
	 * @param id of changed category
	 */
	public function change_data($post,$id){
		$this->db->update(self::TN_CAT,array('name' => $post['name'], 'parent' => $post['parent']),array('id' => $id));		
	}
	
	/**
	 * Delete category
	 * @param id of category
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_CAT,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}
