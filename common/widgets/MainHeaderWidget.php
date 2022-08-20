<?php


namespace common\widgets;


class MainHeaderWidget extends DefaultWidget
{
    public function run()
    {
        $pages = $this->getTopPages();
        return $this->render('main-header', compact('pages'));
    }
}