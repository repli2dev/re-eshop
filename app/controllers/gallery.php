<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Controller for administrating galleries
 *
 * @package    Base
 * @author     Jan Drabek
 * @copyright  (c) 2009 Jan Drabek
 * @license    GPL3
 */

class Gallery_Controller extends Base_Controller {
	
	/**
	 * No direct access
	 * @return void
	 */
	public function index(){
        url::redirect('/');
	}
	
	/**
	 * Add image to item
	 * @return void
	 * @param integer id of item
	 * @param string dir with images
	 */
	public function add_image($item,$dir){
		// Check for user permission
		if(user::is_got()){
			$this->set_title(Kohana::lang('gallery.add_image'));
			$this->add_breadcrumb(Kohana::lang('gallery.add_image'), url::current());
			// Set redirect URL
			if(isset($_POST['redirect'])){
				$redirect = $_POST['redirect'];
			} else {
				$redirect = request::referrer(); 
			}
			$form = array(
				'image' => '',
				'redirect' => $redirect
			);
			$errors = array();
			if(isset($_FILES)){
				$files = new Validation($_FILES);
				// Rules
				$files->add_rules('image', 'upload::valid','upload::required', 'upload::type[jpg,jpeg]', 'upload::size[500K]');
				if($files->validate()){
					// Temporary file
					$filename = upload::save('image');
					// Get new name
					$id = gallery::get_image_new_name($item,$dir);
				 	// Save original and thumb
					Image::factory($filename)
						->save('./data/'.$dir.'/'.$item.'_'.$id.'.jpg');
					Image::factory($filename)
						->resize(128, 128, Image::AUTO)
						->quality(85)
						->save('./data/'.$dir.'/'.$item.'_'.$id.'_m.jpg');
				 
					// Remove the temporary file
					unlink($filename);
					url::redirect($form['redirect']);
				} else {
					// Repopulate form with error and original values
					$form = arr::overwrite($form, $files->as_array());
					$errors = $files->errors('gallery_errors');
				}
			}
			// View
			$this->template->content = new View('admin/add_image');
			$this->template->content->errors = $errors;
			$this->template->content->form = $form;
		} else {
			url::redirect('/denied');
		}
	}
	/**
	 * Delete image
	 * @return void
	 * @param integer id of item
	 * @param integer id of picture
	 * @param string dir with images
	 */
	public function delete_image($id,$image,$dir){
		// Check for user permission
		if(user::is_got()){
			// Page settings
			$this->set_title(Kohana::lang('gallery.delete_image'));
			$this->add_breadcrumb(Kohana::lang('gallery.delete_image'), url::current());
			// Set redirect URL
			if(isset($_POST['redirect'])){
				$redirect = $_POST['redirect'];
			} else {
				$redirect = request::referrer(); 
			}
			$form = array(
				'redirect' => $redirect
			);
			if($_POST){
				if(isset($_POST['yes'])){ // Clicked on yes = delete image
					unlink('./data/'.$dir.'/'.$id.'_'.$image.'.jpg');
					unlink('./data/'.$dir.'/'.$id.'_'.$image.'_m.jpg');
					url::redirect($form['redirect']);
				} else {
					url::redirect($form['redirect']);
				}
			}
			// View
			$this->template->content = new View('admin/delete_image');
			$this->template->content->form = $form;
		}
	}

}
