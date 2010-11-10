<? 
/**
 *@package Base
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<? if($thumbs OR user::is_got()){ ?> <h3><?php echo Kohana::lang('gallery.gallery');?></h3><? } ?>
<?
	foreach($thumbs as $image){
		?> <div class="gallery-image<? if(user::is_got()){echo '-admin';}?>">
			<a href="/data/<? echo $dir; ?>/<? echo gallery::full_image($image); ?>" rel="lightbox-cats"><img src="/data/<? echo $dir; ?>/<? echo $image; ?>" alt="<? echo Kohana::lang('gallery.show_large'); ?>" /><? echo Kohana::lang('gallery.show_large'); ?></a>
		<? if(user::is_got()){ ?>
			<a href="/gallery/delete_image/<? echo $item; ?>/<?php echo gallery::get_only_id($image,$item); ?>/<? echo $dir; ?>"><? echo Kohana::lang("gallery.delete_image"); ?></a>
		<? } ?>
		</div> <?		
	} ?>

<? if(user::is_got()){ ?>
	<div class="gallery-image-admin"><a href="/gallery/add_image/<? echo $item; ?>/<? echo $dir; ?>/"><img src="/images/add_image.png" alt="<? echo Kohana::lang('gallery.add_image'); ?>" /><? echo Kohana::lang('gallery.add_image'); ?></a></div>
<? } ?>
