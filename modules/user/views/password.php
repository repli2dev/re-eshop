<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.login'); ?></h2>

<? base::errors($errors); ?>

<?
echo form::open(NULL, array('class' => 'glForms'));
echo form::label('email', kohana::lang('user.email'));
echo form::input('email', ($form['email']));
echo '<br />';
echo form::label('password', Kohana::lang('user.password'));
echo form::password('password', $form['password']);
echo '<br />';
echo form::label('submit', '&nbsp;');
echo form::submit('submit', Kohana::lang('user.logmein'),'class=button');
echo '<br />';
echo form::close();
?>