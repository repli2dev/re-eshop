<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.cart') ?></h3>

<p><?php echo Kohana::lang('eshop.welcome_in_cart'); ?></p>

<?php base::success($success); ?>

<?php echo form::open(NULL,array('class' => 'glForms')) ?>
<table class="cart">
	<tr><th><?php echo Kohana::lang('eshop.item'); ?></th><th><?php echo Kohana::lang('eshop.quantity'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.price_one'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.total'); ?></th></tr>	
	<?php if(count($cart) == 0){?><tr><td colspan="4"><? echo Kohana::lang('eshop.cart_is_empty'); ?></td></tr><? } ?>
	<?php foreach($cart as $row){ ?>
		<tr>
			<td><? echo product::get_name($row['product']); ?></td>
			<td><? echo form::input('quantity['.$row['product'].']', ($row['quantity']),'size="3" maxsize="3"'); ?></td>
			<td class="align_right"><? echo product::get_price($row['product']); ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
			<td class="align_right"><? echo (product::get_price($row['product'])*$row['quantity']); ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td colspan="3"><?php echo Kohana::lang('eshop.total'); ?></td>
		<td class="align_right"><?php echo $total; ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
	</tr>
</table>
<div class="cart_buttons">
	<?php echo form::submit('change', Kohana::lang('eshop.change_quantity'),'class=button'); ?>
	<?php echo form::submit('empty', Kohana::lang('eshop.empty_cart'),'class=button'); ?>
	<?php echo form::submit('checkout', Kohana::lang('eshop.checkout'),'class=button'); ?>
&nbsp;</div>
<?php echo form::close(); ?>

<h4><?php echo Kohana::lang('eshop.cart_help') ?></h4>

<p><?php echo Kohana::lang('eshop.quantity_change'); ?></p>
<p><?php echo Kohana::lang('eshop.deletion'); ?></p>
<p><?php echo Kohana::lang('eshop.finish_order'); ?></p>