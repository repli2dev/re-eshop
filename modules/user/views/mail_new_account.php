<? 
/**
 *@package User
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<? echo Kohana::lang("user.greeting"); ?><br /><br />
<? echo Kohana::lang('user.new_account_text');?><? echo url::base(); ?><br />
<? echo Kohana::lang('user.new_account_text2');?><br />
<? echo Kohana::lang('user.email').": ".$post['email']; ?><br /> 
<? echo Kohana::lang('user.password').": ".$post['password']; ?><br />
<? echo Kohana::lang('user.new_text2'); ?>