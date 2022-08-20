<?php

use common\models\Anons;
use common\models\RelatedResource;
use common\models\Slider;
use common\models\Sliderr as SliderrAlias;
use justinvoelker\separatedpager\LinkPager;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Связанные ресурсы';
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
                    <th style="min-width: 110px"><?= RelatedResource::instance()->getAttributeLabel('title_ru') ?></th>
                    <th style="min-width: 110px">
                        <span class="text-info"><?= RelatedResource::instance()->getAttributeLabel('site_name') ?></span>
                    </th>
                    <th style="min-width: 120px"><?= Slider::instance()->getAttributeLabel('image') ?></th>
                    <th style="min-width: 120px"><?= Slider::instance()->getAttributeLabel('is_active') ?></th>
                    <th class="pr-0 text-right" style="min-width: 160px">Действия</th>
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
                                <?= $record->title_ru ?>
                            </span>

                        </td>
                        <td>
                            <span class="text-info font-weight-bolder d-block font-size-lg">
                               <?= $record->site_name ?>
                            </span>

                        </td>
                        <td>
                            <?php if ($record->image) { ?>
                                <div class="symbol symbol-50 flex-shrink-0">
                                    <img src="/backend/web/media/related_resource/related_resource_<?= $record->id; ?>/<?= $record->image ?>"
                                         alt="photo">
                                </div>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($record->is_active == "1") { ?>
                                <span class="label label-lg label-light-success label-inline">Активный</span>
                            <?php } else { ?>
                                <span class="label label-lg label-light-danger label-inline">Деактивирован</span>
                            <?php } ?>
                        </td>
                        <td class="pr-0 text-right">
                            <a href="<?= Url::to([Yii::$app->controller->id . "/update?id={$record->id}"]) ?>"
                               class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                  fill="#000000" fill-rule="nonzero"
                                                  transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>
                                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                  fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
                            <a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                <span class="svg-icon svg-icon-md svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                  fill="#000000" fill-rule="nonzero"/>
                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                  fill="#000000" opacity="0.3"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </a>
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

