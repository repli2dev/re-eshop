<? 
/**
 *@package Search
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('search.search'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('value', kohana::lang('search.value'));
echo form::input('value', ($form['value']));
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('search.go'),'class=button');
echo '<br />';
echo form::close();
?>
<div class="cleaner">&nbsp;</div>
<hr />

<? // Rendering products results ?>
<h2><?php echo Kohana::lang('search.results_for_products'); ?></h2>
<?php if(count($data) > 0){ ?>
	<? echo cat::items($data); ?>
<?php } else { ?>
	<p><?php echo Kohana::lang('search.no_result'); ?></p>
<?php } ?>
<div class="cleaner">&nbsp;</div>
<hr />
<? // Rendering pages results ?>
<h2><?php echo Kohana::lang('search.results_for_pages'); ?></h2>
<?php if(count($data2) > 0){ ?>
	<?php foreach($data2 as $row){ ?>
		<div class="result-item">
			<h3><?php echo $row['heading']; ?></h3>
			<p><?php echo string::highlight(string::return_relevant($row['text'],$form['value']),$form['value']); ?></p>
			<a href="/page/<?php echo $row['url']; ?>"><?php echo Kohana::lang('search.more'); ?></a>
		</div>
	<?php } ?>
<?php } else { ?>
	<p><?php echo Kohana::lang('search.no_result'); ?></p>
<?php } ?>
<hr />
<? // Rendering news results ?>
<h2><?php echo Kohana::lang('search.results_for_news'); ?></h2>
<?php if(count($data3) > 0){ ?>
	<? echo news::items($data3); ?>
<?php } else { ?>
	<p><?php echo Kohana::lang('search.no_result'); ?></p>
<?php } ?>