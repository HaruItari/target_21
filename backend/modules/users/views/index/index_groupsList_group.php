<tr>
    <td>
        <a href="<?php echo Yii::app()->createurl('users/index/index', array('group'=>$group['id'])); ?>" style="<?php echo $group['style']; ?>"><?php echo $group['group']; ?></a>
    </td>

    <td>
        <?php echo $group['countUsers']; ?>
    </td>

    <td>
        <?php if($group['isDefault'] == 1) echo 'По умолчанию' ?>
    </td>

    <td>
        <?php if(Yii::app()->user->checkAccess('users_edit_group')) { ?>
            <a href="<?php echo Yii::app()->createUrl('users/index/editGroup', array('id'=>$group['id'])); ?>">Редактировать</a>
        <?php } ?>
    </td>

    <td>
        <?php if(Yii::app()->user->checkAccess('users_remove_group', $group)) { ?>
            <a href="<?php echo Yii::app()->createUrl('users/index/removeGroup', array('id'=>$group['id'])); ?>">Удалить</a>
        <?php } ?>
    </td>
</tr>