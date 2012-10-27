<h1>Удалить пользователя</h1>

<?php echo CHtml::beginForm(); ?>

    <p>Вы уверены. что хотите удалить пользователя <b><?php $user->getLogin(); ?></b>?</p>

    <div class="row submit">
        <a href="<?php echo Yii::app()->createUrl('users/index/index'); ?>">Отмена</a> &nbsp;&nbsp;&nbsp; <?php echo CHtml::submitButton('Удалить'); ?>
    </div>

<?php echo CHtml::endForm(); ?>