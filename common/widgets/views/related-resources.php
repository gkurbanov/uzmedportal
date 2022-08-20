<?php


?>

<?php if ($items) { ?>
    <section class="related-resources">
        <div class="container">
            <h1 class="title">
                Связанные ресурсы
            </h1><!-- ./title -->
            <div class="related-resources-container grid-5">
                <?php foreach ($items as $item) { ?>
                    <div class="related-resources-item">
                        <a href="<?= $item["link_url"] ?>" title="<?= $item["site_name"] ?>" target="_blank" class="related-resources-links">
                            <img src="<?= $item["image"] ?>" alt="<?= $item["site_name"] ?>">
                            <span>
                                    <?= $item["site_name"] ?>
                                </span>
                        </a>
                        <p class="subtitle">
                            <?= $item["title"] ?>
                        </p>
                    </div><!-- ./elated-resources-item -->
                <?php } ?>
            </div><!-- ./elated-resources-container -->
        </div><!-- ./container -->
    </section><!-- ./related-resources -->
<?php } ?>
