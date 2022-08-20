<?php


namespace frontend\resource;



class Brand extends \common\models\Brand
{
    public function fields()
    {
        return ['id', 'brand_logo', 'seo_image', 'brand_alias',  'translations'];
    }

   public function extraFields()
   {
       return ['brand_alias'];
   }

    /**
     * Gets query for [[BrandTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(BrandTranslation::className(), ['brand_id' => 'id']);
    }
}