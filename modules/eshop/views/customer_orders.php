<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo $heading; ?></h3>

<table class="customers">
	<tr>
		<th><? echo Kohana::lang('eshop.id'); ?></th>
		<th><? echo Kohana::lang('eshop.status_order'); ?></th>
		<th><? echo Kohana::lang('eshop.status_payment'); ?></th>
		<th><? echo Kohana::lang('eshop.payment'); ?></th>
		<th><? echo Kohana::lang('eshop.shipping'); ?></th>
		<th><? echo Kohana::lang('eshop.last_change'); ?></th>
		<th><? echo Kohana::lang('eshop.actions'); ?></th>
	</tr>
	<?php foreach($data as $row){ ?>
		<tr>
			<td><? echo $row['id']; ?></td>
			<td class="<? echo $row['status_order']; ?>"><? echo customer::order_status($row['status_order']); ?></td>
			<td class="<? echo $row['status_payment']; ?>"><? echo customer::payment_status($row['status_payment']); ?></td>
			<td><? echo payment::get_name($row['payment']); ?></td>
			<td><? echo shipping::get_name($row['shipping']); ?></td>
			<td><? echo $row['last_change']; ?></td>
			<td>
				<a href="/<? echo $controller; ?>/order/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.detail'); ?></a>
		</tr>
	<?php } ?>
</table>
<?php echo $this->pagination->render(); ?>