<?php

namespace backend\controllers;

use Yii;
use backend\models\activerecord\BackendUser;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for BackendUser model.
 */
class UserController extends BaseController
{

    /**
     * [init description]
     * @return [type] [description]
     */
    public function init(){
        $this->view->params['menu'] = 'settings';
        $this->view->params['submenu'] = 'user';
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
     * Lists all BackendUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = BackendUser::find()->where(['status' => 1]);
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
     * Creates a new BackendUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BackendUser();

        $post = Yii::$app->request->post();
        if($post){
            $post['BackendUser']['password'] = md5($post['BackendUser']['password']);
        }

        if ($model->load($post) && $model->save()) {
            return $this->redirect(['/user/']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BackendUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if($post && $post['BackendUser']['password'] != $model->password){
            // $post[0]['password'] = md5(Yii::$app->request->post('password'));
            $post['BackendUser']['password'] = md5($post['BackendUser']['password']);
        }

        if ($model->load($post) && $model->save()) {
            return $this->redirect(['/user/']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BackendUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = BackendUser::findOne($id);
        $model->status = -9;
        $model->save(false);


        return $this->redirect(['index']);
    }

    /**
     * Finds the BackendUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackendUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BackendUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
