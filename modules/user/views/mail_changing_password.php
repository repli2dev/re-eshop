<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<? echo Kohana::lang("user.greeting"); ?><br /><br />
<? echo Kohana::lang('user.changing_text');?><? echo url::base(); ?>/user/newuser<br />
<? echo Kohana::lang('user.changing_text2');?><br />
<? echo Kohana::lang('user.yourcode').": ".$hash; ?><br /> 
<? echo Kohana::lang('user.changing_text3'); ?>