<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

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
            'is_active',
            'is_document',
            'is_main',
            'is_footer',
            'order_top',
            'order_aside',
            'order_footer',
            'title_ru',
            'title_uz',
            'content_ru:ntext',
            'content_uz:ntext',
            'level',
            'parent_id',
            'slug',
            'file',
            'seo_title_ru',
            'seo_description_ru',
            'seo_keyword_ru',
            'seo_title_uz',
            'seo_description_uz',
            'seo_keyword_uz',
        ],
    ]) ?>

</div>
