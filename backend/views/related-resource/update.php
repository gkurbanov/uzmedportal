<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RelatedResource */

$this->title = 'Редактирование слайда: ' . $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Related Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="related-resource-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
