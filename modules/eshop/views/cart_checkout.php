<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.checkout') ?></h3>

<p><?php echo Kohana::lang('eshop.checkout_text'); ?></p>

<table class="cart">
	<tr><th><?php echo Kohana::lang('eshop.item'); ?></th><th><?php echo Kohana::lang('eshop.quantity'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.price_one'); ?></th><th class="align_right"><?php echo Kohana::lang('eshop.total'); ?></th></tr>	
	<?php foreach($cart as $row){ ?>
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

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));

echo form::open_fieldset(array('class' => 'overview1'));
echo form::legend(Kohana::lang('eshop.personal_info'));?>
<p><? echo Kohana::lang('eshop.name'); ?>: <strong><? echo $profile['name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.email'); ?>: <strong><? echo $profile['email']; ?></strong></p>

<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $profile['customer_street']; ?><br />
<? echo $profile['customer_city']; ?><br />
<? echo $profile['customer_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.phone'); ?>: <strong><? echo $profile['customer_phone']; ?></strong></p>
<? echo form::close_fieldset();

echo form::open_fieldset(array('class' => 'overview2'));
echo form::legend(Kohana::lang('eshop.billing_info')); ?>
<p><? echo kohana::lang('eshop.name'); ?>: <strong><? echo $profile['billing_name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $profile['billing_street']; ?><br />
<? echo $profile['billing_city']; ?><br />
<? echo $profile['billing_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.identity_number'); ?>: <strong><? echo $profile['billing_identity_number']; ?></strong></p>
<p><? echo kohana::lang('eshop.vat_number'); ?>: <strong><? echo $profile['billing_vat_number']; ?></strong></p>
<? echo form::close_fieldset();
echo '<br />';
echo form::open_fieldset();
echo form::legend(Kohana::lang('eshop.delivery_info'));

echo form::label('delivery_name', kohana::lang('eshop.name'));
echo form::input('delivery_name', $form['delivery_name']);
echo "<br />";
echo form::label('delivery_street', kohana::lang('eshop.street'));
echo form::input('delivery_street', $form['delivery_street']);
echo "<br />";
echo form::label('delivery_city', kohana::lang('eshop.city'));
echo form::input('delivery_city', $form['delivery_city']);
echo "<br />";
echo form::label('delivery_postal_code', kohana::lang('eshop.postal_code'));
echo form::input('delivery_postal_code', $form['delivery_postal_code'],'size="8"');
echo form::close_fieldset();

echo form::open_fieldset();
echo form::legend(Kohana::lang('eshop.payment'));
foreach($payment_methods as $row){
	echo form::label('payment',$row['name']);
	if($form['payment'] == $row['id']){
		echo form::radio('payment',$row['id'],TRUE);
	} else {
		echo form::radio('payment',$row['id'],FALSE);
	}
	echo '<br />';
}
echo form::close_fieldset();

echo form::open_fieldset();
echo form::legend(Kohana::lang('eshop.shipping'));
foreach($shipping_methods as $row){
	echo form::label('shipping',$row['name']);
	if($form['shipping'] == $row['id']){
		echo form::radio('shipping',$row['id'],TRUE);
	} else {
		echo form::radio('shipping',$row['id'],FALSE);
	}
	echo '<br />';
}
echo form::close_fieldset();

echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('eshop.order'),'class=button');
echo '<br />';
echo form::close();