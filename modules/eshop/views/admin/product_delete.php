<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('eshop.delete_product'); ?></h2>
<p><? echo Kohana::lang('eshop.really_delete'); ?></p>
<?
echo form::open();
echo form::submit('yes', Kohana::lang('eshop.yes'),'class=button');
echo '&nbsp;';
echo form::submit('no', Kohana::lang('eshop.no'),'class=button');
echo '<br />';
echo form::close();
?>