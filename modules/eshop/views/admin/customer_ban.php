<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('eshop.customer_ban'); ?></h2>

<p><? echo Kohana::lang('eshop.really_ban'); ?></p>
<?
echo form::open();
echo form::submit('yes', Kohana::lang('news.yes'),'class=button');
echo '&nbsp;';
echo form::submit('no', Kohana::lang('news.no'),'class=button');
echo '<br />';
echo form::close();
?>