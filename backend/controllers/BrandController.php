<?php

namespace backend\controllers;

use Yii;
use common\models\Brand;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends \backend\components\BaseController
{

    /**
 * [init description]
 * @return [type] [description]
 */
    public function init(){
        $this->view->params['menu'] = 'categories';
        $this->view->params['submenu'] = 'brand';
    }


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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data['name'] = $data['slug'] = $data['category'] = '';
        $searchModel = new \common\models\search\BrandSearch();
        $query = $searchModel->search(Yii::$app->request->get());
        $data = array_merge($data, Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    
    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/brand/');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/brand/');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = Brand::findOne($id);
        $model->status = -9;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save(false);
        
        return $this->redirect('/brand/');
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
