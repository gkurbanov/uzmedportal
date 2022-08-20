<?php


namespace frontend\controllers;


use common\models\Anons;
use DateTime;
use yii\data\Pagination;

class AnonsController extends SiteController
{

    public function actionAll($month_number = null)
    {

        $table_name = Anons::tableName();
        $query = Anons::find()
            ->where(["is_active" => "1"])
            ->orderBy(['id' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $records = $query->offset($pages->offset)->limit($pages->limit)->all();

        $items = array();
        foreach ($records as $anon) {
            $date = new DateTime($anon["created_at"]);
            array_push($items, array(
                "id" => $anon["id"],
                "title" => $anon["title_{$this->language()}"],
                "image" => "/backend/web/media/{$table_name}/{$table_name}_{$anon["id"]}/{$anon["image_{$this->language()}"]}",
                "slug" => $anon["slug"],
                "date" => $date->format('Y.m.d')
            ));
        }

        $archive = $this->getArchieve(Anons::tableName());
        return $this->render('all', compact('archive', 'pages', 'items'));
    }

    public function actionIndex($slug = null)
    {
        $anons = Anons::find()->where(["slug" => $slug, "is_active" => "1"])->asArray()->one();
        if ($anons) {
            $content = array(
                "title" => $anons["title_{$this->language()}"],
                "content" => $anons["content_{$this->language()}"],
            );
            $archive = $this->getArchieve(Anons::tableName());

            return $this->render('index', compact('content', 'archive'));
        }
    }



}