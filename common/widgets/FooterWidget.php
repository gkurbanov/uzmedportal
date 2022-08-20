<?php


namespace common\widgets;


use common\models\Page;

class FooterWidget extends DefaultWidget
{
    public function run()
    {
        $pages = $this->getFooterPages();

        $items = array();
        foreach ($pages as $page) {
            $child = $this->getFooterPagesChild($page["id"]);
            $child_items = array();
            foreach ($child as $value) {
                array_push($child_items, array(
                    "id" => $value["id"],
                    "title" => $value["title"],
                    "slug" => $page["slug"] . "/" . $value["slug"],
                ));
            }
            array_push($items, array(
                "id" => $page["id"],
                "title" => $page["title"],
                "slug" => $page["slug"],
                "child" => $child_items
            ));
        }
        return $this->render('footer', compact('items'));
    }
}