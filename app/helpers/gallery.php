<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for unified gallery
 * 
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */
class gallery_Core {
  	/**
	 * Return filename of full sized picture (remove _m from its name)
	 * @return string filename of picture
	 * @param string filename of thumb
	 */
	public function full_image($image){
		return str_replace('_m','',$image);
	}
	
	/**
	 * Return array with name of thumbs
	 * @return array 
	 * @param int id  of news
	 * @param string dir to search
	 */
	public function get_thumbs_images($id,$dir){
		$thumbs = array();
		if ($handle = opendir('data/'.$dir.'/')) { // Fetch filelist 
		    while (false !== ($file = readdir($handle))) {
		        if(preg_match('/^'.$id.'_/', $file) AND strpos($file,'_m.jpg') !== FALSE ){ // Handle only files with proper name
		        	$thumbs[] = $file;
		        }
		    }
		    closedir($handle);
		}
		sort($thumbs); // Sort by name
		return $thumbs;
	}
	
	/**
	 * Return array with filenames of images which belongs to given id
	 * @return array with filenames of images
	 * @param integer id of item
	 * @param string dir with images
	 */
	public function get_images($id,$dir){
		$images = array();
		if ($handle = opendir('data/'.$dir.'/')) {
		    while (false !== ($file = readdir($handle))) {
		        if(preg_match('/^'.$id.'_/', $file)){
		        	$images[] = $file;
		        }
		    }
		    closedir($handle);
		}
		return $images;
	}
	
	/**
	 * Delete given images
	 * @return void
	 * @param id of item
	 * @param string dir with images
	 */
	public function delete_images($id,$dir){
		$images = self::get_images($id,$dir);
		foreach($images as $image){
			if(file_exists('./data/'.$dir.'/'.$image)){
				unlink('./data/'.$dir.'/'.$image);
			}
		}
	}
	
	/**
	 * Return free id (for filename
	 * @return integer
	 * @param integer ID of item
	 * @param string dir to search
	 */
	public function get_image_new_name($item,$dir){
		$id = 0;
		$images = self::get_images($item,$dir);
		sort($images);
		// TODO: would be seek to end better?
		foreach($images as $row){
			$row = str_replace($item.'_','',$row);
			$row = str_replace('_m','',$row);
			$row = str_replace('.jpg','',$row);
			$id = $row;
		}
		return ($id+1);
	}
	
	/**
	 * Return ID of image from its full name
	 * @return integer ID of image
	 * @param string name of image
	 * @param integer ID of item
	 */
	public function get_only_id($image,$item){
		$image = str_replace($item.'_','',$image);
		$image = str_replace('_m','',$image);
		$image = str_replace('.jpg','',$image);
		return $image;
	}
	
	/**
	 * Include gallery inside page
	 * @return void
	 * @param integer ID of item
	 * @param string dir with images
	 */
	public function gallery($item,$dir){
		$template = new View('gallery');
		$template->dir = $dir;
		$template->item = $item;
		$template->thumbs = self::get_thumbs_images($item,$dir);
		$template->render(TRUE);
	}
	
	/**
	 * Return name of first available image (works for picture with #2 if there is no picture #1) - thumb
	 * @return string path to image
	 * @param integer ID of item
	 * @param string dir with images
	 */
	public function get_first_available($item,$dir){
		$images = self::get_images($item,$dir);
		sort($images);
		if(count($images) > 1){
			return('data/'.$dir.'/'.$images[1]);
		} else {
			return FALSE;
		}
	}
}
?>