<?php

use common\models\Slider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
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
            <div class="col-md-6">
                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'button_text_ru')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'button_link_ru')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'button_text__uz')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'button_link_uz')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="d-none">
            <?= $form->field($model, 'created_at')->textInput() ?>
            <?= $form->field($model, 'updated_at')->textInput() ?>
        </div>

        <hr>

        <div class="row">
            <?php
            $table_name = Slider::tableName();
            $base_path = "/backend/web/media/{$table_name}/{$table_name}_" . $model->id . "/";
            $image_blank = "/backend/web/assets/media/users/blank.png";
            ?>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-right"><?= Slider::instance()->getAttributeLabel('image') ?></label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="image-input image-input-outline <?php if (!$model->image) {
                            echo "image-input-empty";
                        } ?>" id="image_1"
                             style="background-image: url(<?php echo $image_blank; ?>)">
                            <div class="image-input-wrapper"
                                 style="background-image: <?php if (!$model->image) {
                                     echo "image-input-empty";
                                 } else {
                                     echo "url(" . $base_path . $model->image . ")";
                                 } ?>"></div>

                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                   data-action="change" data-toggle="tooltip" title=""
                                   data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <?= $form->field($model, 'image', ['options' => ['tag' => false]])->fileInput(['maxlength' => true, 'accept' => '.png, .jpg, .jpeg'])->label("") ?>
                                <input type="hidden" name="profile_avatar_remove"/>

                            </label>

                            <div class="d-none image-input">
                                <?= $form->field($model, 'image', ['options' => ['tag' => false]])->textInput()->label("Тут") ?>
                            </div>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-action="cancel" data-toggle="tooltip" title="Изменить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-table="<?= Slider::tableName() ?>"
                                  data-column="image"
                                  data-value="<?= $model->image ?>"
                                  data-input="<?= Slider::instance()->getAttribute("image") ?>"
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
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!--end::Form-->
</div>
<!--end::Card-->
<!--end::Container-->
