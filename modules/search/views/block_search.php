<? 
/**
 *@package Search
 **/
?>
<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<div id="search">
	<?php
	echo form::open('search');
	echo form::input('value', NULL);
	echo '&nbsp;';
	echo form::submit('submit', Kohana::lang('search.search'),'class=button');
	echo '<br />';
	echo form::close();
	?>
</div>