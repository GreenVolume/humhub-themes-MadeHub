<?php

use yii\bootstrap\ActiveForm;
use yii\helper\Html;
use humhub\modules\content\models\Content;
?>
<h4><?= Yii::t('AdminModule.views_space_settings', 'Space Settings'); ?></h4>
<div class="help-block">
    <?= Yii::t('AdminModule.views_space_index', 'Here you can define your default settings for new spaces. These settings can be overwritten for each individual space.'); ?>
</div>

<br />

<?php $form = ActiveForm::begin(['id' => 'space-settings-form']); ?>

<?= $form->errorSummary($model); ?>

<div class="form-group">
    <?= $form->labelEx($model, 'defaultJoinPolicy'); ?>
    <?php $joinPolicies = array(0 => Yii::t('SpaceModule.base', 'Only by invite'), 1 => Yii::t('SpaceModule.base', 'Invite and request'), 2 => Yii::t('SpaceModule.base', 'Everyone can enter')); ?>
    <?= $form->dropDownList($model, 'defaultJoinPolicy', $joinPolicies, array('class' => 'form-control', 'id' => 'join_policy_dropdown', 'hint' => Yii::t('SpaceModule.views_admin_edit', 'Choose the kind of membership you want to provide for this workspace.'))); ?>
</div>

<div class="form-group">
    <?= $form->labelEx($model, 'defaultVisibility'); ?>
    <?php
    $visibilities = array(
        0 => Yii::t('SpaceModule.base', 'Private (Invisible)'),
        1 => Yii::t('SpaceModule.base', 'Public (Visible)')
            /* 2 => Yii::t('SpaceModule.base', 'Visible for all') */
    );
    ?>
    <?= $form->dropDownList($model, 'defaultVisibility', $visibilities, array('class' => 'form-control', 'id' => 'join_visibility_dropdown', 'hint' => Yii::t('SpaceModule.views_admin_edit', 'Choose the security level for this workspace to define the visibleness.'))); ?>
    <?= $form->error($model, 'defaultVisibility'); ?>
</div>

<div class="form-group">
    <?= $form->labelEx($model, 'defaultContentVisibility'); ?>
    <?= $form->dropDownList($model, 'defaultContentVisibility', [Content::VISIBILITY_PRIVATE => Yii::t('SpaceModule.base', 'Private'), Content::VISIBILITY_PUBLIC => Yii::t('SpaceModule.base', 'Public')], array('class' => 'form-control')); ?>
</div>

<hr>

<?= Html::submitButton(Yii::t('AdminModule.views_space_settings', 'Save'), array('class' => 'btn btn-primary', 'data-ui-loader' => "")); ?>

<?php \humhub\widgets\DataSaved::widget(); ?>
<?php ActiveForm::end(); ?>
