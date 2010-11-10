<?php defined('SYSPATH') or die('No direct access allowed.');

$lang = array(
	'customer_street' => array(
		'required' => 'Vyplňte prosím jméno vaší ulice.',
	),
	'customer_city' => array(
		'required' => 'Vyplňte prosím jméno vašeho města.',
	),
	'customer_postal_code' => array(
		'required' => 'Vyplňte prosím vaše poštovní směrovací číslo.',
		'length' => 'Vaše poštovní směrovací číslo nemůže být delší než 255 znaků. Napravte to prosím.'
	),
	'customer_phone' => array(
		'length' => 'Vaše telefonní číslo nemůže být delší než 255 znaků. Napravte to prosím.'
	),
	'billing_name' => array(
		'length' => 'Jméno plátce nemůže být delší než 255 znaků. Napravte to prosím.'
	),
	'billing_postal_code' => array(
		'length' => 'Poštovní směrovací číslo plátce nemůže být delší než 255 znaků. Napravte to prosím.'
	),
	'billing_identity_number' => array(
		'length' => 'IČ nemůže být delší než 8 znaků. Napravte to prosím.'
	),
	'billing_vat_number' => array(
		'length' => 'DIČ nemůže být delší než 12 znaků. Napravte to prosím.'
	),
);
?>
