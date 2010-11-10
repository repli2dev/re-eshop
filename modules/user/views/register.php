<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.register'); ?></h2>
<p><?php echo Kohana::lang('user.register_text'); ?></p>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('fullname', kohana::lang('user.yourname'));
echo form::input('fullname', ($form['fullname']));
echo '<br />';
echo form::label('email', kohana::lang('user.email'));
echo form::input('email', ($form['email']));
echo '<br />';
echo form::label('password', Kohana::lang('user.password'));
echo form::password('password', $form['password']);
echo '<br />';
echo form::label('password2', Kohana::lang('user.password2'));
echo form::password('password2', $form['password2']);
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('user.registerme'),'class=button');
echo '<br />';
echo form::close();
?>
<p><a href="/user/login"><?php echo Kohana::lang('user.login'); ?></a> | <a href="/user/password"><?php echo Kohana::lang('user.forgot_password'); ?></a> | <a href="/user/renew"><?php echo Kohana::lang('user.renew_password'); ?></a></p>