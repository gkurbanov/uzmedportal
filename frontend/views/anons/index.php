<?php


use yii\helpers\Url; ?>

<div class="container">
    <div class="info-container">
        <aside class="info-side-menu">
            <div class="aside">
                <h4 class="news-title">Архив анонсов по месяцам</h4>
                <?php if ($archive) { ?>
                    <?=
                    $this->render(
                        '/templates/archive-aside.php',
                        array(
                            'archive' => $archive,
                        )
                    );
                    ?>
                <?php } ?>
            </div>
        </aside>
        <div class="info-content">
            <div class="breadcrumbs">
                <div class="breadcrumbs-item">
                    <a href="<?= Url::to(["/anons/all"]) ?>">
                        Анонсы
                    </a>
                </div>
                <div class="breadcrumbs-item active">
                    <span class="breadcrumbs-arrow">></span>
                    <a href="#!">
                        <?= $content["title"] ?>
                    </a>
                </div>
            </div><!-- ./breadcrumbs -->
            <div class="info-content-container">
                <div class="info-content-text">
                    <h1 class="title">
                        <?= $content["title"] ?>
                    </h1><!-- ./info-content-title -->
                    <?= $content["content"] ?>
                </div><!-- ./info-content-text -->
            </div><!-- ./info-content-container -->
        </div><!-- ./info-content -->
    </div><!-- ./info-container -->
</div><!-- ./container -->

