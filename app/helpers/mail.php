<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Helper class for sending e-mails
 * 
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class mail_Core {
	
	/**
	 * Send mail
	 * @return void
	 * @param array (or string) with mail addresses
	 * @param string subject of message
	 * @param string text of message (plain text or HTML)
	 */
	public function send($to,$subject,$text){
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= "Content-Type: text/html; charset=\"utf-8\"\n";
		$header .= "Content-Transfer-Encoding: quoted-printable\n";
		echo $text;
		if(is_array($to)){
			foreach($to as $row){
				mail($row,$subject,wordwrap($text),$header);
			}
		} else {
			mail($to,$subject,wordwrap($text),$header);
		}
	}
}
?>