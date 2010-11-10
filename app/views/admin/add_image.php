<? 
/**
 *@package Base
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('gallery.add_image'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open_multipart(NULL, array('class' => 'glForms'),array('redirect' => $form['redirect']));
echo form::label('image', Kohana::lang('gallery.select_image'));
echo form::upload(array('name' => 'image'), $form['image']);
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('gallery.add_image'),'class=button');
echo '<br />';
echo form::close();
?>