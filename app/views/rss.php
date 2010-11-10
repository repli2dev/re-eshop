<? 
/**
 *@package Base
 **/
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
<channel>
	<title><?php echo $title; ?></title>
	<link><?php echo $address; ?></link>
	<description><?php echo $description; ?></description>
	<language><?php echo $lang; ?></language>
	<pubDate><? echo $time; ?></pubDate>
	<?php
		foreach($items as $item){
			?>
				<item>
						<guid isPermaLink="false"><?php echo $item['id']; ?></guid>
						<title><![CDATA[<?php echo $item['heading']; ?>]]></title>
						<link><?php echo $address; ?>news/detail/<?php echo $item['id']; ?></link>
						<description><![CDATA[<?php echo $item['perex']; ?>]]></description>
				</item>
			<?
		}
	?>
</channel>