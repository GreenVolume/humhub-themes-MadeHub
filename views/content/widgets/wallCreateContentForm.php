<?php

use yii\helpers\Html;
use humhub\modules\space\models\Space;

\humhub\modules\content\assets\ContentFormAsset::register($this);
$this->registerJsConfig('content.form', [
    'defaultVisibility' => $defaultVisibility,
    'disabled' => ($contentContainer instanceof Space && $contentContainer->isArchived()),
    'text' => [
        'makePrivate' => Yii::t('ContentModule.widgets_views_contentForm', 'Make private'),
        'makePublic' => Yii::t('ContentModule.widgets_views_contentForm', 'Make public'),
        'info.archived' => Yii::t('ContentModule.widgets_views_contentForm', 'This space is archived.')
]]);
?>

<div class="panel panel-default clearfix">
    <div class="panel-body" id="contentFormBody" style="display:none;" data-action-component="content.form.CreateForm" >
        <?php echo Html::beginForm($submitUrl, 'POST'); ?>

        <?php echo $form; ?>

        <div id="notifyUserContainer" class="form-group" style="margin-top: 15px;display:none;">
            <?php
            echo humhub\modules\user\widgets\UserPickerField::widget([
                'id' => 'notifyUserInput',
                'url' => ($contentContainer instanceof Space) ? $contentContainer->createUrl('/space/membership/search') : null,
                'formName' => 'notifyUserInput',
                'maxSelection' => 10,
                'disabledItems' => [Yii::$app->user->guid],
                'placeholder' => Yii::t('ContentModule.widgets_views_contentForm', 'Add a member to notify'),
            ])
            ?>
        </div>

        <?php echo Html::hiddenInput("containerGuid", $contentContainer->guid); ?>
        <?php echo Html::hiddenInput("containerClass", get_class($contentContainer)); ?>

        <ul id="contentFormError"></ul>

        <div class="contentForm_options">
            <hr>
            <div class="btn_container">
                <button id="post_submit_button" data-action-click="submit" data-action-submit data-ui-loader class="btn btn-info">
                    <?= $submitButtonText ?>
                </button>

                <?php
                $uploadButton = humhub\modules\file\widgets\UploadButton::widget([
                            'id' => 'contentFormFiles',
                            'progress' => '#contentFormFiles_progress',
                            'preview' => '#contentFormFiles_preview',
                            'dropZone' => '#contentFormBody',
                            'max' => Yii::$app->getModule('content')->maxAttachedFiles
                ]);
                ?>
                <?php echo humhub\modules\file\widgets\FileHandlerButtonDropdown::widget(['primaryButton' => $uploadButton, 'handlers' => $fileHandlers, 'cssButtonClass' => 'btn-default']); ?>

                <!-- public checkbox -->
                <?php echo Html::checkbox("visibility", "", array('id' => 'contentForm_visibility', 'class' => 'contentForm hidden')); ?>

                <!-- content sharing -->
                <div class="pull-right">

                    <span class="label label-success label-public hidden"><?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Public'); ?></span>

                    <ul class="nav nav-pills preferences" style="right: 0; top: 5px;">
                        <li class="dropdown">
                            <a class="dropdown-toggle" style="padding: 5px 10px;" data-toggle="dropdown" href="#"><i
                                    class="fa fa-cogs"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a data-action-click="notifyUser">
                                        <i class="fa fa-bell"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Notify members'); ?>
                                    </a>
                                </li>
                                <?php if ($canSwitchVisibility): ?>
                                    <li>
                                        <a id="contentForm_visibility_entry" data-action-click="changeVisibility">
                                            <i class="fa fa-unlock"></i> <?php echo Yii::t('ContentModule.widgets_views_contentForm', 'Make public'); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <?php echo \humhub\modules\file\widgets\UploadProgress::widget(['id' => 'contentFormFiles_progress']) ?>
            <?php echo \humhub\modules\file\widgets\FilePreview::widget(['id' => 'contentFormFiles_preview', 'edit' => true, 'options' => ['style' => 'margin-top:10px;']]); ?>

        </div>
        <!-- /contentForm_Options -->
        <?php echo Html::endForm(); ?>
    </div>
    <!-- /panel body -->
</div> <!-- /panel -->
