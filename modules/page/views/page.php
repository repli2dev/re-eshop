<? 
/**
 *@package Page
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h2><?php echo $heading; ?></h2>

<?php echo $text; ?>

<span class="lastChange"><?php echo $lastChange; ?></span>

<?php if(user::is_got()){ ?>
	<div class="admin">
		<a href="/page/add"><?php echo Kohana::lang('page.add'); ?></a> |
		<a href="/page/edit/<?php echo $url; ?>"><?php echo Kohana::lang('page.edit'); ?></a> | 
		<a href="/page/delete/<?php echo $url; ?>"><?php echo Kohana::lang('page.delete'); ?></a>
	</div>
<?php } ?>
