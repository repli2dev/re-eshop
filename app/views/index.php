<? 
/**
 *@package Base
 **/
?>
<h3><? echo Kohana::lang('index.recycleshop'); ?></h3>

<p><? echo Kohana::lang('index.text'); ?></p>

<h4><? echo Kohana::lang('index.tips'); ?></h4>
<? echo product::block_flag('tip',3); ?>