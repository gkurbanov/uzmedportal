<?php


namespace common\widgets;


use common\models\Anons;
use common\models\Events;
use common\models\Projects;
use DateTime;

class ProjectsWidget extends DefaultWidget
{
    public function run()
    {
        $table_name = Projects::tableName();
        $projects = Projects::find()
            ->where(["is_active" => "1"])
            ->limit(10)
            ->orderBy(["id" => SORT_DESC])
            ->all();

        $items = array();
        foreach ($projects as $project) {
            $date = new DateTime($project["created_at"]);
            array_push($items, array(
                "id" => $project["id"],
                "title" => $project["title_{$this->language()}"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$project["id"]}/{$project["image_{$this->language()}"]}",
                "slug" => $project["slug"],
                "date" => $date->format('Y.m.d')
            ));
        }
        return $this->render('projects', compact('items'));
    }
}