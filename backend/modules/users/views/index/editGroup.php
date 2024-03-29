<h1><?php echo ($group->isNewRecord) ? 'Новая группа' : 'Редактировать группу'; ?></h1>

<?php  $form = $this->beginWidget('ActiveForm', array(
    'id' => 'group-edit',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
)); ?>

<div class="row errors-list">
    <?php echo $form->errorSummary($group); ?>
</div>

<div class="row">
    <?php echo $form->label($group, 'group'); ?>
    <?php echo $form->textField($group, 'group'); ?>
    <?php echo $form->error($group, 'group'); ?>
</div>

<div class="row">
    <?php echo $form->label($group, 'role'); ?>
    <?php echo $form->textField($group, 'role'); ?>
    <?php echo $form->error($group, 'role'); ?>
</div>

<div class="row long">
    <?php echo $form->label($group, 'style'); ?>
    <?php echo $form->textArea($group, 'style', array(
        'rows' => 3,
    )); ?>
    <?php echo $form->error($group, 'style'); ?>
</div>

<div class="row">
    <?php echo $form->checkBox($group, 'is_default'); ?>
    <?php echo $form->label($group, 'is_default'); ?>
</div>

<div class="row submit">
    <?php echo CHtml::submitButton(($group->isNewRecord) ? 'Добавить' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>