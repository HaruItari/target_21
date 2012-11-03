<ul>
    <li><a href="<?php echo Yii::app()->createUrl('index/login'); ?>">login</a>
    <li><a href="<?php echo Yii::app()->createUrl('index/logout'); ?>">logout</a>
    <li><a href="<?php echo Yii::app()->createUrl('users/index/index'); ?>">USERS</a>
        <ul>

        </ul>
    </li>
    <li><a href="<?php echo Yii::app()->createUrl('titles/index/index'); ?>">TITLES</a>
        <ul>
            <li><a href="<?php echo Yii::app()->createUrl('titles/index/addAnime'); ?>">addAnime</a>
        </ul>
    </li>
</ul>