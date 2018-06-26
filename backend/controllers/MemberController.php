<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

    /**
    * MemberController implements the CRUD actions for User model.
    */
    class MemberController extends BaseController
    {

        public function init(){
            $this->view->params['menu'] = 'member';
            $this->view->params['submenu'] = 'member';
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
    * Lists all User models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new \common\models\search\UserSearch();
        $query = $searchModel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
    * Creates a new User model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/member/');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

/**
* Updates an existing User model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect('/member/');
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

/**
* Deletes an existing User model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return mixed
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionDelete($id)
{

 $model = $this->findModel($id);
 $model->status = -9;
 $model->save(false);

 return $this->redirect('/member/');
}

/**
* Finds the User model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return User the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id)
{
    if (($model = User::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
}
}
