<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $button_text_ru
 * @property string|null $button_text__uz
 * @property string|null $button_link_ru
 * @property string|null $button_link_uz
 * @property string|null $image
 * @property string $is_active
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['is_active'], 'string'],
            [['title_ru', 'title_uz', 'button_link_ru', 'button_link_uz', 'image'], 'string', 'max' => 255],
            [['button_text_ru', 'button_text__uz'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата последнего обновления',
            'title_ru' => 'Заголовок RU',
            'title_uz' => 'Заголовок UZ',
            'button_text_ru' => 'Текст кнопки RU',
            'button_text__uz' => 'Текст кнопки UZ',
            'button_link_ru' => 'Ссылка на ресурс RU',
            'button_link_uz' => 'Ссылка на ресурс UZ',
            'image' => 'Изображение',
            'is_active' => 'Статус',
        ];
    }
}
