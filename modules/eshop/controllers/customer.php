<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for customers (profile, administration of customers)
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Customer_Controller extends Base_Controller {
	
	/**
	 * @var customer model
	 */ 
	private $customer;
	
	/**
	 * Items per page
	 */
	const PER_PAGE = 50;
	
	public function __construct(){
		parent::__construct();
		$this->add_breadcrumb(Kohana::lang('eshop.customer'), '/customer/profile');
	
		// Adding extra css file
		$this->add_css('/modules/eshop/css/eshop.css');
		$this->customer = new Customer_Model();
	}
	
	/**
	 * Index redirect to profile
	 * @return 
	 */
	public function index(){
		url::redirect('/customer/profile');
	}
	
	/**
	 * Customer profile
	 * @return void
	 * @param state to show after return
	 */
	public function profile($state = NULL){
		// Messages about success
		$success = array();
		if($state == "changed") $success[] = Kohana::lang('eshop.succesfully_changed');
		
		// Check user permission
		if(user::is_logged()){
			// Settings
			$this->set_title(Kohana::lang('eshop.customer_profile'));
			$this->add_breadcrumb(Kohana::lang('eshop.profile'), url::current());
			
			// Default values
			if($this->customer->profile_exists(user::user_email())){ 
				$row = $this->customer->get_one(user::user_email());
				$form = array(
					'customer_street' => $row['customer_street'],
					'customer_city' => $row['customer_city'],
					'customer_postal_code' => $row['customer_postal_code'], 
					'customer_phone' => $row['customer_phone'],
					'billing_name' => $row['billing_name'],
					'billing_street' => $row['billing_street'],
					'billing_city' => $row['billing_city'],
					'billing_postal_code' => $row['billing_postal_code'],
					'billing_identity_number' => $row['billing_identity_number'],
					'billing_vat_number' => $row['billing_vat_number'],
				);
			} else { // empty data
				$form = array(
					'customer_street' => '',
					'customer_city' => '',
					'customer_postal_code' => '', 
					'customer_phone' => '',
					'billing_name' => '',
					'billing_street' => '',
					'billing_city' => '',
					'billing_postal_code' => '',
					'billing_identity_number' => '',
					'billing_vat_number' => '',
				);	
			}
			$errors = array();
			if($state == "needed") $errors[] = Kohana::lang('eshop.informations_needed');
			
			// Validation
			if ($_POST){
				$post = new Validation($_POST);
				// Some filters
				$post->pre_filter('trim', TRUE);
				// Rules
				$post->add_rules('customer_street','required');
				$post->add_rules('customer_city','required');
				$post->add_rules('customer_postal_code','required','length[0,255]');
				
				$post->add_rules('billing_name','length[0,255]');
				$post->add_rules('billing_postal_code','length[0,255]');
				$post->add_rules('billing_identity_number','length[0,8]');
				$post->add_rules('billing_vat_number','length[0,12]');
				if($post->validate()){
					// Everything seems to be ok, insert to db
					$this->customer->change_data($post,user::user_email());
					url::redirect('/customer/profile/changed');
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $post->as_array());
					$errors = $post->errors('customer_errors');
					$success = array();
				}
			}
			// View
			$this->template->content = new View('customer_profile');
			$this->template->content->form = $form;
			$this->template->content->errors = $errors;
			$this->template->content->success = $success;
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Print user detail
	 * @param integer ID of user
	 * @return void
	 */
	public function detail($user){
		// Check user permission
		if(user::is_got()){
			// Model
			$order = new Order_Model; 
			
			// Settings
			$this->set_title(Kohana::lang('eshop.detail'));
			$this->add_breadcrumb(Kohana::lang('eshop.detail'), url::current());
			
			// Fetch data & View
			$row = $this->customer->get_profile($user,TRUE);
			$num_orders = $order->count($user);
			
			if(empty($row['name'])){
				$this->template->content = new View('admin/customer_nodetail');
			} else {
				$this->template->content = new View('admin/customer_detail');
				$this->template->content->row = $row;
				$this->template->content->num_orders = $num_orders;
			}
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Show list of users
	 * @return void
	 * @param integer number of page to show
	 */
	public function show($page = 1,$state = NULL){
		// Check use permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.customers_list'));
			$this->add_breadcrumb(Kohana::lang('eshop.list'), url::current());
			
			// Fetching data & View
			$data = $this->customer->get($page,self::PER_PAGE);
			$this->template->content = new View('admin/customer_list');
			$this->template->content->data = $data;
			
			//Pagination
			$this->pagination = new Pagination(array(
			    'uri_segment'    => 'show',
			    'total_items'    => $this->customer->count(),
			    'items_per_page' => self::PER_PAGE,
			    'style'          => 'digg'
			));
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Ban user
	 * @param integer ID of user
	 * @return void
	 */
	public function ban($user){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.customer_ban'));
			$this->add_breadcrumb(Kohana::lang('eshop.ban'), url::current());
			
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = ban
					$this->customer->ban($user);
					url::redirect('/customer/show/1/banned');
				} else {
					url::redirect('/customer/show');
				}
			}
			// View
			$this->template->content = new View('admin/customer_ban');
		} else {
			url::redirect('/denied');
		}
	}	
	
	/**
	 * Unban user
	 * @param integer ID of user
	 * @return void
	 */
	public function unban($user){
		// Check user permission
		if(user::is_got()){
			// Settings
			$this->set_title(Kohana::lang('eshop.customer_unban'));
			$this->add_breadcrumb(Kohana::lang('eshop.unban'), url::current());
			
			if($_POST){
				if(isset($_POST['yes'])){ // clicked on yes = unban
					$this->customer->unban($user);
					url::redirect('/customer/show/1/unbanned');
				} else {
					url::redirect('/customer/show');
				}
			}
			// page
			$this->template->content = new View('admin/customer_unban');
		} else {
			url::redirect('/denied');
		}
	}	
	
	/**
	 * Show list of user's orders
	 * @return void
	 * @param integer number of page to show
	 */
	public function orders($page = 1){
		// Check user permission
		if(user::is_logged()){
			// Aditional model
			$order = new Order_Model;
			
			// Settings
			$this->set_title(Kohana::lang('eshop.customer_orders'));
			$this->add_breadcrumb(Kohana::lang('eshop.orders'), url::current());
			
			// Fetch data
			$data = $order->get($page,self::PER_PAGE,user::user_id());
			
			// View
			$this->template->content = new View('customer_orders');
			$this->template->content->data = $data;
			$this->template->content->heading = Kohana::lang('eshop.customer_orders');
			$this->template->content->controller = 'customer';
			
			//Pagination
			$this->pagination = new Pagination(array(
			    'uri_segment'    => 'orders',
			    'total_items'    => $order->count(user::user_id()),
			    'items_per_page' => self::PER_PAGE,
			    'style'          => 'digg'
			));
		} else {
			url::redirect('/denied');
		}
	}
	
	/**
	 * Show detail of order (only user's orders)
	 * @return void
	 * @param integer id of order
	 */
	public function order($id){
		// Check user permission
		if(user::is_logged()){
			// Aditional model
			$order = new Order_Model;
			
			// Settings
			$this->set_title(Kohana::lang('eshop.customer_order'));
			$this->add_breadcrumb(Kohana::lang('eshop.order'), url::current());
			
			// Fetch data
			$data = $order->get_one($id,user::user_id());
			if(empty($data['id'])){ // Go away if data is empty (means that user trying to display someone else order)
				url::redirect('denied');
			}
			$ordered = $order->get_one_ordered($id);
			$total = $order->get_total($id);
			
			// View
			$this->template->content = new View('customer_order');
			$this->template->content->data = $data;
			$this->template->content->ordered = $ordered;
			$this->template->content->total = $total;
			
		} else {
			url::redirect('/denied');
		}
	}
}
?>
