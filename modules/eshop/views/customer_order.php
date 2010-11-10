<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.customer_order'); ?></h3>

<?
echo form::open(NULL, array('class' => 'glForms'));

echo form::open_fieldset(array('class' => 'overview1'));
echo form::legend(Kohana::lang('eshop.personal_info'));?>
<p><? echo Kohana::lang('eshop.name'); ?>: <strong><? echo $data['customer_name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.email'); ?>: <strong><? echo $data['customer_email']; ?></strong></p>

<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $data['customer_street']; ?><br />
<? echo $data['customer_city']; ?><br />
<? echo $data['customer_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.phone'); ?>: <strong><? echo $data['customer_phone']; ?></strong></p>
<? echo form::close_fieldset();

echo form::open_fieldset(array('class' => 'overview2'));
echo form::legend(Kohana::lang('eshop.billing_info')); ?>
<p><? echo kohana::lang('eshop.name'); ?>: <strong><? echo $data['billing_name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $data['billing_street']; ?><br />
<? echo $data['billing_city']; ?><br />
<? echo $data['billing_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.identity_number'); ?>: <strong><? echo $data['billing_identity_number']; ?></strong></p>
<p><? echo kohana::lang('eshop.vat_number'); ?>: <strong><? echo $data['billing_vat_number']; ?></strong></p>
<? echo form::close_fieldset();?>
<div class="cleaner">&nbsp;</div>
<? echo form::open_fieldset(array('class' => 'overview3'));
echo form::legend(Kohana::lang('eshop.delivery_info')); ?>
<p><? echo kohana::lang('eshop.name'); ?>: <strong><? echo $data['delivery_name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $data['delivery_street']; ?><br />
<? echo $data['delivery_city']; ?><br />
<? echo $data['delivery_postal_code']; ?></strong></p>
<? echo form::close_fieldset(); ?>

<? echo form::open_fieldset(array('class' => 'overview3'));
echo form::legend(Kohana::lang('eshop.other')); ?>
<p><? echo kohana::lang('eshop.status_order'); ?>: <strong><? echo customer::order_status($data['status_order'])?></strong></p>
<p><? echo kohana::lang('eshop.payment'); ?>: <strong><? echo payment::get_name($data['payment']); ?> &ndash; <? echo customer::payment_status($data['status_payment'])?></strong>

<? if($data['status_payment'] == 'none' AND payment::get_type($data['payment']) == "post"){ ?>
	&ndash; <a href="/cart/payment/<? echo $data['id']; ?>"><? echo Kohana::lang('eshop.payment_info'); ?></a>
<? } ?>
<? if($data['status_payment'] == 'none' AND payment::get_type($data['payment']) == "pre"){ ?>
	&ndash; <a href="/cart/payment/<? echo $data['id']; ?>"><? echo Kohana::lang('eshop.pay_now'); ?></a>
<? } ?>
</p>
<? if(payment::get_type($data['payment']) == "post"){ ?>
	<p><? echo Kohana::lang('eshop.vsymbol2'); ?>: <? echo $data['id']; ?></p>
<? } ?>
<p><? echo kohana::lang('eshop.shipping'); ?>: <strong><? echo shipping::get_name($data['shipping']); ?></strong></p>
<p><? echo kohana::lang('eshop.last_change'); ?>: <strong><? echo $data['last_change']; ?></strong></p>
<? echo form::close_fieldset(); ?>

<? echo form::close();?>

<h4><?php echo Kohana::lang('eshop.ordered'); ?></h4>

<table class="cart">
	<tr><th><?php echo Kohana::lang('eshop.item'); ?></th><th><?php echo Kohana::lang('eshop.quantity'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.price_one'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.total'); ?></th></tr>	
	<?php foreach($ordered as $row){ ?>
		<tr>
			<td><? echo product::get_name($row['product']); ?></td>
			<td><? echo $row['quantity']; ?></td>
			<td class="align_right"><? echo product::get_price($row['product']); ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
			<td class="align_right"><? echo (product::get_price($row['product'])*$row['quantity']); ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td colspan="3"><?php echo Kohana::lang('eshop.total'); ?></td>
		<td class="align_right"><?php echo $total; ?>,- <?php echo Kohana::lang('eshop.currency'); ?></td>
	</tr>
</table>

<? if(user::is_got()){ ?>
	<h3><? echo Kohana::lang('eshop.admin'); ?></h3>
	<div class="admin">
			<p>
				<?php echo Kohana::lang('eshop.status_payment'); ?>:
				<? if(payment::get_type($data['payment']) == "post"){ ?>

					<? if($data['status_payment'] == 'none'){ echo "<strong>";} ?><a href="/order/change_payment/<? echo $data['id']; ?>/none"><?php echo Kohana::lang('eshop.none'); ?></a><? if($data['status_payment'] == 'none'){ echo "</strong>";} ?> |
					<? if($data['status_payment'] == 'paid'){ echo "<strong>";} ?><a href="/order/change_payment/<? echo $data['id']; ?>/paid"><?php echo Kohana::lang('eshop.paid'); ?></a><? if($data['status_payment'] == 'paid'){ echo "</strong>";} ?>
				<? } else { ?>
					<? echo Kohana::lang('eshop.disabled_due_payment'); ?>
				<? } ?>
			</p>
			<p>
				<?php echo Kohana::lang('eshop.status_order'); ?>:
				<? if($data['status_order'] == 'none'){ echo "<strong>";} ?><a href="/order/change_order/<? echo $data['id']; ?>/none"><?php echo Kohana::lang('eshop.none'); ?></a><? if($data['status_order'] == 'none'){ echo "</strong>";} ?> |
				<? if($data['status_order'] == 'done'){ echo "<strong>";} ?><a href="/order/change_order/<? echo $data['id']; ?>/done"><?php echo Kohana::lang('eshop.done'); ?></a><? if($data['status_order'] == 'done'){ echo "</strong>";} ?> | 
				<? if($data['status_order'] == 'cancel'){ echo "<strong>";} ?><a href="/order/change_order/<? echo $data['id']; ?>/cancel"><?php echo Kohana::lang('eshop.cancel'); ?></a><? if($data['status_order'] == 'none'){ echo "</strong>";} ?>
			</p>
	</div>	
<? } ?>