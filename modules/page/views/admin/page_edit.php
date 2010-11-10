<? 
/**
 *@package Page
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('page.edit_page'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('heading', kohana::lang('page.heading'));
echo form::input('heading', ($form['heading']));
echo '<br />';
echo form::label('url', Kohana::lang('page.url'));
echo form::input('url', ($form['url']),'readonly="readonly"');
echo '<div class="cleaner">&nbsp;</div>';
echo '<br />';
echo form::label('page_text', Kohana::lang('page.text'));
echo form::textarea('page_text', ($form['page_text']), 'class="richEditor" cols="60" rows="20"');
echo '<br />';
echo form::label('display_menu', kohana::lang('page.display_menu'));
echo form::checkbox('display_menu', 1,($form['display_menu']));
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('page.edit'),'class=button');
echo '<br />';
echo form::close();
?>