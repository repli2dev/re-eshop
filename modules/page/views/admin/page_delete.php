<? 
/**
 *@package Page
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('page.delete_page'); ?></h2>
<p><? echo Kohana::lang('page.really_delete'); ?></p>
<?
echo form::open();
echo form::submit('yes', Kohana::lang('page.yes'),'class=button');
echo '&nbsp;';
echo form::submit('no', Kohana::lang('page.no'),'class=button');
echo '<br />';
echo form::close();
?>