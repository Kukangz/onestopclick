<?php

namespace backend\controllers;

use Yii;
use common\models\Subcategory;
use backend\controllers\SubcategorySearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubcategoryController implements the CRUD actions for Subcategory model.
 */
class SubcategoryController extends \backend\components\BaseController
{

       /**
 * [init description]
 * @return [type] [description]
 */
       public function init(){
        $this->view->params['menu'] = 'categories';
        $this->view->params['submenu'] = 'subcategory';
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Subcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data['name'] = $data['slug'] = $data['parent'] = '';
        $searchModel = new \common\models\search\SubCategorySearch();
        $query = $searchModel->search(Yii::$app->request->get());
        $data = array_merge($data, Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index', $data);
    }

    /**
     * Creates a new Subcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subcategory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subcategory Created');
            return $this->redirect('/subcategory/');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subcategory Updated');
            return $this->redirect('/subcategory/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subcategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = SubCategory::findOne($id);
        $model->status = -9;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Subcategory Deleted');
        return $this->redirect('/subcategory');
    }

    /**
     * Finds the Subcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subcategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * [actionCajax description]
     * @return [type] [description]
     */
    public function actionCajax(){

        $data = Yii::$app->request->get('keyword');
        if ($data) {
            $test = \common\models\Category::find()->where(['like','name', $data])->asArray()->all();
        } else {
            $test = \common\models\Category::find()->where(['status' => 1])->limit(5)->asArray()->all();
        }
        return \yii\helpers\Json::encode($test);

    }
}
