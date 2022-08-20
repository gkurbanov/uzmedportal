<?php

use common\models\EmailSubscribe;
use justinvoelker\separatedpager\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подписка на новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--begin::Advance Table Widget 10-->
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-1 overflow-hidden">
        <h3 class="card-title align-items-start flex-column">
            <span class="text-muted mt-1 font-weight-bold font-size-sm">В системе <?= $count; ?> записей</span>
        </h3>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body py-0">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_4">
                <thead>
                <tr class="text-left">
                    <th class="pl-0" style="width: 30px">
                        <label class="checkbox checkbox-lg checkbox-inline mr-2">
                            <input type="checkbox" value="1"/>
                            <span></span>
                        </label>
                    </th>
                    <th class="pl-0" style="min-width: 50px">Id</th>
                    <th style="min-width: 110px"><?= EmailSubscribe::instance()->getAttributeLabel('added_at') ?></th>
                    <th style="min-width: 110px">
                        <span class="text-info"><?= EmailSubscribe::instance()->getAttributeLabel('first_name') ?></span>
                    </th>
                    <th style="min-width: 110px"><?= EmailSubscribe::instance()->getAttributeLabel('email') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($records as $record) { ?>
                    <tr>
                        <td class="pl-0 py-6">
                            <label class="checkbox checkbox-lg checkbox-inline">
                                <input type="checkbox" value="1"/>
                                <span></span>
                            </label>
                        </td>
                        <td class="pl-0">
                            <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">
                                <?= "№ {$record->id}" ?>
                            </a>
                        </td>
                        <td>
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                <?= $record->added_at ?>
                            </span>

                        </td>
                        <td>
                            <span class="text-info font-weight-bolder d-block font-size-lg">
                               <?= $record->first_name ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-info font-weight-bolder d-block font-size-lg">
                               <?= $record->email ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <!--begin::Pagination-->
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-wrap mr-3">
                    <?php
                    echo LinkPager::widget([
                        'id' => 'my-pager',
                        'pagination' => $pages,
                        'activePageCssClass' => 'active-page',
                        'prevPageLabel' => '<i class="ki ki-bold-arrow-back icon-xs"></i>',
                        'nextPageLabel' => '<i class="ki ki-bold-arrow-next icon-xs"></i>',
                        'maxButtonCount' => 9,
                        'options' => [
                            'class' => 'datatable-pager-nav mb-5 mb-sm-0'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <!--end::Pagination-->
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 10-->
