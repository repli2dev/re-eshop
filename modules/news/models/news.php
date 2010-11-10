<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Model for news
 *
 * @package    News
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
 
class News_Model extends Model {

    // Name of db table
    const TN_NEWS = "news";
	
	/**
	 * Return data for one page of news
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 */
	public function get($page,$per_page){
		$page = $page-1;
		$data = $this->db->select('id','heading','perex','text','insert_date')->from(self::TN_NEWS)->where(1)->orderby('insert_date','DESC')->limit($per_page,$page*$per_page)->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
	
	/**
	 * Count news
	 * @return integer number of news
	 */
	public function count(){
		 $num = $this->db->select('id')->from(self::TN_NEWS)->where(1)->get()->count();
		 return $num;
	}
	
	/**
	 * Return one news with $id
	 * @return array
	 * @param integer id of news 
	 */
	public function get_one($id){
		$row = (array) $this->db->select('id','heading','perex','text','insert_date')->from(self::TN_NEWS)->where('id',$id)->limit(1)->get()->current();
		return $row;
	}
	
	/**
	 * Add new news
	 * @return id of new news 
	 * @param object $post array with new values
	 */
	public function add_data($post){
		return $this->db->insert(self::TN_NEWS,array('perex' => $post['perex'], 'heading' => $post['heading'], 'text' => $post['news_text'],'insert_date' => date("Y-m-d H:i:s")))->insert_id();		
	}
	
	/**
	 * Edit news
	 * @return void
	 * @param object $post array with new values
	 * @param id of changed news
	 */
	public function change_data($post,$id){
		$this->db->update(self::TN_NEWS,array('heading' => $post['heading'], 'text' => $post['news_text'], 'perex' => $post['perex']),array('id' => $id));		
	}
	
	/**
	 * Delete news
	 * @param id of news
	 * @return boolean return true if row is deleted
	 */
	public function delete_data($id){
		$status = $this->db->delete(self::TN_NEWS,array('id' => $id));
		$rows = count($status);
		if($rows > 0){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Return data for one page of news search
	 * @return array query data
	 * @param integer page number
	 * @param integer entries per page
	 * @param string searched text
	 */
	public function search($value){
		$data = $this->db->select(self::TN_NEWS.'.id','heading','perex','text')->from(self::TN_NEWS);
		$data->orlike('heading',$value);
		$data->orlike('perex',$value);
		$data->orlike('text',$value);
		$data = $data->get();
		$data->result(FALSE); // make array from object
		return $data;
	}
}
