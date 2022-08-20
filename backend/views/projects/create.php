<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Anons */

$this->title = 'Регистрация проекта';
$this->params['breadcrumbs'][] = ['label' => 'Anons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anons-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
