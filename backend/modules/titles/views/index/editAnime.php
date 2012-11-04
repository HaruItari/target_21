<h1><?php echo ($title->isNewRecord) ? 'Новое аниме' : 'Редактирвать релиз'; ?></h1>

<?php  $form = $this->beginWidget('ActiveForm', array(
    'id' => 'anime-edit',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

<div class="row errors-list">
    <?php echo $form->errorSummary(array($title, $anime)); ?>
</div>

<div class="row long">
    <?php echo $form->label($title, 'headline'); ?>
    <?php echo $form->textField($title, 'headline'); ?>
    <?php echo $form->note($title, 'headline'); ?>
    <?php echo $form->error($title, 'headline'); ?>
</div>

<div class="row">
    <?php echo $form->label($title, 'section'); ?>
    <?php echo $form->dropDownList($title, 'section', MTitleSection::model()->getlistForDdl('anime')); ?>
    <?php echo $form->note($title, 'section'); ?>
    <?php echo $form->error($title, 'section'); ?>
</div>

<div class="row long">
    <?php echo $form->label($title, 'description'); ?>
    <?php echo $form->textArea($title, 'description', array(
        'rows' => 7,
    )); ?>
    <?php echo $form->note($title, 'description'); ?>
    <?php echo $form->error($title, 'description'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($title, 'cover'); ?>
    <?php echo $form->fileField($title, 'cover'); ?>
    <?php echo $form->note($title, 'cover'); ?>
    <?php echo $form->error($title, 'cover'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($title, 'screens'); ?>
    <?php echo $form->fileField($title, 'screen[0]'); ?>
    <?php echo $form->error($title, 'screen[0]'); ?><br />
    <span class="label"></span>
    <?php echo $form->fileField($title, 'screen[1]'); ?>
    <?php echo $form->error($title, 'screen[1]'); ?><br />
    <span class="label"></span>
    <?php echo $form->fileField($title, 'screen[2]'); ?>
    <?php echo $form->error($title, 'screen[2]'); ?><br />
    <span class="label"></span>
    <?php echo $form->fileField($title, 'screen[3]'); ?>
    <?php echo $form->error($title, 'screen[3]'); ?><br />
    <?php echo $form->note($title, 'screen[3]'); ?>
    <?php echo $form->error($title, 'screen'); ?>
</div>

<div class="row long">
    <?php echo $form->label($anime, 'type'); ?>
    <?php echo $form->textField($anime, 'type'); ?>
    <?php echo $form->note($anime, 'type'); ?>
    <?php echo $form->error($anime, 'type'); ?>
</div>

<div class="row">
    <?php echo $form->label($anime, 'edition_begin'); ?>
    <?php echo $form->textField($anime, 'edition_begin'); ?>
    <?php echo $form->note($anime, 'edition_begin'); ?>
    <?php echo $form->error($anime, 'edition_begin'); ?>
</div>

<div class="row">
    <?php echo $form->label($anime, 'edition_end'); ?>
    <?php echo $form->textField($anime, 'edition_end'); ?>
    <?php echo $form->note($anime, 'edition_end'); ?>
    <?php echo $form->error($anime, 'edition_end'); ?>
</div>

<div class="row long">
    <?php echo $form->label($anime, 'edition_details'); ?>
    <?php echo $form->textField($anime, 'edition_details'); ?>
    <?php echo $form->note($anime, 'edition_details'); ?>
    <?php echo $form->error($anime, 'edition_details'); ?>
</div>

<div class="row">
    <?php echo $form->label($anime, 'film_director'); ?>
    <?php echo $form->textField($anime, 'film_director'); ?>
    <?php echo $form->note($anime, 'film_director'); ?>
    <?php echo $form->error($anime, 'film_director'); ?>
</div>

<div class="row">
    <?php echo $form->label($anime, 'dub_type'); ?>
    <?php echo $form->dropDownList($anime, 'dub_type', MAnime::getDubTypesListForDdl()); ?><br />
    <?php echo $form->label($anime, 'dub_author'); ?>
    <?php echo $form->textField($anime, 'dub_author'); ?>
    <?php echo $form->error($anime, 'dub_author'); ?>
</div>

<div class="row">
    <?php echo $form->label($anime, 'subs_type'); ?>
    <?php echo $form->dropDownList($anime, 'subs_type', MAnime::getSubsTypesListForDdl()); ?><br />
    <?php echo $form->label($anime, 'subs_author'); ?>
    <?php echo $form->textField($anime, 'subs_author'); ?>
    <?php echo $form->error($anime, 'subs_author'); ?>
</div>

<div class="row long">
    <?php echo $form->label($anime, 'episodes_list'); ?>
    <?php echo $form->textArea($anime, 'episodes_list', array(
        'rows' => 10,
    )); ?>
    <?php echo $form->note($anime, 'episodes_list'); ?>
    <?php echo $form->error($anime, 'episodes_list'); ?>
</div>

<div class="row ">
    <?php echo $form->label($title, 'age_limit'); ?>
    <?php echo $form->textField($title, 'age_limit'); ?>
    <?php echo $form->note($title, 'age_limit'); ?>
    <?php echo $form->error($title, 'age_limit'); ?>
</div>

<div class="row long">
    <?php echo $form->label($title, 'edit_comment'); ?>
    <?php echo $form->textField($title, 'edit_comment'); ?>
    <?php echo $form->note($title, 'edit_comment'); ?>
    <?php echo $form->error($title, 'edit_comment'); ?>
</div>

<div class="row submit">
    <?php echo CHtml::submitButton('Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>