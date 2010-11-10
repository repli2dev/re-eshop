<?php defined('SYSPATH') or die('No direct access allowed.');

$lang = array(
	'email' => array(
		'required' => 'Vyplňte prosím váš email.',
		'email' => 'Opravte prosím email na správný tvar (například nekdo@nekde.tld).',
		'exists' => 'Tento mail je již zaregistrován, vyberte prosím jiný.',
	),
	'password' => array(
		'required' => 'Vyplňte prosím první heslo',
		'matches' => 'Hesla se neshodují!',
		'length' => 'Heslo musí být minimálně 6 znaků dlouhé (maximum je 128 znaků).',
	),
	'password2' => array(
		'required' => 'Vyplňte prosím druhé heslo pro kontrolu.',
	),
	'fullname' => array(
		'required' => 'Vyplňte prosím vaše celé jméno.',
	),
);
?>
