<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<div id="cart">
	<h2><?php echo Kohana::lang('eshop.cart'); ?></h2>: <?php echo $count; ?> <?php echo Kohana::lang('eshop.items'); ?> &ndash; <?php echo Kohana::lang('eshop.total'); ?> <?php echo $total; ?>,- <?php echo Kohana::lang('eshop.currency'); ?>
	<a href="/cart/show"><?php echo Kohana::lang('eshop.view_cart'); ?></a>
</div>
