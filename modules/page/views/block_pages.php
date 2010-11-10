<? 
/**
 *@package Page
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<h3><?php echo Kohana::lang('page.pages'); ?></h3>
<?php if(user::is_got()){ ?>
	<p><a href="/page/add"><?php echo Kohana::lang('page.add'); ?></a></p>
<?php } ?>
<ul>
<?php foreach($data as $row){ ?>
	<li><a <? if(url::current() == 'page/'.$row['url']) echo 'class="active"'; ?> href="/page/<?php echo $row['url']; ?>"><?php echo $row['heading'] ?></a></li>
<?php } ?>
</ul>