<?php

use common\models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title">
            Форма заполнения
        </h3>
    </div>
    <!--begin::Form-->
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model) ?>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-form-label text-left col-lg-12 col-sm-12">Родительская страница</label>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <select class="form-control selectpicker" name="Page[parent_id]"
                                data-size="7" data-live-search="true">
                            <option value="">Выберите родительскую страницу</option>
                            <?php if ($pages) {
                                foreach ($pages as $page) { ?>
                                    <option <?php if ($model->parent_id == $page["first"]["id"]) {
                                        echo "selected";
                                    } ?> value="<?= $page["first"]["id"] ?>"><?= $page["first"]["title"] ?></option>
                                    <?php
                                    if ($page["second"]) {
                                        foreach ($page["second"] as $second) { ?>
                                            <option <?php if ($model->parent_id == $second["id"]) {
                                                echo "selected";
                                            } ?> value="<?= $second["id"] ?>"> - <?= $second["title"] ?></option>
                                            <?php
                                            if ($second["third"]) {
                                                foreach ($second["third"] as $third) { ?>
                                                    <option disabled value="<?= $third["id"] ?>"> -
                                                        - <?= $third["title_ru"] ?></option>
                                                <?php }
                                            }
                                        } ?>
                                    <?php }
                                    ?>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <?= $form->field($model, 'is_active',
                                [
                                    'options' => [
                                        'tag' => false
                                    ],
                                ])->checkbox([
                                    'label' => '<span></span>' . Page::instance()->getAttributeLabel('is_active'),
                                    'labelOptions' => [
                                        'class' => 'checkbox'
                                    ],

                                ]
                            ) ?>

                            <?= $form->field($model, 'is_document',
                                [
                                    'options' => [
                                        'tag' => false
                                    ],
                                ])->checkbox([
                                    'label' => '<span></span>' . Page::instance()->getAttributeLabel('is_document'),
                                    'labelOptions' => [
                                        'class' => 'checkbox'
                                    ],

                                ]
                            ) ?>

                            <?= $form->field($model, 'is_main',
                                [
                                    'options' => [
                                        'tag' => false
                                    ],
                                ])->checkbox([
                                    'label' => '<span></span>' . Page::instance()->getAttributeLabel('is_main'),
                                    'labelOptions' => [
                                        'class' => 'checkbox'
                                    ],

                                ]
                            ) ?>

                            <?= $form->field($model, 'is_footer',
                                [
                                    'options' => [
                                        'tag' => false
                                    ],
                                ])->checkbox([
                                    'label' => '<span></span>' . Page::instance()->getAttributeLabel('is_footer'),
                                    'labelOptions' => [
                                        'class' => 'checkbox'
                                    ],

                                ]
                            ) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'content_ru')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'clientOptions' => [
                        'imageManagerJson' => ['/redactor/upload/image-json'],
                        'imageUpload' => ['/redactor/upload/image'],
                        'fileUpload' => ['/redactor/upload/file'],
                        'lang' => 'ru',
                        'plugins' => ['clips', 'fontcolor', 'imagemanager', 'properties']
                    ]
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'content_uz')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'clientOptions' => [
                        'imageManagerJson' => ['/redactor/upload/image-json'],
                        'imageUpload' => ['/redactor/upload/image'],
                        'fileUpload' => ['/redactor/upload/file'],
                        'lang' => 'ru',
                        'plugins' => ['clips', 'fontcolor', 'imagemanager']
                    ]
                ]) ?>
            </div>
        </div>


        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'seo_title_ru')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'seo_description_ru')->textarea(['rows' => 3]) ?>

                <?= $form->field($model, 'seo_keyword_ru')->textarea(['rows' => 2]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'seo_title_uz')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'seo_description_uz')->textarea(['rows' => 3]) ?>

                <?= $form->field($model, 'seo_keyword_uz')->textarea(['rows' => 2]) ?>
            </div>
        </div>

        <!--        --><? //= $form->field($model, 'order_top')->textInput() ?>
        <!---->
        <!--        --><? //= $form->field($model, 'order_aside')->textInput() ?>
        <!---->
        <!--        --><? //= $form->field($model, 'order_footer')->textInput() ?>


        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!--end::Form-->
</div>
