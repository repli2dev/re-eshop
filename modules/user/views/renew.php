<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.renew_password'); ?></h2>

<p><?php echo Kohana::lang('user.renew_briefing'); ?></p>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('email', kohana::lang('user.email'));
echo form::input('email', ($form['email']));
echo '<br />';
echo form::label('code', kohana::lang('user.code'));
echo form::input('code', ($form['code']),'size="28"');
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('user.sendpassword'),'class=button');
echo '<br />';
echo form::close();?>