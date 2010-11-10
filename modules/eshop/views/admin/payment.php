<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.manage_payments'); ?></h3>

<a href="/payment/add/"><? echo Kohana::lang('eshop.add'); ?></a>

<table class="payments">
	<tr>
		<th><? echo Kohana::lang('eshop.id'); ?></th>
		<th><? echo Kohana::lang('eshop.name'); ?></th>
		<th><? echo Kohana::lang('eshop.type'); ?></th>
		<th><? echo Kohana::lang('eshop.payment_info'); ?></th>
		<th><? echo Kohana::lang('eshop.hidden'); ?></th>
		<th><? echo Kohana::lang('eshop.default'); ?></th>
		<th><? echo Kohana::lang('eshop.actions'); ?></th>
	</tr>
	<?php foreach($data as $row){ ?>
		<tr>
			<td><? echo $row['id']; ?></td>
			<td><? echo $row['name']; ?></td>
			<td><? if($row['type'] == 'pre'){ echo Kohana::lang('eshop.inside'); } else { echo Kohana::lang('eshop.outside'); } ?></td>
			<td><? echo $row['info']; ?></td>
			<td><? if($row['hidden']){ echo Kohana::lang('eshop.yes'); } else { echo Kohana::lang('eshop.no'); } ?></td>
			<td><? if($row['default']){ echo Kohana::lang('eshop.yes'); } else { echo Kohana::lang('eshop.no'); } ?></td>
			<td>
				<a href="/payment/edit/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.edit'); ?></a> |
				<a href="/payment/delete/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.delete'); ?></a>
			</td>
		</tr>
	<?php } ?>
</table>