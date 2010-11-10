<?php defined('SYSPATH') or die('No direct access allowed.');

$lang = array(
	'customer_street' => array(
		'required' => 'Please fill your address.',
	),
	'customer_city' => array(
		'required' => 'Please fill your city.',
	),
	'customer_postal_code' => array(
		'required' => 'Please fill your postal code.',
		'length' => 'Your postal code cannot be longer than 255 characters, please fix it.'
	),
	'customer_phone' => array(
		'length' => 'Your telephone number cannot be longer than 255 characters, please fix it.'
	),
	'billing_name' => array(
		'length' => 'Billing name cannot be longer than 255 characters, please fix it.'
	),
	'billing_postal_code' => array(
		'length' => 'Billing postal code cannot be longer than 255 characters, please fix it.'
	),
	'billing_identity_number' => array(
		'length' => 'Billing identity number cannot be longer than 8 characters, please fix it.'
	),
	'billing_vat_number' => array(
		'length' => 'Billing VAT number cannot be longer than 12 characters, please fix it.'
	),
);
?>
