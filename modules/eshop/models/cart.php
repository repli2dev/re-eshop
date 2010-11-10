<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for shopping cart
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class Cart_Model extends Model {

    /**
     * Table name
     */
    const TN_CART = "shop_cart";
	
	/**
	 * Add item to cart
	 * @return void
	 * @param integer id of product
	 */
	public function add($id){
		$exists = self::exists($id);
		$data = array(
			'user' => user::user_id(),
			'product' => $id,
			'quantity' => '1'
		);
		if($exists){
			$data['quantity'] = self::getQuantity($id)+1;
			$this->db->update(self::TN_CART,$data,array('id' => $exists));
			print_r($data);
		} else {
			$this->db->insert(self::TN_CART,$data);
		}
	}
	
	/**
	 * Delete item from cart
	 * @return void
	 * @param integer id of product
	 */
	public function del($id){
		$user = user::user_id();
		$data = $this->db->delete(self::TN_CART,array('user' => $user,'product' => $id));
	}
	
	/**
	 * Return true if there is the same product in cart
	 * @return boolean or ID of product
	 * @param integer id of product
	 */
	public function exists($id){
		$user = user::user_id();
		$row = (array) $this->db->select('id')->from(self::TN_CART)->where('user',$user)->where('product',$id)->get()->current();
		if(!empty($row['id'])){
			return $row['id'];
		} else {
			return FALSE;
		}
	}
	
	/** 
	 * Return quantity of item
	 * @return integer quantity
	 * @param integer id of product
	 */
	public function get_quantity($id){
		$user = user::user_id();
		$row = (array) $this->db->select('quantity')->from(self::TN_CART)->where('user',$user)->where('product',$id)->get()->current();
		return $row['quantity'];
	}
	
	/**
	 * Set quantity of item
	 * @return void
	 * @param integer id of product
	 * @param integer new quantity
	 */
	public function set_quantity($id,$quantity){
		$user = user::user_id();
		$data = array(
			'quantity' => $quantity,
		);
		$cond = array(
			'product' => $id
		);
		$this->db->update(self::TN_CART,$data,$cond);
	}
	
	/**
	 * Return all items in cart
	 * @return array query data
	 */
	public function get_cart(){
		$user = user::user_id();
		$data = $this->db->select('*')->from(self::TN_CART)->where('user',$user)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Delete all items in the cart
	 * @return void
	 */
	public function empty_cart(){
		$user = user::user_id();
		$data = $this->db->delete(self::TN_CART,array('user' => $user));
	}
	
	/**
	 * Count total of cart
	 * @return integer amount
	 */
	public function get_total(){
		$data = self::get_cart();
		$total = 0;
		foreach($data as $row){
			$total = $total + (product::get_price($row['product'])*$row['quantity']);
		}
		return $total;
	}
	
	/**
	 * Change quantity of all items in cart
	 * @return void
	 * @param array items and their new quantity
	 */
	public function change_quantity($post){
		foreach(($post['quantity']) as $product => $quantity){
			if($quantity <= 0){ // remove if quantity bellow or equal to 0
				self::del($product);
			} else {
				self::set_quantity($product,$quantity);
			}
		}
	}
	
	/**
	 * Return number of items in the cart
	 * @return void
	 */
	public function count_cart(){
		$data = self::get_cart();
		return count($data);
	}
	
	/**
	 * Remove items older than 7 days
	 * @return void
	 */
	public function delete_old(){
		$time = time() - 7*24*60*60;
		$time = date("Y-m-d H:i:s", $time);;
		$data = $this->db->delete(self::TN_CART,array('time <' => $time));
	}
}
