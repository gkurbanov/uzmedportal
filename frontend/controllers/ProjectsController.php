<?php


namespace frontend\controllers;


use common\models\Anons;
use common\models\Events;
use common\models\Projects;
use DateTime;
use yii\data\Pagination;

class ProjectsController extends SiteController
{

    public function actionAll($month_number = null)
    {

        $table_name = Projects::tableName();
        $query = Projects::find()
            ->where(["is_active" => "1"])
            ->orderBy(['id' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $records = $query->offset($pages->offset)->limit($pages->limit)->all();

        $items = array();
        foreach ($records as $record) {
            $date = new DateTime($record["created_at"]);
            array_push($items, array(
                "id" => $record["id"],
                "title" => $record["title_{$this->language()}"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$record["id"]}/{$record["image_{$this->language()}"]}",
                "slug" => $record["slug"],
                "date" => $date->format('Y.m.d')
            ));
        }

        $archive = $this->getArchieve(Projects::tableName());
        return $this->render('all', compact('archive', 'pages', 'items'));
    }

    public function actionIndex($slug = null)
    {
        $event = Projects::find()->where(["slug" => $slug, "is_active" => "1"])->asArray()->one();
        if ($event) {
            $content = array(
                "title" => $event["title_{$this->language()}"],
                "content" => $event["content_{$this->language()}"],
            );
            $archive = $this->getArchieve(Projects::tableName());

            return $this->render('index', compact('content', 'archive'));
        }
    }


}