<?php


namespace common\widgets;


use common\models\Page;
use Yii;
use yii\base\Widget;

class DefaultWidget extends Widget
{
    public function init()
    {
        $lang = Yii::$app->language; //текущий язык
    }

    public function getPages()
    {
        return $pages = Page::find()
            ->select(["id", "title_{$this->language()} as title", "slug", "level", "parent_id",])
            ->where(["is_active" => "1"]);
    }

    public function getTopPages()
    {
        return $this->getPages()->andWhere(["level" => 1, "is_main" => "1"])->asArray()->all();
    }

    public function getFooterPages()
    {
        return $this->getPages()
            ->andWhere(["level" => 1, "is_footer" => "1"])
            ->asArray()
            ->all();
    }

    public function getFooterPagesChild($id)
    {
        return $this->getPages()->where(["level" => 2, "is_footer" => "1", "parent_id" => $id])->asArray()->all();
    }


    public function debug($arr)
    {
        echo '<pre>' . var_export($arr, true) . '</pre>';
    }

    public function language()
    {
        return Yii::$app->language; //текущий язык
    }


    public function getDateName($date)
    {

        // месяцы на русском языке
        $months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Майя', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

        // дни недели на русском
        $days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];


        return $date;
    }
}