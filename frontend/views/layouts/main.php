<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\widgets\FooterWidget;
use common\widgets\MainHeaderWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);

$logo = Yii::$app->params['main_settings']['image'];
$site_name = Yii::$app->params['main_settings']['site_name'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<!--<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=http://www.learningaboutelectronics.com/Articles/Headache-and-low-back-pain.pptx' width='80%' height='565px' frameborder='0'> </iframe>-->


<div class="wrapper">
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="header-top-info">
                    <img src="/frontend/web/assets/images/gerb_uzbekistana_Abali.ru.svg" alt="">
                    <a href="#!">МИНИСТЕРСТВО ЗДРАВООХРАНЕНИЯ РЕСПУБЛИКИ УЗБЕКИСТАН</a>
                </div><!-- ./header-top-info -->
                <div class="header-top-nav">
                    <ul>
                        <li>
                            <a href="<?= Url::to(["page/voprosi-otveti/voprosi-po-tehnicheskim-problemam"])?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.1 8.5C13.1 9.3 12.6 10.2 11.8 10.9C11.1 11.6 10.3 12.2 10.2 13.3C10.2 13.5 9.80001 13.7 9.60001 13.7C9.40001 13.7 9.00001 13.2 9.00001 13.1C9.20001 12.5 9.40001 11.7 9.70001 11.2C10.1 10.6 10.7 10.2 11.1 9.7C11.7 8.9 11.9 8.1 11.4 7.2C11.1 6.3 10.2 5.9 9.30001 6C8.40001 6.1 7.80001 6.6 7.50001 7.5C7.50001 7.6 7.40001 8 7.30001 8.2C7.10001 8.5 7.00001 8.7 6.80001 8.7C6.50001 8.7 6.20001 8.2 6.20001 8C6.20001 6.6 6.90001 5.6 8.10001 5.1C9.40001 4.5 10.6 4.6 11.8 5.5C12.6 6.2 13.1 7.1 13.1 8.5Z"
                                          fill="#6F767D"/>
                                    <path d="M9.70001 16.5C10.2523 16.5 10.7 16.0523 10.7 15.5C10.7 14.9477 10.2523 14.5 9.70001 14.5C9.14773 14.5 8.70001 14.9477 8.70001 15.5C8.70001 16.0523 9.14773 16.5 9.70001 16.5Z"
                                          fill="#6F767D"/>
                                    <path d="M9.99999 18.7C14.8049 18.7 18.7 14.8049 18.7 10C18.7 5.19513 14.8049 1.3 9.99999 1.3C5.19511 1.3 1.29999 5.19513 1.29999 10C1.29999 14.8049 5.19511 18.7 9.99999 18.7Z"
                                          stroke="#6F767D" stroke-width="1.5" stroke-miterlimit="10"/>
                                </svg>
                                <span>
                                        Помощь
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="#!">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.60002 14C11.0242 14 13.8 11.2242 13.8 7.80001C13.8 4.37584 11.0242 1.60001 7.60002 1.60001C4.17586 1.60001 1.40002 4.37584 1.40002 7.80001C1.40002 11.2242 4.17586 14 7.60002 14Z"
                                          stroke="#6F767D" stroke-width="1.5" stroke-miterlimit="10"/>
                                    <path d="M12.1 12.1L17.7 17.7" stroke="#6F767D" stroke-width="1.5"
                                          stroke-miterlimit="10"/>
                                </svg>
                                <span>
                                        Поиск
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a href="#!">
                                <svg width="23" height="18" viewBox="0 0 23 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.1 9C20.5 13.4 16.3 16.5 11.4 16.5C6.50005 16.5 2.40005 13.4 0.800049 9C2.40005 4.6 6.60005 1.5 11.5 1.5C16.4 1.5 20.5 4.7 22.1 9Z"
                                          stroke="#6F767D" stroke-width="1.5" stroke-miterlimit="10"/>
                                    <path d="M11.5001 12.8C13.5988 12.8 15.3001 11.0987 15.3001 9C15.3001 6.90131 13.5988 5.2 11.5001 5.2C9.40139 5.2 7.70007 6.90131 7.70007 9C7.70007 11.0987 9.40139 12.8 11.5001 12.8Z"
                                          stroke="#6F767D" stroke-width="1.5" stroke-miterlimit="10"/>
                                </svg>
                                <span>
                                        Версия для слабовидящих
                                    </span>
                            </a>
                        </li>
                    </ul>
                </div><!-- ./header-top-nav -->
            </div><!-- ./header-top -->
            <div class="header-content">
                <div class="header-content-logo">
                    <a href="<?= Url::home(); ?>">
                        <img src="/backend/web/media/main_setting/main_setting_1/<?= $logo?>" alt="<?= $site_name?>">
                    </a>
                </div><!-- ./header-content-logo -->

                <?= MainHeaderWidget::widget() ?>
                <div class="dropdown header-content-account">
                    <a href="#!" class="dropdown-btn gradient-btn">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.7 21.3L19.7 21.1L20.7 21.2L19.7 21.1C19.7 21 19.8 19.6 18.6 18.6C17.8 18 16.7 17.6 15.8 17.3C14.7 16.9 13.9 16.6 13.4 16C12.3 14.5 14.1 10.9 14.9 9.99999C15.4 9.29999 16 4.79999 14.5 3.39999C14.5 3.39999 13.5 2.59999 12.4 2.39999L11 2.19999L9.8 2.39999C8.7 2.59999 7.7 3.39999 7.7 3.39999C6.3 4.79999 6.8 9.29999 7.4 9.99999C8.2 10.9 10.1 14.5 8.9 16C8.4 16.6 7.6 16.9 6.5 17.3C5.6 17.6 4.5 18 3.7 18.6C2.4 19.5 2.6 21 2.6 21L0.6 21.2C0.6 21.1 0.3 18.5 2.6 16.9C3.6 16.1 4.9 15.7 5.9 15.3C6.3 15.3 7 15 7.3 14.8C7.4 14.2 6.6 12 5.9 11.3C4.6 9.89999 4.1 4.09999 6.4 1.99999C6.6 1.89999 7.9 0.699988 9.5 0.499988L11.3 0.299988L12.8 0.499988C14.5 0.799988 15.8 1.89999 15.9 1.99999C18.1 4.19999 17.6 9.99999 16.4 11.4C15.7 12.2 15 14.3 15 14.9C15.2 15.1 15.9 15.3 16.5 15.5C17.5 15.9 18.7 16.3 19.8 17.1C22 18.6 21.7 21.2 21.7 21.3Z"
                                  fill="white"/>
                        </svg>
                        <span>
                                Личный кабинет
                            </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="gradient-btn" href="#!">
                                    <span>
                                        Специалистам с высшим образованием
                                    </span>
                            </a>
                        </li>
                        <li>
                            <a class="gradient-btn" href="#!">
                                    <span>
                                        Специалистам со средним образованием
                                    </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- ./header-content -->
        </div><!-- ./container -->
    </header>

    <main class="main">
        <?= $content ?>
    </main>

    <?= FooterWidget::widget() ?>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
