<? 
/**
 *@package News
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('news.add_news'); ?></h2>

<?php echo base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('heading', kohana::lang('news.heading'));
echo form::input('heading', ($form['heading']));
echo '<div class="cleaner">&nbsp;</div>';
echo '<br />';
echo form::label('perex', Kohana::lang('news.perex'));
echo form::textarea('perex', ($form['perex']), 'class="poorEditor" cols="60" rows="20"');
echo '<br />';
echo form::label('news_text', Kohana::lang('news.text'));
echo form::textarea('news_text', ($form['news_text']), 'class="richEditor" cols="60" rows="20"');
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('news.edit'),'class=button');
echo '<br />';
echo form::close();
?>