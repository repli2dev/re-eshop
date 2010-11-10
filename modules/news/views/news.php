<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('news.news'); ?></h2>

<?php if(user::is_got()){ ?>
	<div class="admin">
		<a href="/news/add"><?php echo Kohana::lang('news.add'); ?></a>
	</div>
<?php } ?>

<? echo news::items($data); ?>

	<hr />
	<?php echo $this->pagination->render(); ?>
	<a class="rss" href="/news/rss"><img src="/images/rss.png" alt="<?php echo Kohana::lang('news.rss_feed'); ?>" /></a>
