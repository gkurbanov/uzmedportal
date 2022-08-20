<?php

use common\models\MainSetting;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MainSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<!--begin::Container-->

<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
    <!--begin::Form-->
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>


        <div class="row">
            <?php
            $table_name = MainSetting::tableName();
            $base_path = "/backend/web/media/{$table_name}/{$table_name}_" . $model->id . "/";
            $image_blank = "/backend/web/assets/media/users/blank.png";
            ?>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label text-right"><?= MainSetting::instance()->getAttributeLabel('image') ?></label>
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
                                  data-table="<?= MainSetting::tableName() ?>"
                                  data-column="image"
                                  data-value="<?= $model->image ?>"
                                  data-input="<?= MainSetting::instance()->getAttribute("image") ?>"
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
                    <label class="col-xl-3 col-lg-3 col-form-label text-right"><?= MainSetting::instance()->getAttributeLabel('seo_image') ?></label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="image-input image-input-outline <?php if (!$model->seo_image) {
                            echo "image-input-empty";
                        } ?>" id="image_2"
                             style="background-image: url(<?php echo $image_blank; ?>)">
                            <div class="image-input-wrapper"
                                 style="background-image: <?php if (!$model->seo_image) {
                                     echo "image-input-empty";
                                 } else {
                                     echo "url(" . $base_path . $model->seo_image . ")";
                                 } ?>"></div>

                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                   data-action="change" data-toggle="tooltip" title=""
                                   data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <?= $form->field($model, 'seo_image', ['options' => ['tag' => false]])->fileInput(['maxlength' => true, 'accept' => '.png, .jpg, .jpeg'])->label("") ?>
                                <input type="hidden" name="profile_avatar_remove"/>

                            </label>

                            <div class="d-none image-input">
                                <?= $form->field($model, 'seo_image', ['options' => ['tag' => false]])->textInput()->label("Тут") ?>
                            </div>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-action="cancel" data-toggle="tooltip" title="Изменить изображение">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>

                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                  data-table="<?= MainSetting::tableName() ?>"
                                  data-column="seo_image"
                                  data-value="<?= $model->seo_image ?>"
                                  data-input="<?= MainSetting::instance()->getAttribute("seo_image") ?>"
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
            <div class="col-md-4">
                <?= $form->field($model, 'vk_link')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'youtube_link')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'instagram_link')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'facebook_link')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'registered_users_count')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'educational_org_count')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'high_level_programs_count')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'interactive_programs_count')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'studying_spec_count')->textInput(['maxlength' => true]) ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!--end::Form-->
</div>
<!--end::Card-->
<!--end::Container-->