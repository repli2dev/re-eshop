<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<? foreach ($data as $row) { ?>
	<div class="news">
		<h3><? echo $row['heading']; ?></h3>
		<?php if(file_exists('/image/news/'.$row['id'])){ ?>
			<a href="/news/detail/<?php echo $row['id']; ?>"><img src="/data/news/<?php echo $row['id']; ?>_m.jpg" alt="<?php kohana::lang('news.image_for'); ?> <?php echo $row['heading']; ?>" /></a>
		<?php } ?>
		<?php echo $row['perex']; ?>
		<a href="/news/detail/<?php echo $row['id']; ?>"><?php echo Kohana::lang('news.more'); ?></a>
	</div>
<? }?>