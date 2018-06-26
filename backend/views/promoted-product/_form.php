<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Product;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use backend\components\CMS;


/* @var $this yii\web\View */
/* @var $model common\models\activerecord\PromotedProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 promoted-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
        'name' => 'start_date',
        'type' => DateTimePicker::TYPE_INPUT,
        'value' => date('Y-m-d H:i'),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]); ?>

    <?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
        'name' => 'end_date',
        'type' => DateTimePicker::TYPE_INPUT,
        'value' => date('Y-m-d H:i'),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd hh:ii'
        ]
    ]); ?>

    <?= $form->field($model, 'synopsis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropdownList(CMS::Status()) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/promoted-product/'), ['class' => 'btn btn-primary']);?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="col-md-8 promoted-product-form" id="target-body">

    <?php ActiveForm::begin(['action' => Url::to('/promoted-product/product-add/'.Yii::$app->request->get('id')), 'id' => 'promoted-product']);?>
    <div class="row" id="target">
        <div class="col-md-4">
         <?=Select2::widget([
            'name' => 'product',
            'data' => ArrayHelper::map(Product::find()->where(['status' => 1])->orderBy('created_at DESC')->all(),'id','name'),
            'options' => ['placeholder' => 'Select a product ...'],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ]);?>
    </div>
    <div class="col-md-2">
        <input type="number" name="price" class="form-control" placeholder="Product Price"></input>
    </div>
    <div class="col-md-2">
        <input type="number" name="qty" class="form-control" placeholder="Product Qty"></input>
    </div>
    <div class="col-md-2 pull-right">
        <input type="submit" class="btn btn-info pull-right" style="margin-top:0;" value="Add Product"></input>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<div class="col-md-12">
    <div class="row">
        <table class="table table-reponsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($product_item as $item):?>
                    <tr>
                        <td><?php echo $item->id;?></td>
                        <td><?php echo $item->product;?></td>
                        <td><?php echo $item->price;?></td>
                        <td><?php echo $item->qty;?></td>
                        <td><a href="#"><i class="fas fas-trash"></i></a></td>
                    </tr> 
                <?php endforeach;?>

            </tbody>
        </table>
    </div>
</div>
</div>