<?php


namespace common\widgets;


use common\models\Anons;
use common\models\Events;
use DateTime;

class EventsWidget extends DefaultWidget
{
    public function run()
    {
        $table_name = Events::tableName();
        $events = Events::find()
            ->where(["is_active" => "1"])
            ->limit(10)
            ->orderBy(["id" => SORT_DESC])
            ->all();

        $items = array();
        foreach ($events as $event) {
            $date = new DateTime($event["created_at"]);
            array_push($items, array(
                "id" => $event["id"],
                "title" => $event["title_{$this->language()}"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$event["id"]}/{$event["image_{$this->language()}"]}",
                "slug" => $event["slug"],
                "date" => $date->format('Y.m.d')
            ));
        }
        return $this->render('events', compact('items'));
    }
}