<h1>Вход на сайт</h1>

<?php  $form = $this->beginWidget('ActiveForm', array(
    'id' => 'user-login',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
)); ?>

<div class="row errors-list">
    <?php echo $form->errorSummary($user); ?>
</div>

<div class="row">
    <?php echo $form->label($user, 'login'); ?>
    <?php echo $form->textField($user, 'login'); ?>
    <?php echo $form->error($user, 'login'); ?>
</div>

<div class="row">
    <?php echo $form->label($user, 'password'); ?>
    <?php echo $form->passwordField($user, 'password'); ?>
    <?php echo $form->error($user, 'password'); ?>
</div>

<div class="row">
    <?php echo $form->checkBox($user, 'saveMe'); ?>
    <?php echo $form->label($user, 'saveMe'); ?>
</div>

<div class="row submit">
    <?php echo CHtml::submitButton('Войти'); ?>
</div>

<?php $this->endWidget(); ?>