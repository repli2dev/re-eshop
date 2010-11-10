<? 
/**
 *@package Base
 **/
?>
<?php if(array_filter($success)){?>
    <ul class="success">
    <?php foreach($success as $row): ?>
        <li><?=$row;?></li>
    <?php endforeach; ?>
    </ul>
<?php }	?>