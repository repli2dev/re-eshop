<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo $name; ?></h3>

<div class="matroska eshop-detail">
	<?php ?>
	<?php if(file_exists(gallery::get_first_available($id,'products'))){ ?>
		<img src="/<?php echo gallery::get_first_available($id,'products'); ?>" alt="<?php echo $name; ?>" />
	<?php } ?>
	<div class="right">
		<?php echo $short_description; ?>
		<div class="cleaner">&nbsp;</div>
		<?php echo $description; ?>
		<div class="cleaner">&nbsp;</div>
		<?php if($manufacturer){ ?><p><?php echo Kohana::lang('eshop.manufacturer') ?>: <?php echo manufacturer::get_name($manufacturer); ?></p><?php } ?>
		<div class="cleaner">&nbsp;</div>
		<?php if($discount){ ?> <span class="discount"><?php echo Kohana::lang('eshop.discount'); ?></span> <?php } ?>
		<?php if($news){ ?> <span class="news"><?php echo Kohana::lang('eshop.news'); ?></span> <?php } ?>
		<?php if($tip){ ?> <span class="tip"><?php echo Kohana::lang('eshop.tip'); ?></span> <?php } ?>
		<div class="cleaner">&nbsp;</div>
		<?php echo Kohana::lang('eshop.price'); ?>: <strong><?php echo $price; ?>,- <?php echo Kohana::lang('eshop.currency'); ?></strong>
		<div class="order-buttons">
			<a class="button" href="/cart/add/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.add_to_cart'); ?></a>
		</div>
	</div>
</div>
<div class="cleaner">&nbsp;</div>

<?php gallery::gallery($id,'products'); ?>

<?php if(user::is_got()){ ?>	
	<div class="admin">
		<a href="/product/edit/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.edit'); ?></a> |
		<a href="/product/delete/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.delete'); ?></a>
	</div>
<?php } ?>
