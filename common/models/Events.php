<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $year
 * @property int|null $month
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $content_ru
 * @property string|null $content_uz
 * @property string|null $image_ru
 * @property string|null $image_uz
 * @property string|null $slug
 * @property string|null $seo_title_ru
 * @property string|null $seo_description_ru
 * @property string|null $seo_keyword_ru
 * @property string|null $seo_title_uz
 * @property string|null $seo_description_uz
 * @property string|null $seo_keyword_uz
 * @property int|null $user_added
 * @property string $is_active
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['year', 'month', 'user_added'], 'integer'],
            [['content_ru', 'content_uz', 'is_active'], 'string'],
            [['title_ru', 'title_uz', 'image_ru', 'image_uz', 'slug'], 'string', 'max' => 255],
            [['seo_title_ru', 'seo_title_uz'], 'string', 'max' => 100],
            [['seo_description_ru', 'seo_keyword_ru', 'seo_description_uz', 'seo_keyword_uz'], 'string', 'max' => 200],
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
            'year' => 'Year',
            'month' => 'Month',
            'title_ru' => 'Заголовок  RU',
            'title_uz' => 'Заголовок  UZ',
            'content_ru' => 'Контент  RU',
            'content_uz' => 'Контент  UZ',
            'image_ru' => 'Изображение RU',
            'image_uz' => 'Изображение UZ',
            'slug' => 'URL',
            'seo_title_ru' => 'Seo заголовок RU',
            'seo_description_ru' => 'Seo описание RU',
            'seo_keyword_ru' => 'Seo кл.слова RU',
            'seo_title_uz' => 'Seo заголовок UZ',
            'seo_description_uz' => 'Seo описание UZ',
            'seo_keyword_uz' => 'Seo кл.слова UZ',
            'user_added' => 'Добавлено',
            'is_active' => 'Активный',
        ];
    }
}
