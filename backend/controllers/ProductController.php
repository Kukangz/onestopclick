<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\Category;
use common\models\SubCategory;
use common\models\Brand;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\helpers\Url; 
use common\components\Osc;


/**
 * 
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends \backend\components\BaseController
{

       /**
 * [init description]
 * @return [type] [description]
 */
       public function init(){
        $this->view->params['menu'] = 'product';
        $this->view->params['submenu'] = 'product';
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \common\models\search\ProductSearch();
        $query = $searchModel->search(Yii::$app->request->get(),Yii::$app->user->identity->roles != 1);        
        $data['pages'] = $query->getPagination();
        $data['dataProvider'] = $query->getModels();

        return $this->render('index',$data);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect('/product/');

           $model->picture = UploadedFile::getInstance($model, 'picture');
           if ($filename = $model->upload(Url::to('@uploadpath').'\\'.$model->id.'\\', $model->slug)) {
                // file is uploaded successfully
            $model->picture = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].$filename['extension']);
            $model->picture_thumbnail = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-thumb'.$filename['extension']);
            $model->picture_portrait = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-portrait'.$filename['extension']);
            $model->picture_headline = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-headline'.$filename['extension']);

            $model->product_download_link = UploadedFile::getInstance($model, 'product_download_link');
            if($product_filename = $model->product_upload(Url::to('@productpath').'\\'.$model->id.'\\', $model->slug)){
                $model->product_download_link = Url::to('/product/'.$model->id.'/'.$product_filename['filename'].$product_filename['extension']);
            }
            $model->save(false);
        }

        Yii::$app->session->setFlash('success', 'Product Created');
        return $this->redirect('/product/');
    }
    $options = [];
    $parents = Category::find()->where(['status' => 1])->all();
    foreach($parents as $id => $p) {
        $children = SubCategory::find()->where(["parent" => $p->id,'status' => 1])->all();
        $child_options = [];
        foreach($children as $child) {
            $child_options[$child->id] = $child->name;
        }
        $options[$p->name] = $child_options;
    }

    
    $brands = Brand::find()->all();
    return $this->render('create', [
        'model' => $model,
        'category_items' => $options,
        'brand_items' => $brands
    ]);
}

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if(Yii::$app->request->post() && !$post['Product']['picture']){
            unset($post['Product']['picture']);
            $post['Product']['picture'] = $model->picture;
        }
        
        if ($model->load($post) && $model->save()) {
            // return $this->redirect('/product/');

            $picture = UploadedFile::getInstance($model, 'picture');

            if ($picture != NULL){
                $model->picture = $picture;
                $filename = $model->upload(Url::to('@uploadpath').'\\'.$model->id.'\\', $model->slug);
                    // file is uploaded successfully
                $model->picture = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].$filename['extension']);
                $model->picture_thumbnail = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-thumb'.$filename['extension']);
                $model->picture_portrait = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-portrait'.$filename['extension']);
                $model->picture_headline = Url::to('/uploads/'.$model->id.'/'.$filename['filename'].'-headline'.$filename['extension']);
            }

            $media = UploadedFile::getInstance($model, 'product_download_link');
            if($media != NULL){
                $model->product_download_link = $media;
                if($product_filename = $model->product_upload(Url::to('@productpath').'\\'.$model->id.'\\', $model->slug)){
                    $model->product_download_link = Url::to('/product/'.$model->id.'/'.$product_filename['filename'].$product_filename['extension']);
                }
            }
            
            $model->save(false);

            Yii::$app->session->setFlash('success', 'Product Updated');
            return $this->redirect('/product/');
        }

        $options = [];
        $parents = Category::find()->where(['status' => 1])->all();
        foreach($parents as $id => $p) {
            $children = SubCategory::find()->where(["parent" => $p->id,'status' => 1])->all();
            $child_options = [];
            foreach($children as $child) {
                $child_options[$child->id] = $child->name;
            }
            $options[$p->name] = $child_options;
        }

        $brands = Brand::find()->all();
        return $this->render('update', [
            'model' => $model,
            'category_items' => $options,
            'brand_items' => $brands
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {


        $model = Product::findOne($id);
        $model->status = -9;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save(false);
        

        
        return $this->redirect('/product/');
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * [actionSetheadline description]
     * @param  [type] $id   [description]
     * @param  [type] $flag [description]
     * @return [type]       [description]
     */
    public function actionSetheadline($id, $flag){
        $model = $this->findModel($id);
        $model->flag_headline = $flag;
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        Yii::$app->session->setFlash('success', 'Flag set');
        return $this->redirect(Url::to('/product/'));
    }
}
