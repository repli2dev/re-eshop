<? 
/**
 *@package Base
 **/
?>
<?php if(array_filter($errors)){?>
    <ul class="error">
    <?php foreach($errors as $error): ?>
        <li><?=$error;?></li>
    <?php endforeach; ?>
    </ul>
<?php }	?>