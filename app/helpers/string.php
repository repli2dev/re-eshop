<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class - string
 * 
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class string_Core {
	
	/**
	 * Strip all non URL characters (keep only alphanumeric characters)
	 * @return string safe URL string
	 */
	public function to_url($value){
		$result = strtolower($value);
		
	    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
	    $result = trim(preg_replace("/\s+/", " ", $result));
	    $result = trim(substr($result, 0, 45));
	    $result = preg_replace("/\s/", "-", $result);
	 
		return $result;
	}
	
	/**
	 * Try to find searched value and return whole sentence
	 * @return string sentence without html
	 * @param string to search in
	 * @param string to be searched
	 */
	public function return_relevant($value,$search){
		if(empty($search)){
			return;
		} else {
			$value = strip_tags($value);
			$word_pos = strpos($value,$search); // Find position of searched word
			if($word_pos === FALSE){ // If there is no position, return first sentence
				$next_fullstop = strpos($value,'. ',0);
				if($next_fullstop === FALSE){ // If there is no fullstop then truncate to certain length
					return string::trim_text($value,100).'...';
				} else {
					return substr($value,0,$next_fullstop).'...';
				}
			} else {
				$next_fullstop = strpos($value,'. ',$word_pos);
				if($next_fullstop === FALSE){ // If there is no fullstop then truncate to certain lenght
					return string::trim_text($value,100).'...';
				} else {
					$prev_fullstop = self::rstrpos($value,'. ',$word_pos);
					return '...'.substr($value,$prev_fullstop,$next_fullstop - $prev_fullstop).'...';
				}
			}
		}
	}
	
	/**
	 * Add highlight to word which is given by search
	 * @return string with highlight
	 * @param string text to highlight in
	 * @param string text to highlight
	 */
	public function highlight($value,$search){
		return str_replace($search,'<span class="highlight">'.$search.'</span>',$value);
	}
	
	/**
	 * Find previous occurrency in given haystack
	 * @return integer previous position
	 * @param string haystack
	 * @param string needle
	 * @param integer offset
	 */
	public function rstrpos ($haystack, $needle, $offset){
		$size = strlen ($haystack);
		
		$pos = strpos (strrev($haystack), strrev($needle), $size - $offset);
		if ($pos === false)
			return false;
			
		return $size - $pos;
	}
	
	/**
	 * Trim text to given length in nearest space
	 * @return string 
	 * @param string text to trim
	 * @param integer lenght to trim
	 */
	public function trim_text($value,$length){
		if (strlen($value) <= $length) {
                return $value;
        }
		$last_space = strrpos(substr($value, 0, $length), ' ');
		$trim_text = substr($value, 0, $last_space);
		return $trim_text;
	}
	
	/**
	 * Generate random code.
	 * @param integer length
	 * @return string generated string
	 */
	public function random_code($length = 8){
		$key = '';
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		for($i=0;$i<$length;$i++){
			$key .= $pattern{rand(0,60)};
		}
		return $key;
	}
}
?>