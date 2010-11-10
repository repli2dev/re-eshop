<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h2><?php echo $row['heading']; ?></h2>

<?php echo $row['perex']; ?>

<?php echo $row['text']; ?>

<span class="lastChange"><?php echo $row['insert_date']; ?></span>

<?php gallery::gallery($row['id'],'news'); ?>

<?php if(user::is_got()){ ?>
	<div class="admin">
		<a href="/news/add"><?php echo Kohana::lang('news.add'); ?></a> |
		<a href="/news/edit/<?php echo $row['id']; ?>"><?php echo Kohana::lang('news.edit'); ?></a> | 
		<a href="/news/delete/<?php echo $row['id']; ?>"><?php echo Kohana::lang('news.delete'); ?></a>
	</div>
<?php } ?>
