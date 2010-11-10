<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for shopping cart
 * 
 * @package    Eshop
 * @author     Jan Drábek
 * @copyright  (c) 2009 Jan Drábek
 * @license    /Re-eshop License.html
 */

class Cart_Controller extends Base_Controller {
	/**
	 * @var cart model
	 */
	public $cart;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.cart'), '/cart/show');
		
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
		$this->cart = new Cart_Model;
	}
	
	/**
	 * Index is redirecting to cart
	 * @return void
	 */
	public function index(){
		url::redirect('/cart/show');
	}
	
	/**
	 * Add item to shopping cart
	 * @return void
	 * @param integer id of product
	 */
	public function add($id){
		// Check user permission
		if(user::is_logged()){
			$this->cart->add($id);
			url::redirect('/cart/show');
		} else {
			url::redirect('/user/login/login');
		}
	}
	
	/**
	 * Show shopping cart
	 * @return void 
	 * @param string state to show 
	 */
	public function show($state = NULL){
		// Check for user permission
		if(user::is_logged()){
			// Messages about success
			$success = array();
			if($state == "changed") $success[] = Kohana::lang('eshop.quantity_changed');
			
			// Settings
			$this->set_title(Kohana::lang('eshop.cart'));
			$this->add_breadcrumb(Kohana::lang('eshop.show'), '/cart/show');
			
			// Actions
			if($_POST){
				if(isset($_POST['change'])){
					if(!empty($_POST['quantity'])){
						$this->cart->change_quantity($_POST);
					}
				} else
				if(isset($_POST['empty'])){
					$this->cart->empty_cart();
				} else 
				if(isset($_POST['checkout'])){
					if(!empty($_POST['quantity'])){
						$this->cart->change_quantity($_POST);
					}
					url::redirect('/cart/checkout');
				}
			}
			// View
			$this->template->content = new View('cart_show');
			$this->template->content->cart = $this->cart->get_cart();
			$this->template->content->total = $this->cart->get_total();
			$this->template->content->success = $success;
			
		} else {
			url::redirect('/user/login/login');
		}
	}
	
	/**
	 * Checkout 
	 * @return void
	 */
	public function checkout(){
		// Check user permission
		if(user::is_logged()){
			if($this->cart->count_cart() != 0){
				$customer = new Customer_Model;
				if($customer->has_info()){ // check if customer profile is set (at least personal informations)
					// Settings
					$this->set_title(Kohana::lang('eshop.checkout'));
					$this->add_breadcrumb(Kohana::lang('eshop.checkout'), '/cart/checkout');
					
					// Other needed models, and data
					$shipping = new Shipping_Model;
					$payment = new Payment_Model;
					$order = new Order_Model;
					
					// Fetching values
					$cart = $this->cart->get_cart();
					$total = $this->cart->get_total();
					$shipping_methods = $shipping->get_all();
					$payment_methods = $payment->get_all();
					$profile = $customer->get_profile(user::user_id()); 
					
					// Default values
					$form = array(
						'delivery_name' => $profile['name'],
						'delivery_street' => $profile['customer_street'],
						'delivery_city' => $profile['customer_city'],
						'delivery_postal_code' => $profile['customer_postal_code'],
						'shipping' => $shipping->get_default(),
						'payment' => $payment->get_default(),
					);
					$errors = array();
					
					// Validation
					if ($_POST){
						$post = new Validation($_POST);
						// Some filters
						$post->pre_filter('trim', TRUE);
						// Rules
						$post->add_rules('delivery_name','required','length[0,255]');
						$post->add_rules('delivery_street','required');
						$post->add_rules('delivery_city','required');
						$post->add_rules('delivery_postal_code','required','length[0,255]');
						$post->add_rules('shipping','required');
						$post->add_callbacks('shipping', array($shipping, '_exists'));
						$post->add_rules('payment','required');
						$post->add_callbacks('payment', array($payment, '_exists'));
						if($post->validate()){
							// Everything seems to be ok, insert to db
							$id = $order->add_data($post,$profile,$cart);
							$this->cart->empty_cart();
							// Now payment
							url::redirect('/cart/payment/'.$id);
						} else {
							// Repopulate form with error and original values
							$form = arr::overwrite($form, $post->as_array());
							$errors = $post->errors('cart_checkout_errors');
						}
					}
					// View
					$this->template->content = new View('cart_checkout');
					$this->template->content->cart = $cart;
					$this->template->content->total = $total;
					$this->template->content->profile = $profile;
					$this->template->content->shipping_methods = $shipping_methods;
					$this->template->content->payment_methods = $payment_methods;
					$this->template->content->form = $form;
					$this->template->content->errors = $errors;
				} else {
					url::redirect('/customer/profile/needed');
				}
			} else {
				url::redirect('/cart/show');
			}
		} else {
			url::redirect('/user/login/login');
		}
	}
	
	/**
	 * Payment
	 * @param id of order
	 * @return void
	 */
	public function payment($id){
		// Check user permission
		if(user::is_logged()){
			$payment = new Payment_Model;
			$order = new Order_Model;
			$payment_id = $order->get_payment($id);
			$shipping = new Shipping_Model;
			if($payment->get_type($payment_id) == "pre"){ // Paying inside shop (e.g. paypal, credit card) //continue here
				if($order->get_status($id) == "none"){
					// go to payment now
					// TODO: payment module implementation	
				} else {
					// Settings & View
					$this->set_title(Kohana::lang('eshop.already_paid'));
					$this->add_breadcrumb(Kohana::lang('eshop.already_paid'), NULL);
					$this->template->content = new View('cart_paid');	
				}
			} else { // Paying outside shop (e.g. bank transfer) => finish here
				// Show message about success
				// Settings & View
				$this->set_title(Kohana::lang('eshop.payment'));
				$this->add_breadcrumb(Kohana::lang('eshop.payment'), '/cart/payment');
				$this->template->content = new View('cart_post');
				$this->template->content->vsymbol = $id;
				$this->template->content->payment = $payment->get_info($payment_id);
			}
		}
	}
}
?>
