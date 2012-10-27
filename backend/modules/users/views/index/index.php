<h1>Управление пользователями</h1>

<?php $this->renderPartial('index_groupsList', array(
    'groupsList' => $groupsList,
)); ?>

<?php $this->renderPartial('index_usersList', array(
    'usersList' => $usersList,
)); ?>