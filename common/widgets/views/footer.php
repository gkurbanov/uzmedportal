<?php

use yii\helpers\Url;

?>

<footer class="footer">
    <div class="container">
        <div class="footer-container grid-5">
            <ul class="footer-item">
                <li>
                    <a href="<?= Url::to(["/projects/all"])?>">
                        События
                    </a>
                </li>
                <li>
                    <a href="<?= Url::to(["/anons/all"])?>">
                        Анонсы мероприятий
                    </a>
                </li>
                <li>
                    <a href="#!">
                        Пользовательское соглашение
                    </a>
                </li>
            </ul><!-- ./footer-item -->
            <?php
            if ($items) {
                foreach ($items as $item) { ?>
                    <ul class="footer-item">
                        <li>
                            <a href="<?= Url::to(["/page/{$item["slug"]}"]) ?>">
                                <?= $item["title"] ?>
                            </a>
                        </li>
                        <?php if ($item["child"]) {
                            foreach ($item["child"] as $value){ ?>
                                <li>
                                    <a href="<?= Url::to(["/page/{$value["slug"]}"]) ?>">
                                        <?= $value["title"] ?>
                                    </a>
                                </li>
                            <?php }
                        }?>

                    </ul><!-- ./footer-item -->
                <?php }
            } ?>
            <ul class="footer-item">
                <li>
                    <a href="#!">
                        О Портале
                    </a>
                </li>
                <li>
                    <a href="#!">
                        Карта сайта
                    </a>
                </li>
                <li>
                    <a href="#!">
                        Часто задаваемые вопросы
                    </a>
                </li>
                <li>
                    <a href="#!">
                        Техподдержка
                    </a>
                </li>
            </ul><!-- ./footer-item -->
        </div><!-- ./footer-container -->
        <div class="copyright">
            <p class="subtitle">
                © 2022 Министерство здравоохранения Российской Федерации
            </p>
            <a href="#!">
                <img src="assets/images/liveinternet.gif" alt="">
            </a>
        </div><!-- ./copyright -->
    </div><!-- ./container -->
</footer>
