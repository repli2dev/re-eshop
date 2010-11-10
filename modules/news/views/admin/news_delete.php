<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('news.delete_news'); ?></h2>
<p><? echo Kohana::lang('news.really_delete'); ?></p>
<?
echo form::open();
echo form::submit('yes', Kohana::lang('news.yes'),'class=button');
echo '&nbsp;';
echo form::submit('no', Kohana::lang('news.no'),'class=button');
echo '<br />';
echo form::close();
?>