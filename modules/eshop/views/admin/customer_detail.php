<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.customer_detail'); ?></h3>

<h4><? echo (Kohana::lang('eshop.personal_info')); ?></h4>

<p><? echo Kohana::lang('eshop.name'); ?>: <strong><? echo $row['name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.email'); ?>: <strong><? echo $row['email']; ?></strong></p>

<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $row['customer_street']; ?><br />
<? echo $row['customer_city']; ?><br />
<? echo $row['customer_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.phone'); ?>: <strong><? echo $row['customer_phone']; ?></strong></p>

<h4><? echo Kohana::lang('eshop.billing_info'); ?></h4>

<p><? echo kohana::lang('eshop.name'); ?>: <strong><? echo $row['billing_name']; ?></strong></p>
<p><? echo Kohana::lang('eshop.street'); ?>: <strong><br /><? echo $row['billing_street']; ?><br />
<? echo $row['billing_city']; ?><br />
<? echo $row['billing_postal_code']; ?></strong></p>
<p><? echo kohana::lang('eshop.identity_number'); ?>: <strong><? echo $row['billing_identity_number']; ?></strong></p>
<p><? echo kohana::lang('eshop.vat_number'); ?>: <strong><? echo $row['billing_vat_number']; ?></strong></p>

<h4><? echo Kohana::lang('eshop.other'); ?></h4>

<p><? echo kohana::lang('eshop.number_orders'); ?>: <strong><? echo $num_orders; ?></strong></p>