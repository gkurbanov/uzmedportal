<?php


namespace common\widgets;


use common\models\RelatedResource;

class RelatedResourcesWidget extends DefaultWidget
{
    public function run()
    {

        $table_name = RelatedResource::tableName();
        $resources = RelatedResource::find()
            ->select(["id", "title_{$this->language()} as title", "site_name", "link_url", "image"])
            ->where(["is_active" => "1"])
            ->asArray()
            ->orderBy(["id" => SORT_DESC])
            ->all();

        $items = array();
        foreach ($resources as $record) {
            array_push($items, array(
                "id" => $record["id"],
                "title" => $record["title"],
                "site_name" => $record["site_name"],
                "link_url" => $record["link_url"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$record["id"]}/{$record["image"]}",
            ));
        }
        return $this->render('related-resources', compact('items'));
    }
}