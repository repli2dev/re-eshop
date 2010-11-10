<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('eshop.cats'); ?></h3>
<?php if(user::is_got()){ ?>
	<p><a href="/cat/add"><?php echo Kohana::lang('eshop.add'); ?></a></p>
<?php } ?>
<ul>
<?php foreach($data as $row){ ?>
	<li><a <? if(strpos(url::current(),'/'.$row['id'].'/') !== FALSE) echo 'class="active"'; ?> href="/cat/<?php echo $row['id']; ?>/<?php echo string::to_url($row['name'])?>"><?php echo $row['name'] ?></a></li>
<?php } ?>
</ul>