<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<?php foreach($data as $row){ ?>
	<div class="product">
		<h4><a href="/product/<?php echo $row['id']; ?>/<?php echo string::to_url($row['name']); ?>"><?php echo $row['name']; ?></a></h4>
		<div class="matroska">
			<?php if(file_exists(gallery::get_first_available($row['id'],'products'))){ ?>
				<a href="/product/<?php echo $row['id']; ?>/<?php echo string::to_url($row['name']); ?>"><img src="/<?php echo gallery::get_first_available($row['id'],'products'); ?>" alt="<?php echo $row['name']; ?>" /></a>
			<?php } ?>
			<?php if($row['discount']){ ?> <span class="discount"><?php echo Kohana::lang('eshop.discount'); ?></span> <?php } ?>
			<?php if($row['news']){ ?> <span class="news"><?php echo Kohana::lang('eshop.news'); ?></span> <?php } ?>
			<?php if($row['tip']){ ?> <span class="tip"><?php echo Kohana::lang('eshop.tip'); ?></span> <?php } ?>
			<div class="cleaner">&nbsp;</div>
			<?php echo Kohana::lang('eshop.price'); ?>: <strong><?php echo $row['price']; ?>,- <?php echo Kohana::lang('eshop.currency'); ?></strong>
			<div class="cleaner">&nbsp;</div>
			<?php echo $row['short_description']; ?>
			<div class="order-buttons">
				<a class="button" href="/product/<?php echo $row['id']; ?>/<?php echo string::to_url($row['name']); ?>"><?php echo Kohana::lang('eshop.detail'); ?></a>
				<a class="button" href="/cart/add/<?php echo $row['id']; ?>"><?php echo Kohana::lang('eshop.add_to_cart'); ?></a>
			</div>
		</div>
	</div>
<?php } ?>