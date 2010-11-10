<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.payment') ?></h3>

<p><?php echo Kohana::lang('eshop.complete_order'); ?></p>

<p><?php echo $payment; ?></p>
<p><?php echo Kohana::lang('eshop.vsymbol').': '.$vsymbol; ?></p>

<p><em><?php echo Kohana::lang('eshop.thank_for_order'); ?></em></p>