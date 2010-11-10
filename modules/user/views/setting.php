<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.settings'); ?></h2>
<p><?php echo Kohana::lang('user.settings_text'); ?></p>

<? base::success($success); ?>
<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::open_fieldset();
echo form::legend(Kohana::lang('user.changedata'));
echo form::label('fullname', kohana::lang('user.yourname'));
echo form::input('fullname', ($form['fullname']));
echo '<br />';
echo form::close_fieldset();
echo form::open_fieldset();
echo form::legend(Kohana::lang('user.changepassword'));
echo form::label('password3', Kohana::lang('user.password3'));
echo form::password('password3', $form['password3']);
echo '<br />';
echo form::label('password2', Kohana::lang('user.password2'));
echo form::password('password2', $form['password2']);
echo '<br />';
echo form::label('password', Kohana::lang('user.password'));
echo form::password('password', $form['password']);
echo form::close_fieldset();
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('user.set'),'class=button');
echo '<br />';
echo form::close();
?>

<p><a href="/user/profile"><?php echo Kohana::lang('user.yourprofile'); ?></a> | <a href="/user/logout"><?php echo Kohana::lang('user.logmeout'); ?></a></p>