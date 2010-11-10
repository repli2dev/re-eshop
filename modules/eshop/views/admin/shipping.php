<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.manage_shippings'); ?></h3>

<a href="/shipping/add/"><? echo Kohana::lang('eshop.add'); ?></a>

<table class="shippings">
	<tr>
		<th><? echo Kohana::lang('eshop.id'); ?></th>
		<th><? echo Kohana::lang('eshop.name'); ?></th>
		<th><? echo Kohana::lang('eshop.hidden'); ?></th>
		<th><? echo Kohana::lang('eshop.default'); ?></th>
		<th><? echo Kohana::lang('eshop.actions'); ?></th>
	</tr>
	<?php foreach($data as $row){ ?>
		<tr>
			<td><? echo $row['id']; ?></td>
			<td><? echo $row['name']; ?></td>
			<td><? if($row['hidden']){ echo Kohana::lang('eshop.yes'); } else { echo Kohana::lang('eshop.no'); } ?></td>
			<td><? if($row['default']){ echo Kohana::lang('eshop.yes'); } else { echo Kohana::lang('eshop.no'); } ?></td>
			<td>
				<a href="/shipping/edit/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.edit'); ?></a> |
				<a href="/shipping/delete/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.delete'); ?></a>
			</td>
		</tr>
	<?php } ?>
</table>