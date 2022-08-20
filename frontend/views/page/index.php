<?php

use yii\helpers\Url;

?>


<div class="container">
    <div class="info-container">
        <aside class="info-side-menu">
            <div class="aside">
                <ul class="info-side-menu-links">
                        <?php
                    if ($items) {
                        foreach ($items as $item) {
                            ?>
                            <li
                                    <?php if ($item["is_document"] == "1") {?> data-bs-toggle="modal" data-bs-target="#modalPDF" <?php } ?>
                                    class="<?php if (Yii::$app->request->get('slug2') == "{$item["slug"]}") {
                                echo "active selected";
                            }
                            if ($item["is_document"] == "1") {
                                echo "memo";
                            } ?>">
                                <a  <?php if ($item["is_document"] == "0") { ?> href="<?= Url::to(["/page/{$content["slug"]}/{$item["slug"]}"]) ?>" <?php } ?>>
                                    <?= $item["title"] ?>
                                </a>
                                <?php
                                if ($item["child"]) { ?>
                                    <ul>
                                        <?php foreach ($item["child"] as $child) { ?>
                                            <li class="<?php if (Yii::$app->request->get('slug3') == "{$child["slug"]}") {
                                                echo "active selected";
                                            } ?>">
                                                <a href="<?= Url::to(["/page/{$content["slug"]}/{$item["slug"]}/{$child["slug"]}"]) ?>">
                                                    <?= $child["title"] ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>


                        <?php }
                    } ?>

                </ul>
            </div>
        </aside>
        <div class="info-content">
            <div class="breadcrumbs">
                <div class="breadcrumbs-item">
                    <a href="<?= Url::to(["/page/{$content["slug"]}"]) ?>">
                        <?= $content["title"] ?>
                    </a>
                </div>
                <?php if ($current_page) { ?>
                    <div class="breadcrumbs-item active">
                        <span class="breadcrumbs-arrow">></span>
                        <a href="#!">
                            <?= $current_page["title"] ?>
                        </a>
                    </div>
                <?php } ?>
            </div><!-- ./breadcrumbs -->
            <div class="info-content-container">
                <div class="info-content-img">
                    <img src="/frontend/web/assets/images/info-img-1.jpg" alt="">
                </div>
                <div class="info-content-text">
                    <h1 class="title">
                        <?= $current_page["title"] ?>
                    </h1><!-- ./info-content-title -->
                    <?= $current_page["content"] ?>
                </div><!-- ./info-content-text -->

                <!--                    <li>-->
                <!--                        <a href="#!">-->
                <!--                            Федеральные законы-->
                <!--                        </a>-->
                <!--                    </li>-->
                <!--                    <li>-->
                <!--                        <a href="#!">-->
                <!--                            Постановления Правительства РФ-->
                <!--                        </a>-->
                <!--                    </li>-->
                <!--                    <li>-->
                <!--                        <a href="#!">-->
                <!--                            Нормативные правовые акты федеральных органов исполнительной власти-->
                <!--                        </a>-->
                <!--                    </li>-->
                <!--                    <li>-->
                <!--                        <ul>-->
                <!--                            <li>-->
                <!--                                <a href="#!">-->
                <!--                                    Приказы Минздрава России-->
                <!--                                </a>-->
                <!--                            </li>-->
                <!--                            <li>-->
                <!--                                <a href="#!">-->
                <!--                                    Приказы Минобрнауки России-->
                <!--                                </a>-->
                <!--                            </li>-->
                <!--                        </ul>-->
                <!--                    </li>-->
                <!--                    <li>-->
                <!--                        <a href="#!">-->
                <!--                            Другие документы-->
                <!--                        </a>-->
                <!--                    </li>-->
            </div><!-- ./info-content-container -->
        </div><!-- ./info-content -->
    </div><!-- ./info-container -->
</div><!-- ./container -->

<!-- Modal -->
<div class="modal" id="modalPDF" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalPDFLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    x
                </button>
            </div>
            <div class="modal-body">
                <iframe class="modal-iframe" src="assets/images/Pamjatka_obuchajushchiesja.pdf" frameborder="0"
                        allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
</div>