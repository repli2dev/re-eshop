<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.manage_customers'); ?></h3>

<table class="customers">
	<tr>
		<th><? echo Kohana::lang('eshop.id'); ?></th>
		<th><? echo Kohana::lang('eshop.name'); ?></th>
		<th><? echo Kohana::lang('eshop.email'); ?></th>
		<th><? echo Kohana::lang('eshop.permission'); ?></th>
		<th><? echo Kohana::lang('eshop.actions'); ?></th>
	</tr>
	<?php foreach($data as $row){ ?>
		<tr>
			<td><? echo $row['id']; ?></td>
			<td><? echo $row['name']; ?></td>
			<td><a href="mailto: <? echo $row['email']; ?>"?><? echo $row['email']; ?></a></td>
			<td><? echo user::text_permission($row['permission']); ?></td>
			<td>
				<a href="/customer/detail/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.detail'); ?></a> |
				<? if($row['permission'] == 0){ ?>
					<a href="/customer/unban/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.unban'); ?></a>
				<? } else { ?> 
					 <a href="/customer/ban/<? echo $row['id'] ?>"><? echo Kohana::lang('eshop.ban'); ?></a>
				<? } ?>
			</td>
		</tr>
	<?php } ?>
</table>
<?php echo $this->pagination->render(); ?>