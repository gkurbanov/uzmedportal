<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MainSetting */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Main Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="main-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'image',
            'seo_image',
            'site_name',
            'seo_title_ru',
            'seo_description_ru',
            'seo_keyword_ru',
            'seo_title_uz',
            'seo_description_uz',
            'seo_keyword_uz',
            'vk_link',
            'youtube_link',
            'instagram_link',
            'facebook_link',
            'registered_users_count',
            'educational_org_count',
            'high_level_programs_count',
            'interactive_programs_count',
            'studying_spec_count',
        ],
    ]) ?>

</div>
