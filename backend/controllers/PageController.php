<?php

namespace backend\controllers;

use common\models\BaseModel;
use Yii;
use common\models\Page;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends SiteController
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

    public function getPages()
    {
        $pages_array = array();

        $first_level_pages = Page::find()
            ->where([
                "level" => 1,
                "parent_id" => null
            ])
            ->asArray()
            ->all();

        foreach ($first_level_pages as $first_level_page){

            $secondLevel = array();
            $childs = Page::find()->where([
                'parent_id' => $first_level_page["id"],
                'level' => 2,
            ])->all();

            if (count($childs) > 0){
                foreach ($childs as $child){
                    array_push($secondLevel, array(
                        "id" => $child->id,
                        "title" => $child->title_ru,
                        "third" => Page::find()
                            ->select(['id', 'title_ru'])
                            ->where(['parent_id' => $child->id, 'level' => 3])
                            ->asArray()
                            ->all()
                    ));
                }
            }


            $all_levels = array(
                "first" => array(
                    "id" => $first_level_page["id"],
                    "title" => $first_level_page["title_ru"]
                ),
                "second" => $secondLevel,
            );
            array_push($pages_array, $all_levels);
        }

        return $pages_array;

    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Page::find()->orderBy(['id' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $records = $query->offset($pages->offset)->limit($pages->limit)->all();
        $count = $query->count();
        return $this->render('index', compact('records', 'pages', 'count'));
    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();
        $pages = $this->getPages();

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = BaseModel::convertToLatinLowerCase($model->title_ru);

            if (!$model->parent_id) {
                $model->level = 1;
            }else{
                $get_page = Page::findOne($model->parent_id);
                $model->level = $get_page->level + 1;
            }
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pages = $this->getPages();

        if ($model->load(Yii::$app->request->post())) {
            $model->slug = BaseModel::convertToLatinLowerCase($model->title_ru);


            if (!$model->parent_id) {
                $model->level = 1;
            }else{
                $get_page = Page::findOne($model->parent_id);
                $model->level = $get_page->level + 1;
            }
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }


        return $this->render('update', [
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    /**
     * Deletes an existing Page model.
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
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
