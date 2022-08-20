<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "main_setting".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $seo_image
 * @property string|null $site_name
 * @property string|null $seo_title_ru
 * @property string|null $seo_description_ru
 * @property string|null $seo_keyword_ru
 * @property string|null $seo_title_uz
 * @property string|null $seo_description_uz
 * @property string|null $seo_keyword_uz
 * @property string|null $vk_link
 * @property string|null $youtube_link
 * @property string|null $instagram_link
 * @property string|null $facebook_link
 * @property string|null $registered_users_count
 * @property string|null $educational_org_count
 * @property string|null $high_level_programs_count
 * @property string|null $interactive_programs_count
 * @property string|null $studying_spec_count
 */
class MainSetting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'seo_image', 'seo_description_ru', 'seo_description_uz'], 'string', 'max' => 255],
            [['site_name', 'seo_title_ru', 'seo_title_uz'], 'string', 'max' => 100],
            [['seo_keyword_ru', 'seo_keyword_uz', 'vk_link', 'youtube_link', 'instagram_link', 'facebook_link'], 'string', 'max' => 200],
            [['registered_users_count', 'educational_org_count', 'high_level_programs_count', 'interactive_programs_count', 'studying_spec_count'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'seo_image' => 'Seo Image',
            'site_name' => 'Site Name',
            'seo_title_ru' => 'Seo Title Ru',
            'seo_description_ru' => 'Seo Description Ru',
            'seo_keyword_ru' => 'Seo Keyword Ru',
            'seo_title_uz' => 'Seo Title Uz',
            'seo_description_uz' => 'Seo Description Uz',
            'seo_keyword_uz' => 'Seo Keyword Uz',
            'vk_link' => 'Vk Link',
            'youtube_link' => 'Youtube Link',
            'instagram_link' => 'Instagram Link',
            'facebook_link' => 'Facebook Link',
            'registered_users_count' => 'Registered Users Count',
            'educational_org_count' => 'Educational Org Count',
            'high_level_programs_count' => 'High Level Programs Count',
            'interactive_programs_count' => 'Interactive Programs Count',
            'studying_spec_count' => 'Studying Spec Count',
        ];
    }
}
