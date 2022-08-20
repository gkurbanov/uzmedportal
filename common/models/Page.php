<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $is_active
 * @property string $is_document
 * @property string $is_main
 * @property string $is_footer
 * @property int|null $order_top
 * @property int|null $order_aside
 * @property int|null $order_footer
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $content_ru
 * @property string|null $content_uz
 * @property int|null $level
 * @property int|null $parent_id
 * @property string|null $slug
 * @property string|null $file
 * @property string|null $seo_title_ru
 * @property string|null $seo_description_ru
 * @property string|null $seo_keyword_ru
 * @property string|null $seo_title_uz
 * @property string|null $seo_description_uz
 * @property string|null $seo_keyword_uz
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'is_document', 'is_main', 'is_footer', 'content_ru', 'content_uz'], 'string'],
            [['order_top', 'order_aside', 'order_footer', 'level', 'parent_id'], 'integer'],
            [['title_ru', 'title_uz', 'slug', 'file', 'seo_description_ru', 'seo_description_uz'], 'string', 'max' => 255],
            [['seo_title_ru', 'seo_title_uz'], 'string', 'max' => 100],
            [['seo_keyword_ru', 'seo_keyword_uz'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Активный',
            'is_document' => 'Файл',
            'is_main' => 'Главная',
            'is_footer' => 'Футер',
            'order_top' => 'Order Top',
            'order_aside' => 'Order Aside',
            'order_footer' => 'Order Footer',
            'title_ru' => 'Title Ru',
            'title_uz' => 'Title Uz',
            'content_ru' => 'Content Ru',
            'content_uz' => 'Content Uz',
            'level' => 'Level',
            'parent_id' => 'Parent ID',
            'slug' => 'Slug',
            'file' => 'File',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_keyword_ru' => 'Seo Keyword Ru',
            'seo_title_uz' => 'Seo Title Uz',
            'seo_description_uz' => 'Seo Description Uz',
            'seo_keyword_uz' => 'Seo Keyword Uz',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id'])->andOnCondition('parent_id!=:pid', [':pid' => null]);;
    }
}
