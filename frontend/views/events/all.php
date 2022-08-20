<?php

?>

<div class="container">
    <div class="info-container">
        <aside class="info-side-menu">
            <div class="aside">
                <h4 class="news-title">Архив событий по месяцам</h4>
                <?php use justinvoelker\separatedpager\LinkPager;
                use yii\helpers\Url;

                if ($archive) { ?>
                    <?=
                    $this->render(
                        '/templates/archive-aside.php',
                        array(
                            'archive' => $archive,
                        )
                    );
                    ?>
                <?php } ?>
            </div><!-- ./aside -->
        </aside>
        <div class="info-content">
            <div class="info-content-container">
                <h1 class="title">
                    События
                </h1><!-- ./info-content-title -->
                <div class="news-card-container">
                    <?php if ($items) {
                        foreach ($items as $item) { ?>
                            <div class="news-card">
                                <div class="news-card-img">
                                    <a href="<?= Url::to(["/events/{$item["slug"]}"])?>">
                                        <img src="<?= $item["image"]?>" alt="<?= $item["title"]?>">
                                    </a>
                                </div>
                                <div class="news-card-content">
                                    <div class="news-card-date">
                                        <?= $item["date"]?>
                                    </div>
                                    <a href="<?= Url::to(["/events/{$item["slug"]}"])?>" class="news-card-link">
                                       <?= $item["title"]?>
                                    </a>
                                </div>
                            </div><!-- ./news-card -->
                        <?php }
                    } ?>
                </div><!-- ./news-card-container -->
                <div class="page-nav">
                    <p>Страница <?=$pages->offset+1 ?> из <?= $pages->totalCount?>.</p>

                    <?php
                    echo LinkPager::widget([
                        'id' => 'my-pager',
                        'pagination' => $pages,
                        'activePageCssClass' => 'active-page',
                        'prevPageLabel' => ' Назад',
                        'nextPageLabel' => ' Далее',
                        'maxButtonCount' => 9,
                        'options' => [
                            'class' => 'pagination'
                        ]
                    ]);
                    ?>


                </div>
            </div><!-- ./info-content-container -->
        </div><!-- ./info-content -->
    </div><!-- ./info-container -->
</div><!-- ./container -->
