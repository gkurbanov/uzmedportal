<?php

namespace backend\controllers;

use common\models\BaseModel;
use Yii;
use common\models\Anons;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AnonsController implements the CRUD actions for Anons model.
 */
class AnonsController extends SiteController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Anons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Anons::find()->orderBy(['id' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $records = $query->offset($pages->offset)->limit($pages->limit)->all();
        $count = $query->count();
        return $this->render('index', compact('records', 'pages', 'count'));
    }

    /**
     * Displays a single Anons model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Anons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Anons();

        if ($model->load(Yii::$app->request->post())) {
            $model->month = date("m");
            $model->year = date("Y");
            $model->created_at = date("Y-m-d h:i:s");
            $model->slug = BaseModel::convertToLatinLowerCase($model->title_ru);
            $model->user_added = Yii::$app->user->getId();
            if ($model->save()) {

                $image_ru = UploadedFile::getInstance($model, 'image_ru');
                if ($image_ru){
                    BaseModel::uploadPostImage($model, $image_ru, Anons::tableName(), "image_ru", $model->title_ru);
                }

                $image_uz = UploadedFile::getInstance($model, 'image_uz');
                if ($image_uz){
                    BaseModel::uploadPostImage($model, $image_uz, Anons::tableName(), "image_uz", $model->title_ru);
                }

                return $this->redirect(['update', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Anons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->month = date("m");
            $model->year = date("Y");
            $model->updated_at = date("Y-m-d h:i:s");
            $model->slug = BaseModel::convertToLatinLowerCase($model->title_ru);
            $model->user_added = Yii::$app->user->getId();
            $model->slug = BaseModel::convertToLatinLowerCase($model->title_ru);
            if ($model->save()) {
                $image_ru = UploadedFile::getInstance($model, 'image_ru');
                if ($image_ru){
                    BaseModel::uploadPostImage($model, $image_ru, Anons::tableName(), "image_ru", $model->title_ru);
                }

                $image_uz = UploadedFile::getInstance($model, 'image_uz');
                if ($image_uz){
                    BaseModel::uploadPostImage($model, $image_uz, Anons::tableName(), "image_uz", $model->title_ru);
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Anons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Anons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
