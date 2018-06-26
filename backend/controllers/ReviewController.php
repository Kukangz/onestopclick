<?php

namespace backend\controllers;

use Yii;
use common\models\ProductReview;
use yii\data\ActiveDataProvider;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for ProductReview model.
 */
class ReviewController extends BaseController
{

 public function init(){
    $this->view->params['menu'] = 'product';
    $this->view->params['submenu'] = 'review';
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
     * Lists all ProductReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = ProductReview::find()
            ->select(['product_review.*','user.name','product_name' => 'product.name'])
            ->leftJoin('user','product_review.user = user.id')
            ->leftJoin('product','product_review.product = product.id')->orderBy([new \yii\db\Expression('FIELD(product_review.status,0,1,-9)')]);
        $searchModel = new \common\models\search\ReviewSearch();
        $query = $searchModel->search(Yii::$app->request->get());
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }


    /**
     * Updates an existing ProductReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAccept($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->save();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->redirect(['/review']);
    }

    /**
     * Deletes an existing ProductReview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -9;
        $model->save();

        return $this->redirect(['/review']);
    }

    /**
     * Finds the ProductReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductReview::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
