<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MainSetting */

$this->title = 'Основные настройки портала';
$this->params['breadcrumbs'][] = ['label' => 'Main Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-setting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
