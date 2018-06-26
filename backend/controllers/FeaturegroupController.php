<?php

namespace backend\controllers;

use Yii;
use backend\models\activerecord\FeatureGroup;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeatureGroupController implements the CRUD actions for FeatureGroup model.
 */
class FeaturegroupController extends BaseController
{

   /**
 * [init description]
 * @return [type] [description]
 */
   public function init(){
    $this->view->params['menu'] = 'settings';
    $this->view->params['submenu'] = 'featuregroup';
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
     * Lists all FeatureGroup models.
     * @return mixed
     */
    public function actionIndex()
    {

        $query = FeatureGroup::find()->where(['status' => 1]);

        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('index', [
            'pages' => $pages,
            'dataProvider' => $models,
        ]);
    }

    /**
     * Creates a new FeatureGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeatureGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/featuregroup/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FeatureGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/featuregroup/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FeatureGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = FeatureGroup::findOne($id);
        $model->status = -9;
        $model->save(false);
        
        return $this->redirect('/featuregroup/');
    }

    /**
     * Finds the FeatureGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeatureGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeatureGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
