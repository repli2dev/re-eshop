<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('eshop.edit_product'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('name', kohana::lang('eshop.name'));
echo form::input('name', ($form['name']));
echo '<div class="cleaner">&nbsp;</div>';
echo form::label('cat[]', Kohana::lang('eshop.parent_cat'));
echo form::dropdown(array('name' => 'cat[]', 'multiple' => 'multiple', 'size' => 5),$selection,$form['cat']);
echo '<div class="cleaner">&nbsp;</div>';
echo form::label('manufacturer', Kohana::lang('eshop.manufacturer'));
echo form::dropdown('manufacturer',$selection2,$form['manufacturer']);
echo '<br />';
echo form::label('short_description', Kohana::lang('eshop.short_description'));
echo form::textarea('short_description', ($form['short_description']), 'class="poorEditor" cols="60" rows="10"');
echo '<div class="cleaner">&nbsp;</div>';
echo '<br />';
echo form::label('description', Kohana::lang('eshop.description'));
echo form::textarea('description', ($form['description']), 'class="richEditor" cols="60" rows="20"');
echo '<br />';
echo form::label('price', kohana::lang('eshop.price'));
echo form::input('price', ($form['price']));
echo '<br />';
echo form::label('a_tip', kohana::lang('eshop.tip'));
echo form::checkbox('tip', 1,$form['tip']);
echo '<br />';
echo form::label('a_news', kohana::lang('eshop.news'));
echo form::checkbox('news', 1,($form['news']));
echo '<br />';
echo form::label('a_discount', kohana::lang('eshop.discount'));
echo form::checkbox('discount', 1,($form['discount']));
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('eshop.edit'),'class=button');
echo '<br />';
echo form::close();
?>