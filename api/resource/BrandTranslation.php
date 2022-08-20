<?php


namespace frontend\resource;


class BrandTranslation extends \common\models\BrandTranslation
{

    public function fields()
    {
        return ['id', 'brand_title', 'brand_description', 'seo_title', 'seo_description', 'seo_keywords', 'lang', 'is_active'];
    }
}