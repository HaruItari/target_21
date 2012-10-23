<h1>Востановление пароля</h1>

<?php  $form = $this->beginWidget('ActiveForm', array(
    'id' => 'user-restore-password',
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
    <?php echo $form->label($user, 'verifyCode'); ?>
    <?php echo $form->textField($user, 'verifyCode'); ?>
    <?php echo $form->note($user, 'verifyCode'); ?>
    <p>
        <span class="label"></span>
        <? $this->widget('Captcha'); ?>
    </p>
    <?php echo $form->error($user, 'verifyCode'); ?>
</div>

<div class="row submit">
    <?php echo CHtml::submitButton('Востановить'); ?>
</div>

<?php $this->endWidget(); ?>
