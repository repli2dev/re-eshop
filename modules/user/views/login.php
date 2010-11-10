<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.login'); ?></h2>

<? base::success($success); ?>
<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('email', kohana::lang('user.email'));
echo form::input('email', ($form['email']));
echo '<br />';
echo form::label('password', Kohana::lang('user.password'));
echo form::password('password', NULL);
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('user.logmein'),'class=button');
echo '<br />';
echo form::close();
?>
<p><a href="/user/register"><?php echo Kohana::lang('user.register'); ?></a> | <a href="/user/password"><?php echo Kohana::lang('user.forgot_password'); ?></a> | <a href="/user/renew"><?php echo Kohana::lang('user.renew_password'); ?></a></p>