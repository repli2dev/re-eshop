<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('news.latest_news'); ?></h3>
<?php if(user::is_got()){ ?>
	<a href="/news/add"><?php echo Kohana::lang('news.add'); ?></a>
<?php } ?>

<?php foreach($data as $row){ ?>
	<h4><? echo $row['heading']; ?></h4>
	<?php echo $row['perex']; ?>
	<a href="/news/detail/<?php echo $row['id']; ?>"><?php echo Kohana::lang('news.more'); ?></a>
<?php } ?>