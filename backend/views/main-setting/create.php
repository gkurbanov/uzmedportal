<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MainSetting */

$this->title = 'Create Main Setting';
$this->params['breadcrumbs'][] = ['label' => 'Main Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
