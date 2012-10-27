<h1>Профиль пользователя</h1>

<p>Логин: <?php echo $user->getLogin(false); ?></p>
<p>Группа: <?php echo $user->getGroup(); ?></p>
<p>Дата регистрации: <?php echo $user->getDateReg(); ?></p>
<p>Последнее посещение: <?php echo $user->getLastonline(); ?></p>

<p>Имя: <?php echo $user->getName(); ?></p>
<p>Пол: <?php echo $user->getSex(); ?></p>
<p>День рождения: <?php echo $user->getBirthday(); ?></p>
<?php $user->getAvatar(); ?>

<?php $this->renderDynamic('dynamicUserMenu', $user->id); ?>