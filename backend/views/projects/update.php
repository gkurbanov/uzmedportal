<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Anons */

$this->title = 'Редактирование проекта: ' . $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Anons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="anons-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
