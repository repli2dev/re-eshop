<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for orders
 * 
 * @package    Eshop
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Order_Controller extends Base_Controller {
	
		/**
		 * @var order model
		 */ 
		private $order;
		
		/**
		 * Items per page
		 */
		const PER_PAGE = 50;
		
		public function __construct(){
			parent::__construct();
			$this->add_breadcrumb(Kohana::lang('eshop.orders'), '/order/index');
		
			// Adding extra css file
			$this->add_css('/modules/eshop/css/eshop.css');
			
			// Model
			$this->order = new Order_Model();
		}
				
		/**
		 * Show list of all orders
		 * @return void
		 * @param integer number of page to show
		 */
		public function index($page = 1){
			// Check user permission
			if(user::is_logged()){
				// Settings
				$this->set_title(Kohana::lang('eshop.manage_orders'));
				$this->add_breadcrumb(Kohana::lang('eshop.all'), url::current());
				
				// Fetch data
				$data = $this->order->get($page,self::PER_PAGE);
				
				// View
				$this->template->content = new View('customer_orders');
				$this->template->content->heading = Kohana::lang('eshop.manage_orders');
				$this->template->content->data = $data;
				$this->template->content->controller = 'order';
				
				//Pagination
				$this->pagination = new Pagination(array(
				    'uri_segment'    => 'index',
				    'total_items'    => $this->order->count(user::user_id()),
				    'items_per_page' => self::PER_PAGE,
				    'style'          => 'digg'
				));
			} else {
				url::redirect('/denied');
			}
		}
		
		/**
		 * Show detail of order
		 * @return void
		 * @param integer id of order
		 */
		public function order($id){
			// Check user permission
			if(user::is_logged()){
				// Settings
				$this->set_title(Kohana::lang('eshop.customer_order'));
				$this->add_breadcrumb(Kohana::lang('eshop.order'), url::current());
				
				// Fetch data
				$data = $this->order->get_one($id);
				$ordered = $this->order->get_one_ordered($id);
				$total = $this->order->get_total($id);
				
				// View
				$this->template->content = new View('customer_order');
				$this->template->content->data = $data;
				$this->template->content->ordered = $ordered;
				$this->template->content->total = $total;
				
			} else {
				url::redirect('/denied');
			}
		}
		
		/**
		 * Change payment status of order
		 * @return void
		 * @param integer id of orde
		 * @param string new status
		 */
		public function change_payment($id,$new){
			// Check user permission and type of payment
			if(user::is_got() AND payment::get_type($this->order->get_payment($id)) == "post"){
				$this->order->change_payment($id,$new);
				url::redirect('/order/order/'.$id);
			} else {
				url::redirect('/denied');
			}
		}
		
		/**
		 * Change status of order
		 * @return void
		 * @param integer id of order
		 * @param string new status
		 */
		public function change_order($id,$new){
			// Check user permission
			if(user::is_got()){
				$this->order->change_order($id,$new);
				url::redirect('/order/order/'.$id);
			} else {
				url::redirect('/denied');
			}
		}
}
?>
