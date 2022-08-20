<?php


?>

<?php
if ($items) { ?>
    <div class="main-slider">
        <div class="swiper-wrapper">
            <?php foreach ($items as $item) { ?>
                <div class="swiper-slide">
                    <div class="main-slider-item">
                        <div class="main-slider-title">
                            <h1>
                                <?= $item["title"]?>
                            </h1>
                        </div><!-- ./smain-slider-title -->
                        <div class="main-slider-btn">
                            <a href="<?= $item["button_link"]?>" class="btn-fill">
                               <?= $item["button_text"]?>
                            </a>
                        </div><!-- ./main-slider-btn -->
                        <div class="main-slider-img">
                            <img src="<?= $item["image"]?>" alt="<?= $item["title"]?>">
                        </div><!-- ./main-slider-img -->
                    </div><!-- ./main-slider-item -->
                </div><!-- ./swiper-slide -->
            <?php } ?>
        </div><!-- ./swiper-wrapper -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div><!-- ./main-slider -->
<?php } ?>