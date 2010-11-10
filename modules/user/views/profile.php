<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h2><?php echo Kohana::lang('user.yourprofile'); ?></h2>

<p><?php echo Kohana::lang('user.currentuser'); ?> <?php echo $name; ?> (<?php echo $email; ?>).</p>

<p><?php echo Kohana::lang('user.yourpermission'); ?>: <?php echo $permission; ?></p>

<p><a href="/user/setting"><?php echo Kohana::lang('user.settings'); ?></a> | <a href="/user/logout"><?php echo Kohana::lang('user.logmeout'); ?></a></p>