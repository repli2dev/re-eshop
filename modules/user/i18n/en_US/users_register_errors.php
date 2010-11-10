<?php defined('SYSPATH') or die('No direct access allowed.');

$lang = array(
	'email' => array(
		'required' => 'Please fill your email.',
		'email' => 'Please correct your email to be in someone@somewhere.tld format.',
		'exists' => 'This email is already registered, please use different email.',
	),
	'password' => array(
		'required' => 'Please fill first password.',
		'matches' => 'Passwords do not match!',
		'length' => 'Password must be at least 6 character long (max is 128 characters).',
	),
	'password2' => array(
		'required' => 'Please fill second password for check.',
	),
	'fullname' => array(
		'required' => 'Please fill your full name.',
	),
);
?>
