<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for products
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Product_Model extends Model {

    /**
     * Tables name
     */
    const TN_PRODUCT = "shop_product";
	const TN_PRODUCT_CAT = "shop_product_cat";

	/**
	 * Return data for one page of products
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 * @param array cats from which are products taken
	 */
	public function get($page,$per_page,$cats){
		$page = $page-1;
		$data = $this->db->select(self::TN_PRODUCT.'.id','name','short_description','manufacturer','price','news','tip','discount')->from(self::TN_PRODUCT)->orderby('name','ASC')->limit($per_page,$page*$per_page);
		$data->join(self::TN_PRODUCT_CAT,self::TN_PRODUCT.'.id',self::TN_PRODUCT_CAT.'.product');
		if(is_array($cats)){
			foreach ($cats as $cat){
				$data->orwhere(self::TN_PRODUCT_CAT.'.cat',$cat);
			}
		} else {
			$data->where(self::TN_PRODUCT_CAT.'.cat',$cats);
		}
		$data->where('hidden !=', 1);
		$data = $data->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
	
	/**
	 * Return one product
	 * @return array query data
	 * @param integer ID of product
	 */
	public function get_one($id){
		$data = (array) $this->db->select(self::TN_PRODUCT.'.id','name','short_description','description','manufacturer','price','news','tip','discount')->from(self::TN_PRODUCT)->where('id',$id)->get()->current();
		return $data;
	}
	
	/**
	 * Return all products
	 * @return array query aray
	 */
	public function get_all(){
		$data = $this->db->select(self::TN_PRODUCT.'.id','name','short_description','price')->from(self::TN_PRODUCT)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Count products
	 * @return integer number of products
	 */
	public function count($cats){
		 $num = $this->db->select(self::TN_PRODUCT.'.id')->from(self::TN_PRODUCT);
		 $num->join(self::TN_PRODUCT_CAT,self::TN_PRODUCT.'.id',self::TN_PRODUCT_CAT.'.product');
		 foreach ($cats as $cat){
			$num->orwhere(self::TN_PRODUCT_CAT.'.cat',$cat);
		 }
		 $num = $num->get()->count();
		 return $num;
	}
	
	/**
	 * Add new product
	 * @return id of new product 
	 * @param object $post array with new values
	 */
	public function add_data($post){
		// Add product to db
		$id =  $this->db->insert(self::TN_PRODUCT,array('name' => $post['name'], 'manufacturer' => $post['manufacturer'],'short_description' => $post['short_description'], 'description' => $post['description'],'price' => $post['price'], 'news' => isset($post['news']), 'tip' => isset($post['tip']), 'discount' => isset($post['discount'])))->insert_id();
		if(!empty($id)){
			// Add product to cats
			foreach($post['cat'] as $row){
				$this->db->insert(self::TN_PRODUCT_CAT,array('product' => $id, 'cat' => $row));
			}
		}
		return $id;
	}
	
	/**
	 * Return cats of product
	 * @return array of cats
	 */
	public function get_product_cat($id){
		$data = $this->db->select('cat')->from(self::TN_PRODUCT_CAT)->where('product',$id)->get();
		$data->result(FALSE); // make array from object
		$cats = array();
		foreach($data as $cat){
			$cats[] = $cat['cat'];
		}
		return $cats;
	}
	
	/**
	 * Edit product
	 * @return void
	 * @param object $post array with new values
	 * @param id of changed product
	 */
	public function change_data($post,$id){
		// update data
		$this->db->update(self::TN_PRODUCT,array('name' => $post['name'],'short_description' => $post['short_description'], 'manufacturer' => $post['manufacturer'], 'description' => $post['description'],'price' => $post['price'], 'news' => isset($post['news']), 'tip' => isset($post['tip']), 'discount' => isset($post['discount'])),array('id' => $id));
		// remove cats - products entries 
		$this->db->delete(self::TN_PRODUCT_CAT,array('product' => $id));
		// add new one
		foreach($post['cat'] as $row){
			$this->db->insert(self::TN_PRODUCT_CAT,array('product' => $id, 'cat' => $row));
		}
	}
	
	/**
	 * Delete product
	 * @param id of product
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_PRODUCT,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			$this->db->delete(self::TN_PRODUCT_CAT,array('product' => $id));
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return data for one page of products search
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 * @param string searched text
	 */
	public function search($value){
		$data = $this->db->select(self::TN_PRODUCT.'.id','name','short_description','manufacturer','price','news','tip','discount')->from(self::TN_PRODUCT);
		$data->orlike('name',$value);
		$data->orlike('short_description',$value);
		$data->orlike('description',$value);
		$data->orlike('price',$value);
		$data = $data->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
	
	/**
	 * Return products with given flag
	 * @return array query aray
	 * @param string flag (column) which is set to TRUE.
	 * @param integer number od products
	 */
	public function get_flag($flag,$num){
		$data = $this->db->select(self::TN_PRODUCT.'.id','name','short_description','price','discount','news','tip')->where($flag,1)->orderby('id','DESC')->from(self::TN_PRODUCT)->limit($num)->get();
		$data->result(FALSE);
		return $data;
	}
}
