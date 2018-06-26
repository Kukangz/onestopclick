<?php

namespace backend\controllers;

use Yii;
use common\models\topup;
use yii\data\ActiveDataProvider;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\User;

/**
 * TopupController implements the CRUD actions for topup model.
 */
class TopupController extends BaseController
{

 public function init(){
    $this->view->params['menu'] = 'transaction';
    $this->view->params['submenu'] = 'topup';
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
     * Lists all topup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Topup::find()->select(['topup.*','name' => 'name'])->join('left join','user','topup.user=user.id')->where(['>=','topup.status', -1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render('index', [
         'pages' => $pages,
         'dataProvider' => $models,
     ]);
    }

    /**
     * Displays a single topup model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAccept($id)
    {
       $model = $this->findModel($id);
       $model->status = 2;
       if ($model->save(false)) {
           $user = User::find()->where(['id' => $model->user])->one();
           $user->balance = $user->balance + $model->amount;
           $user->save(false);
           
           $this->redirect('/topup');
       }
   }


       /**
     * Displays a single topup model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
       public function actionReject($id)
       {
           $model = $this->findModel($id);
           $model->status = -1;
           if ($model->save(false)) {
               $this->redirect('/topup');
           }
       }

    /**
     * Creates a new topup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new topup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->transaction_code]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing topup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->transaction_code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing topup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the topup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return topup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = topup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
