<? 
/**
 *@package Eshop
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<? echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<SHOP>
	<? foreach($products as $row){ ?>
	<SHOPITEM>
		<PRODUCT><? echo $row['name']; ?></PRODUCT>
		<DESCRIPTION><? echo $row['short_description']; ?></DESCRIPTION>
		<URL><? echo url::base().'product/'.$row['id']; ?>/<? echo string::to_url($row['name']); ?></URL>
		<? if(file_exists('./data/products/'.$row['id'].'_1.jpg')){ ?>
			<IMGURL><? echo url::base().'/data/products/'.$row['id'].'_1.jpg'; ?></IMGURL>
		<? } ?>
		<PRICE_VAT><? echo $row['price']; ?></PRICE_VAT>
	</SHOPITEM>
	<? } ?>
</SHOP>