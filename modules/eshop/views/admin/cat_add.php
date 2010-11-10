<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('eshop.add_cat'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('name', kohana::lang('eshop.name'));
echo form::input('name', ($form['name']));
echo '<div class="cleaner">&nbsp;</div>';
echo form::label('parent', Kohana::lang('eshop.parent_cat'));
echo form::dropdown('parent',$selection,$form['parent']);
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('eshop.add'),'class=button');
echo '<br />';
echo form::close();
?>