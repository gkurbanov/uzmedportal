<?php

use yii\helpers\Url;

?>

<?php
if ($pages) { ?>
    <div class="header-content-nav">
        <ul class="desktop-link-list">
            <?php foreach ($pages as $page) { ?>
                <li>
                    <a href="<?= Url:: to(["/page/{$page["slug"]}"]) ?>"
                       class="<?php if (Yii::$app->request->get('slug') == "{$page["slug"]}") {
                           echo "active";
                       } ?>">
                                    <span>
                                        <?= $page["title"] ?>
                                    </span>
                    </a>
                </li>
            <?php } ?>
            <li class="dropdown mobile-header-content-nav">
                <a href="#!" class="dropdown-btn mobile-menu-btn">
                    <img src="/frontend/web/assets/images/mobile-menu-btn.png" alt="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
                <ul class="dropdown-menu mobile-link-list">
                    <?php foreach ($pages as $page) { ?>
                        <li>
                            <a href="<?= Url:: to(["/page/{$page["slug"]}"]) ?>">
                                            <span>
                                                <?= $page["title"] ?>
                                            </span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </div><!-- ./header-content-nav -->
<?php } ?>