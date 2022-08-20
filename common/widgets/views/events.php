<?php

?>

<?php if ($items) { ?>
    <section class="cards">
        <div class="container">
            <h1 class="title">
                События
            </h1><!-- ./title -->
            <div class="card-container grid-5">
                <?php foreach ($items as $item) { ?>
                    <div class="card red-border card-box-shadow">
                        <a href="<?= \yii\helpers\Url::to(["/events/{$item["slug"]}"]) ?>">
                            <div class="card-img">
                                <img src="<?= $item["image"] ?>" alt="<?= $item["title"] ?>">
                            </div>
                            <div class="card-info">
                                <!--                                <p class="card-start-date subtitle">-->
                                <!--                                    31 марта-2 апреля-->
                                <!--                                </p>-->
                                <p class="card-info-text subtitle">
                                    <?= $item["title"] ?>
                                </p>
                                <p class="card-publication-date subtitle">
                                    <?= $item["date"] ?>
                                </p>
                            </div>
                        </a>
                    </div><!-- ./card -->
                <?php } ?>

            </div><!-- ./card-container -->
            <div class="card-btn">
                <a href="<?= \yii\helpers\Url::to(["/events/all"]) ?>" class="btn-outline">
                    Показать всё
                </a>
            </div>
        </div><!-- ./container -->
    </section><!-- ./cards -->
<?php } ?>
