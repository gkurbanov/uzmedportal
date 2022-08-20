<?php

use common\models\Anons;
use yii\helpers\Html;
use yii\redactor\widgets\Redactor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Anons */
/* @var $form yii\widgets\ActiveForm */
?>


<!--begin::Container-->

<!--begin::Card-->
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

            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-6 col-form-label">
                        <div class="checkbox-inline">
                            <?= $form->field($model, 'is_active',
                                [
                                    'options' => [
                                        'tag' => false
                                    ],
                                ])->checkbox([
                                    'label' => '<span></span>' . Anons::instance()->getAttributeLabel('is_active'),
                                    'labelOptions' => [
                                        'class' => 'checkbox'
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'content_ru')->widget(\yii\redactor\widgets\Redactor::className(), [
                    'clientOptions' => [
                        'imageManagerJson' => ['/redactor/upload/image-json'],
                        'imageUpload' => ['/redactor/upload/image'],
                        'fileUpload' => ['/redactor/upload/file'],
                        'lang' => 'ru',
                        'plugins' => ['clips', 'fontcolor', 'imagemanager']
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

        <div class="d-none">
            <?= $form->field($model, 'created_at')->textInput() ?>

            <?= $form->field($model, 'updated_at')->textInput() ?>

            <?= $form->field($model, 'year')->textInput() ?>

            <?= $form->field($model, 'month')->textInput() ?>

            <?= $form->field($model, 'user_added')->textInput() ?>

        </div>

        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'seo_title_ru')->textInput() ?>
                <?= $form->field($model, 'seo_description_ru')->textarea(["rows" => 3]) ?>
                <?= $form->field($model, 'seo_keyword_ru')->textarea(["rows" => 2]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'seo_title_uz')->textInput() ?>
                <?= $form->field($model, 'seo_description_uz')->textarea(["rows" => 3]) ?>
                <?= $form->field($model, 'seo_keyword_uz')->textarea(["rows" => 2]) ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <?php
            $base_path = "/backend/web/media/anons/anons_" . $model->id . "/";
            $image_blank = "/backend/web/assets/media/users/blank.png";
            ?>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-right"><?= Anons::instance()->getAttributeLabel('image_ru') ?></label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="image-input image-input-outline <?php if (!$model->image_ru) {
                            echo "image-input-empty";
                        } ?>" id="image_1"
                             style="background-image: url(<?php echo $image_blank; ?>)">
                            <div class="image-input-wrapper"
                                 style="background-image: <?php if (!$model->image_ru) {
                                     echo "image-input-empty";
                                 } else {
                                     echo "url(" . $base_path . $model->image_ru . ")";
                                 } ?>"></div>

                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                   data-action="change" data-toggle="tooltip" title=""
                                   data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <?= $form->field($model, 'image_ru', ['options' => ['tag' => false]])->fileInput(['maxlength' => true, 'accept' => '.png, .jpg, .jpeg'])->label("") ?>
                                <input type="hidden" name="profile_avatar_remove"/>

                            </label>

                            <div class="d-none image-input">
                                <?= $form->field($model, 'image_ru', ['options' => ['tag' => false]])->textInput()->label("Тут") ?>
                            </div>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-action="cancel" data-toggle="tooltip" title="Изменить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-table="<?= Anons::tableName() ?>"
                                  data-column="image_ru"
                                  data-value="<?= $model->image_ru ?>"
                                  data-input="<?= Anons::instance()->getAttribute("image_ru") ?>"
                                  data-id="<?= $model->id ?>"
                                  data-action="remove" data-toggle="tooltip" title="Удалить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-right"><?= Anons::instance()->getAttributeLabel('image_uz') ?></label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="image-input image-input-outline <?php if (!$model->image_uz) {
                            echo "image-input-empty";
                        } ?>" id="image_2"
                             style="background-image: url(<?php echo $image_blank; ?>)">
                            <div class="image-input-wrapper"
                                 style="background-image: <?php if (!$model->image_uz) {
                                     echo "image-input-empty";
                                 } else {
                                     echo "url(" . $base_path . $model->image_uz . ")";
                                 } ?>"></div>

                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                               data-action="change" data-toggle="tooltip" title=""
                               data-original-title="Change avatar">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <?= $form->field($model, 'image_uz', ['options' => ['tag' => false]])->fileInput(['maxlength' => true, 'accept' => '.png, .jpg, .jpeg'])->label("") ?>
                            <input type="hidden" name="profile_avatar_remove"/>

                        </label>

                        <div class="d-none image-input">
                            <?= $form->field($model, 'image_uz', ['options' => ['tag' => false]])->textInput()->label("Тут") ?>
                        </div>

                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                              data-action="cancel" data-toggle="tooltip" title="Изменить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                              data-table="<?= Anons::tableName() ?>"
                              data-column="image_uz"
                              data-value="<?= $model->image_uz ?>"
                              data-input="<?= Anons::instance()->getAttribute("image_uz") ?>"
                              data-id="<?= $model->id ?>"
                              data-action="remove" data-toggle="tooltip" title="Удалить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                    </div>
                </div>
            </div>

        </div>
        </div>

        <hr>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!--end::Form-->
</div>
<!--end::Card-->
<!--end::Container-->
