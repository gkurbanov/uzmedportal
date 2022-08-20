<?php


namespace frontend\controllers;


use common\models\Page;

class PageController extends SiteController
{
    public function actionIndex($slug = null, $slug2 = null, $slug3 = null)
    {

        $page = Page::findOne(["slug" => $slug]);

        if ($page) {
            $child_pages = Page::find()
                ->select(["id", "is_active", "is_document", "order_aside", "title_{$this->language()} as title", "slug", "file"])
                ->where(["parent_id" => $page->id, "level" => 2, "is_active" => "1"])
                ->asArray()
                ->all();
            $items = array();
            foreach ($child_pages as $child_page) {
                array_push($items, array(
                    "id" => $child_page["id"],
                    "is_document" => $child_page["is_document"],
                    "title" => $child_page["title"],
                    "slug" => $child_page["slug"],
                    "file" => $child_page["file"],
                    "child" => Page::find()
                        ->select(["id", "title_{$this->language()} as title", "slug", "is_document", "order_aside", "parent_id"])
                        ->where(['parent_id' => $child_page["id"], 'level' => 3, "is_active" => "1"])
                        ->asArray()
                        ->all()
                ));
            }

//            $this->debug($items);

            //Getting content
            if ($slug && $slug2 && $slug3){
                $page_content = Page::findOne(["slug" => $slug3]);
            }else if ($slug && $slug2){
                $page_content = Page::findOne(["slug" => $slug2]);
            }

            $content = array($page);
            $content = array(
                "id" => $page->id,
                "slug" => $page->slug,
                "title" => $page["title_{$this->language()}"],
                "content" => $page["content_{$this->language()}"]
            );

            $current_page = array($page_content);
            $current_page = array(
                "id" => $page_content["id"],
                "slug" => $page_content["slug"],
                "title" => $page_content["title_{$this->language()}"],
                "content" => $page_content["content_{$this->language()}"]
            );

            $this->setSeo(
                $page["title_{$this->language()}"],
                $page["seo_keyword_{$this->language()}"],
                $page["seo_description_{$this->language()}"],
                '',
                '',
                ''
            );

            return $this->render('index', compact('items', 'content', 'current_page'));
        }

    }
}