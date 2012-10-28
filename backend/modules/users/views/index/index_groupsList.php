<table id="groups-list">
    <thead>
        <tr>
            <th>Группа</th>
            <th>Пользователей</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">
                <b><a href="<?php echo Yii::app()->createUrl('users/index/index'); ?>">Все группы</a></b>
            </td>
        </tr>
        <?php foreach($groupsList as $group)
            $this->renderPartial('index_groupsList_group', array(
                'group' => $group,
            )); ?>
    </tbody>
</table>

<ul>
    <?php if(Yii::app()->user->checkAccess('users_add_group')) { ?>
        <li><a href="<?php echo Yii::app()->createUrl('users/index/addGroup'); ?>">Добавить группу</a></li>
    <?php } ?>
</ul>