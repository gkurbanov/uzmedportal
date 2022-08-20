<?php


namespace backend\controllers;


use common\models\BaseModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AjaxController extends SiteController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
//                'only' => ['create', 'update'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    //Removing image
    public function actionRemoveImage($table_name, $column, $record_id, $value)
    {
        return BaseModel::removeImage($table_name, $column, $record_id, $value);
    }
}