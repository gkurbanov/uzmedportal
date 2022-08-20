<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RelatedResource */

$this->title = 'Создание нового слайда';
$this->params['breadcrumbs'][] = ['label' => 'Related Resources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="related-resource-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
