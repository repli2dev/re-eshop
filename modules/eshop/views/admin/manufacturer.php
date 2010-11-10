<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.manage_manufacturers'); ?></h3>

<a href="/manufacturer/add/"><? echo Kohana::lang('eshop.add'); ?></a>

<table class="manufacturers">
	<tr>
		<th><? echo Kohana::lang('eshop.id'); ?></th>
		<th><? echo Kohana::lang('eshop.name'); ?></th>
		<th><? echo Kohana::lang('eshop.actions'); ?></th>
	</tr>
	<?php foreach($data as $row){ ?>
		<tr>
			<td><? echo $row['id']; ?></td>
			<td><? echo $row['name']; ?></td>
			<td>
				<a href="/manufacturer/edit/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.edit'); ?></a> |
				<a href="/manufacturer/delete/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.delete'); ?></a>
			</td>
		</tr>
	<?php } ?>
</table>