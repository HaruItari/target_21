<h1>Редактирование личных данных</h1>

<?php $form = $this->beginWidget('ActiveForm', array(
    'enableClientValidation' => true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>
<div class="row errors-list">
    <?php echo $form->errorSummary(array($user, $userFull)); ?>
</div>

<div class="row">
	<?php echo $form->label($userFull, 'name'); ?>
	<?php echo $form->textField($userFull, 'name'); ?>
	<?php echo $form->note($userFull, 'name'); ?>
	<?php echo $form->error($userFull,'name'); ?>
</div>

<div class="row">
	<?php echo $form->label($userFull, 'birthday'); ?>
	<?php echo $form->textField($userFull, 'birthday'); ?>
	<?php echo $form->note($userFull, 'birthday'); ?>
	<?php echo $form->error($userFull,'birthday'); ?>
</div>

<div class="row">
	<?php echo $form->label($userFull, 'sex'); ?>
	<?php echo $form->dropDownList($userFull, 'sex', $userFull->sexList, array(
		'empty' => 'Не указан',
	)); ?>
</div>

<div class="row">
	<?php echo $form->label($user, 'img'); ?>
	<?php echo $form->fileField($user, 'img'); ?>
	<?php echo $form->note($user, 'img'); ?><br />
    <?php echo $form->checkBox($user, 'deleteAvatar'); ?>
    <?php echo $form->label($user, 'deleteAvatar'); ?>
	<?php echo $form->error($user,'img'); ?>
</div>
<br />

<div class="row">
	<?php echo $form->label($userFull, 'email'); ?>
	<?php echo $form->textField($userFull, 'email'); ?>
	<?php echo $form->note($userFull, 'email'); ?>
	<?php echo $form->error($userFull,'email'); ?>
</div>
<br />

<div class="row">
	<?php echo $form->label($user, 'oldPassword'); ?>
	<?php echo $form->passwordField($user, 'oldPassword'); ?>
	<?php echo $form->note($user, 'oldPassword'); ?>
	<?php echo $form->error($user,'oldPassword'); ?>
</div>

<div class="row">
	<?php echo $form->label($user, 'newPassword'); ?>
	<?php echo $form->passwordField($user, 'newPassword'); ?>
	<?php echo $form->note($user, 'newPassword'); ?>
	<?php echo $form->error($user,'newPassword'); ?>
</div>

<div class="row">
	<?php echo $form->label($user, 'newPassword2'); ?>
	<?php echo $form->passwordField($user, 'newPassword2'); ?>
	<?php echo $form->note($user, 'newPassword2'); ?>
	<?php echo $form->error($user,'newPassword2'); ?>
</div>

<div class="row submit">
	<?php echo CHtml::submitButton('Сохранить изменения'); ?>
</div>

<?php $this->endWidget(); ?>