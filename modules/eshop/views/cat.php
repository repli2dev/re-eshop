<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo $name; ?></h3>

<div class="subcats">
	<?php if(count($subcats) > 0){ ?>
		<strong><?php echo Kohana::lang("eshop.subcats"); ?>:</strong>
		<?php
			$count = count($subcats);
			$i = 0; 
			foreach($subcats as $row){ ?>
				<a href="/cat/<?php echo $row['id']; ?>/<?php echo string::to_url($row['name'])?>"><?php echo $row['name'] ?></a><?php $i++; if($count != $i) echo ", "; ?>
		<?php } ?>
	<?php } else { ?>
		<em><?php echo Kohana::lang('eshop.no_subcats'); ?></em>
	<?php } ?>
	<div class="right">
		<?php if(cat::get_parent($id) != 0){ ?>
			<a href="/cat/<?php echo cat::get_parent($id); ?>/<?php echo cat::get_name(cat::get_parent($id)); ?>"><?php echo Kohana::lang('eshop.jump_to_parent'); ?></a> |
		<?php } ?>
		<?php if(user::is_got()){ ?>
			<a href="/cat/add/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.add'); ?></a> |
			<a href="/cat/edit/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.edit'); ?></a> |
			<a href="/cat/delete/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.delete'); ?></a>
		<?php } ?>
	</div>
	&nbsp;
</div>
<?php if(user::is_got()){ ?>
	<p><a href="/product/add/<?php echo $id; ?>"><?php echo Kohana::lang('eshop.add'); ?></a></p>
<?php } ?>
<? echo cat::items($products); ?>
<?php if(count($products) == 0){ ?>
	<em><?php echo Kohana::lang('eshop.no_products'); ?></em>
<?php } ?>
<div class="cleaner">&nbsp;</div>
<hr />
<?php echo $this->pagination->render(); ?> 

