<?php


namespace common\widgets;


use common\models\Slider;
use Yii;

class MainSliderWidget extends DefaultWidget
{
    public function run()
    {
        $items = array();

        $table_name = Slider::tableName();
        $sliders = Slider::find()
            ->where(["is_active" => "1"])
            ->asArray()
            ->all();
        foreach ($sliders as $slider) {
            array_push($items, array(
                "id" => $slider["id"],
                "title" => $slider["title_{$this->language()}"],
                "button_text" => $slider["button_text_{$this->language()}"],
                "button_link" => $slider["button_link_{$this->language()}"],
                "image" =>"/backend/web/media/{$table_name}/{$table_name}_{$slider["id"]}/{$slider["image"]}",
            ));
        }

        return $this->render('main-slider', compact('items'));
    }
}