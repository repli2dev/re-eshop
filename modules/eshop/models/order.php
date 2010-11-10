<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model - order
 *
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Order_Model extends Model {

    /**
     * Table names
     */
    const TN_ORDER = "shop_order";
	const TN_ORDER_PRODUCT = "shop_order_product"; 
	
	/**
	 * Add order to database
	 * @return integer id of new order;
	 * @param object post data
	 * @param array profile data
	 * @param array cart items
	 */
	public function add_data($post,$profile,$cart){
		// assign proper data
		$data = array(
			'customer_name' => $profile['name'],
			'customer_street' => $profile['customer_street'],
			'customer_city' => $profile['customer_city'],
			'customer_postal_code' => $profile['customer_postal_code'],
			'customer_email' => $profile['email'],
			'customer_phone' => $profile['customer_phone'],
			'billing_name' => $profile['billing_name'],
			'billing_street' => $profile['billing_street'],
			'billing_city' => $profile['billing_city'],
			'billing_postal_code' => $profile['billing_postal_code'],
			'billing_identity_number' => $profile['billing_identity_number'],
			'billing_vat_number' => $profile['billing_vat_number'],
			'delivery_name' => $post['delivery_name'],
			'delivery_street' => $post['delivery_street'],
			'delivery_city' => $post['delivery_city'],
			'delivery_postal_code' => $post['delivery_postal_code'],
			'shipping' => $post['shipping'],
			'payment' => $post['payment'],
			'user' => $profile['id'],
			'status_order' => 'none',
			'status_payment' => 'none'
		);
		// make order
		$query = $this->db->insert(self::TN_ORDER,$data);
		$order = $query->insert_id();
		// add products to the order
		foreach($cart as $row){
			$data = array(
				'order' => $order,
				'product' => $row['product'],
				'quantity' => $row['quantity']
			);
			$this->db->insert(self::TN_ORDER_PRODUCT,$data);
		}
		
		return $order;
	}
	
	/**
	 * Return data for one page of orders
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 * @param integer ID of user
	 */
	public function get($page,$per_page,$user = NULL){
		$page = $page-1;
		if($user){
			$cond = array('user' => $user);
		} else {
			$cond = 1;
		}
		$data = $this->db->select('*')->from(self::TN_ORDER)->where($cond)->orderby('last_change','DESC')->limit($per_page,$page*$per_page)->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
	
	/**
	 * Count items
	 * @return integer number of items
	 * @param integer ID of user
	 */
	public function count($user = NULL){
		if($user){
			$cond = array('user' => $user);
		} else {
			$cond = 1;
		}
		$num = $this->db->select('id')->from(self::TN_ORDER)->where($cond)->get()->count();
		return $num;
	}
	
	/**
	 * Return id of payment method
	 * @return integer payment method
	 */
	public function get_payment($id){
		$row = (array) $this->db->select('payment')->from(self::TN_ORDER)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['payment'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return one order
	 * @return array query data
	 * @param integer ID of order
	 */
	public function get_one($id,$user = NULL){
		$cond = array('id' => $id);
		if($user){
			$cond['user'] = $user;
		}
		$data = (array) $this->db->select('*')->from(self::TN_ORDER)->where($cond)->get()->current();
		return $data;
	}
	
	/**
	 * Return ordered items
	 * @return array query data
	 * @param integer ID of order
	 */
	public function get_one_ordered($id){
		$data = $this->db->select('*')->from(self::TN_ORDER_PRODUCT)->where(array('order' => $id))->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Count total of order
	 * @return integer amount
	 */
	public function get_total($id){
		//TODO: Think about too often changing prices
		$data = self::get_one_ordered($id);
		$total = 0;
		foreach($data as $row){
			$total = $total + (product::get_price($row['product'])*$row['quantity']);
		}
		return $total;
	}
	
	/**
	 * Change payment status
	 * @return void
	 * @param integer id of order
	 * @param string new status
	 */
	public function change_payment($id,$new){
		$this->db->update(self::TN_ORDER,array('status_payment' => $new),array('id' => $id));
	}
	
	/**
	 * Change status of order
	 * @return void
	 * @param integer id of order
	 * @param string new status
	 */
	public function change_order($id,$new){
		$this->db->update(self::TN_ORDER,array('status_order' => $new),array('id' => $id));
	}
	
	/**
	 * Return status of payment
	 * @return string status
	 * @param integer id of order
	 */
	public function get_status($id){
		$row = (array) $this->db->select('status_payment')->from(self::TN_ORDER)->where(array('id' => $id))->limit(1)->get()->current();
		if(count($row) > 0){
			return $row['status_payment'];
		} else {
			return FALSE;
		}
	}
	
}
