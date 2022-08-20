<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Main Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Main Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'image',
            'seo_image',
            'site_name',
            'seo_title_ru',
            //'seo_description_ru',
            //'seo_keyword_ru',
            //'seo_title_uz',
            //'seo_description_uz',
            //'seo_keyword_uz',
            //'vk_link',
            //'youtube_link',
            //'instagram_link',
            //'facebook_link',
            //'registered_users_count',
            //'educational_org_count',
            //'high_level_programs_count',
            //'interactive_programs_count',
            //'studying_spec_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
