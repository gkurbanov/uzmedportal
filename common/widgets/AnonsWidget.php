<?php


namespace common\widgets;


use common\models\Anons;
use DateTime;

class AnonsWidget extends DefaultWidget
{
    public function run()
    {
        $table_name = Anons::tableName();
        $anons = Anons::find()
            ->where(["is_active" => "1"])
            ->limit(10)
            ->orderBy(["id" => SORT_DESC])
            ->all();

        $items = array();
        foreach ($anons as $anon) {

            $date = new DateTime($anon["created_at"]);

            array_push($items, array(
                "id" => $anon["id"],
                "title" => $anon["title_{$this->language()}"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$anon["id"]}/{$anon["image_{$this->language()}"]}",
                "slug" => $anon["slug"],
                "date" => $date->format('Y.m.d')
            ));
        }


        return $this->render('anons', compact('items'));
    }
}