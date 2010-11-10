<? 
/**
 *@package Base
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');
?>
<h2><?php echo Kohana::lang('gallery.delete_image'); ?></h2>
<p><? echo Kohana::lang('gallery.really_delete_image'); ?></p>
<?
echo form::open(NULL, NULL, array('redirect' => $form['redirect']));
echo form::submit('yes', Kohana::lang('gallery.yes'),'class=button');
echo '&nbsp;';
echo form::submit('no', Kohana::lang('gallery.no'),'class=button');
echo '<br />';
echo form::close();
?>