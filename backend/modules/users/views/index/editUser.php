<h1>Редактировать профиль</h1>

<?php  $form = $this->beginWidget('ActiveForm', array(
    'id' => 'user-edit',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
)); ?>

<div class="row errors-list">
    <?php echo $form->errorSummary(array($user, $userFull)); ?>
</div>

<?php if(Yii::app()->user->checkAccess('users_edit_profile_login')) { ?>
    <div class="row">
        <?php echo $form->label($user, 'login'); ?>
        <?php echo $form->textField($user, 'login'); ?>
        <?php echo $form->error($user, 'login'); ?>
    </div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('users_edit_profile_group', array('id'=>$user->id))) { ?>
    <div class="row">
        <?php echo $form->label($user, 'group'); ?>
        <?php echo $form->dropDownList($user, 'group', MUserGroup::getListForDdl()); ?>
        <?php echo $form->error($user, 'group'); ?>
    </div>
<?php } ?>

<?php if(Yii::app()->user->checkAccess('users_edit_profile_email')) { ?>
    <div class="row">
        <?php echo $form->label($userFull, 'email'); ?>
        <?php echo $form->textField($userFull, 'email'); ?><br />
        <?php echo $form->checkBox($userFull, 'email_confirm'); ?>
        <?php echo $form->label($userFull, 'email_confirm'); ?>
    </div>
<?php } ?>

<div class="row submit">
    <?php echo CHtml::submitButton('Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>