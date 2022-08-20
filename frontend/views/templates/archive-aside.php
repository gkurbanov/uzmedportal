<?php

?>

<ul class="news-menu">
    <?php
    $i = 0;
    foreach ($archive as $key => $value) { ?>
        <li class="<?php if ($i == 0) {
            echo "active";
        } ?>">
            <a href="#!" class="year-link">
                <?= $key ?>
            </a>
            <?php if ($value) { ?>
                <ul class="month-block">
                    <?php foreach ($value as $val) { ?>
                        <li>
                            <a href="#!">
                                <?= $val["month_name"]?>
                            </a>
                            [<?= $val["month_qty"]?>]
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
        <?php
        $i++;
    } ?>

</ul>
