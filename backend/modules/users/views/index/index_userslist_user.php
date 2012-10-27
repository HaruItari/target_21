<tr>
    <td>
        <?php $user->getLogin(); ?>
    </td>

    <td>
        <?php $user->getDateReg(); ?>
    </td>

    <td>
        <?php $user->getLastOnline(); ?>
    </td>

    <td>
        <?php echo ($user->emailConfirm == 1) ? 'Подтвержден' : 'Не подтвержден'; ?>
    </td>

    <td>
        <?php if(Yii::app()->user->checkAccess('users_edit_profile')) { ?>
            <a href="<?php echo Yii::app()->createUrl('users/index/editUser', array('id'=>$user->id)); ?>">Редактировать</a>
        <? } ?>
    </td>

    <td>
        <?php if(Yii::app()->user->checkAccess('users_remove_profile', array('id'=>$user->id))) { ?>
            <a href="<?php echo Yii::app()->createUrl('users/index/removeUser', array('id'=>$user->id)); ?>">Удалить</a>
        <? } ?>
    </td>
</tr>