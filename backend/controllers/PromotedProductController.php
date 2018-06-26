<?php

namespace backend\controllers;

use Yii;
use common\models\PromotedProduct;
use yii\data\ActiveDataProvider;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\PromotedProductItem;

/**
 * PromotedProductController implements the CRUD actions for PromotedProduct model.
 */
class PromotedProductController extends BaseController
{
 public function init(){
    $this->view->params['menu'] = 'product';
    $this->view->params['submenu'] = 'promoted-product';
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
                    'productadd' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all PromotedProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = PromotedProduct::find()->where(['promoted_product.status' => 1]);
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
     * Creates a new PromotedProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PromotedProduct();


        // if(Yii::$app->request->post()){
        //     var_dump(Yii::$app->request->post());
        //     die();
        // }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/promoted-product');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PromotedProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/promoted-product');
        }

        $product_item = PromotedProductItem::find()->where(['promoted_product' => $id])->all();
        
        return $this->render('update', [
            'model' => $model,
            'product_item' => $product_item
        ]);
    }

    public function actionPadd($id = FALSE)
    {
        if(!$id){
            Yii::$app->session->setFlash('error', 'You cannot access this script directly');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $product_promo = $this->findModel($id);
        if(!$product_promo){
            Yii::$app->session->setFlash('error', 'Promo not found');
            return $this->redirect(Yii::$app->request->referrer);    
        }

        $product = Yii::$app->request->post('product');
        
        $prod = \common\models\Product::findOne($product);
        if(!$prod){
            Yii::$app->session->setFlash('error', 'Promo not found');
            return $this->redirect(Yii::$app->request->referrer);    
        }
        

        $target = new PromotedProductItem();
        $target->promoted_product = $id;
        $target->product = $product;
        $target->price = Yii::$app->request->post('price');
        $target->qty = Yii::$app->request->post('qty');

        $target->save(false);

        // echo 'what its not exist';   
        // die();
        // new \common\models\PromotedProductItem();

        Yii::$app->session->setFlash('success', 'Product Added');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing PromotedProduct model.
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

        return $this->redirect('/promoted-product');
    }

    /**
     * Finds the PromotedProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PromotedProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromotedProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
