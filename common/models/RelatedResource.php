<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "related_resource".
 *
 * @property int $id
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $site_name
 * @property string|null $link_url
 * @property string|null $image
 * @property string $is_active
 */
class RelatedResource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'related_resource';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'string'],
            [['title_ru', 'title_uz', 'image'], 'string', 'max' => 255],
            [['site_name', 'link_url'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Заголовок Ru',
            'title_uz' => 'Заголовок Uz',
            'site_name' => 'Название ресурса',
            'link_url' => 'Ссылка на ресурс',
            'image' => 'Логотип ресурса',
            'is_active' => 'Статус',
        ];
    }
}
