<h1>Список пользователей</h1>

<table id="users-list">
    <thead>
        <tr>
            <th>Логин</th>
            <th>Дата регистрации</th>
            <th>Последнее посещение</th>
            <th>Email</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($usersList as $user)
            $this->renderPartial('index_usersList_user', array(
                'user' => $user,
            )); ?>
    </tbody>
</table>

<div class="pages-list">
    <?php $this->widget('LinkPager', array('pages'=>$usersListPages)) ?>
</div>