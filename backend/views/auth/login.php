<?php 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<div class="card-content">
    
    <?php 
    $form = ActiveForm::begin(['action' => ['/auth/']]); ?>
    <div class="col-md-6 col-md-offset-3 login-padding-multi" style="text-align:center;">
        <h4 class="card-title">SIGN IN TO CONTINUE</h4>
        <br>
        <div class="form-group label-floating">
            <label class="control-label">Email</label>
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Password</label>
            <?= $form->field($model, 'password')->passwordInput(); ?>
        </div>
        <div class="checkbox" style="display:none;">
            <label>
                <input type="checkbox" name="remember" value="1"> Remember Me
            </label>
        </div>
        <button type="submit" class="btn">LOGIN</button>
        
    </div>
    <?php ActiveForm::end(); ?>

</div>