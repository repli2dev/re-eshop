<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('eshop.customer_profile'); ?></h2>

<p><?php echo Kohana::lang('eshop.customer_profile_text'); ?></p>


<? base::success($success); ?>
<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));

echo form::open_fieldset();
echo form::legend(Kohana::lang('eshop.personal_info'));

echo form::label('customer_street', kohana::lang('eshop.street'));
echo form::input('customer_street', $form['customer_street']);
echo "<br />";
echo form::label('customer_city', kohana::lang('eshop.city'));
echo form::input('customer_city', $form['customer_city']);
echo "<br />";
echo form::label('customer_postal_code', kohana::lang('eshop.postal_code'));
echo form::input('customer_postal_code', $form['customer_postal_code']);
echo "<br />";
echo form::label('customer_phone', kohana::lang('eshop.phone'));
echo form::input('customer_phone', $form['customer_phone']);

echo form::close_fieldset();

echo form::open_fieldset();
echo form::legend(Kohana::lang('eshop.billing_info'));

echo form::label('billing_name', kohana::lang('eshop.name'));
echo form::input('billing_name', $form['billing_name']);
echo "<br />";
echo form::label('billing_street', kohana::lang('eshop.street'));
echo form::input('billing_street', $form['billing_street']);
echo "<br />";
echo form::label('billing_city', kohana::lang('eshop.city'));
echo form::input('billing_city', $form['billing_city']);
echo "<br />";
echo form::label('billing_postal_code', kohana::lang('eshop.postal_code'));
echo form::input('billing_postal_code', $form['billing_postal_code'],'size="8"');
echo "<br />";
echo form::label('billing_identity_number', kohana::lang('eshop.identity_number'));
echo form::input('billing_identity_number', $form['billing_identity_number'],'size="8"');
echo "<br />";
echo form::label('billing_vat_number', kohana::lang('eshop.vat_number'));
echo form::input('billing_vat_number', $form['billing_vat_number'],'size="12"');
echo form::close_fieldset();

echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('eshop.update'),'class=button');
echo '<br />';
echo form::close();
?>