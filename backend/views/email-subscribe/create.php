<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EmailSubscribe */

$this->title = 'Create Email Subscribe';
$this->params['breadcrumbs'][] = ['label' => 'Email Subscribes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-subscribe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
