<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for pages table
 *
 * @package    Page
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Page_Model extends Model {

    // Name of db table
    const TN_PAGES = "page";
	
	/**
	 * Fetch one page from database
	 * @param string url of page
	 * @return array page
	 */
	public function get_one($url){
		$row = (array) $this->db->select('heading','text','last_change','menu','url')->from(self::TN_PAGES)->where('url',$url)->limit(1)->get()->current();
		return $row;
	}
	
	/**
	 * Fetch all page which have set flag menu to true
	 * @return array all pages
	 */
	public function get_menu(){
		$data = $this->db->select('heading','url')->from(self::TN_PAGES)->where('menu',1)->get();
		$data->result(FALSE);
		return $data;
	}
	
	/**
	 * Look if page exists
	 * @param string url of page
	 * @return boolean
	 */
	public function page_exists($url){
		$num = $this->db->select('heading','text','last_change')->from(self::TN_PAGES)->where('url',$url)->limit(1)->count_records();
		if($num > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	  * Look if email and password match with db
	  * @param Validation Validation object
	  * @param string field that all goes on
	  * @return boolean
	  */
	public function _url_is_free(Validation $array, $field){
		// Questing database if url string 
		$url_is_free = $this->db->from(self::TN_PAGES)->where('url',$array[$field])->count_records();
		
		if($url_is_free != 0){
			$array->add_error($field,'is_set');
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Update page
	 * @return void
	 * @param object $post array with new values
	 */
	public function change_data($post){
		$this->db->update(self::TN_PAGES,array('heading' => $post['heading'], 'text' => $post['page_text'],'menu' => isset($post['display_menu']),'last_change' => date("Y-m-d H:i:s")),array('url' => $post['url']));
	}
	
	/**
	 * Add new page
	 * @return void 
	 * @param object $post array with new values
	 */
	public function add_data($post){
		$this->db->insert(self::TN_PAGES,array('url' => $post['url'], 'heading' => $post['heading'], 'text' => $post['page_text'],'menu' => isset($post['display_menu']),'last_change' => date("Y-m-d H:i:s")));
	}
	
	/**
	 * Delete page
	 * @param string url of page to delete
	 * @return void 
	 */
	public function delete_data($url){
		$this->db->delete(self::TN_PAGES,array('url' => $url));
	}
	
	/**
	 * Return data for one page of page search
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 * @param string searched text
	 */
	public function search($value){
		$data = $this->db->select(self::TN_PAGES.'.id','heading','text','url')->from(self::TN_PAGES);
		$data->orlike('heading',$value);
		$data->orlike('text',$value);
		$data = $data->get();
		$this->db->last_query();
		$data->result(FALSE); // make array from object
		return $data;
	}

}
