<?php 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<div class="card-content">
    
    <?php 
    $form = ActiveForm::begin(['action' => ['/auth/']]); ?>
    <div class="col-md-6 login-padding-multi">
        <h4 class="card-title">LOGIN</h4>
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
        <a href="<?php echo URL::to('/auth/forget');?>" style="text-align:center;display:block;color: #ce3131;">Forget Your Password?</a>
        <button type="submit" class="btn">LOGIN</button>
        Don't have an account <a href="<?php echo URL::to('/auth/signup');?>">Create One! </a>
        
    </div>

    <div class="col-md-1 login-or">
        <h4 class="align-middle">OR</h4>
    </div>
    <div class="col-md-5 login-padding-multi">
        <h4 class="card-title">LOGIN WITH</h4>

         <a class="btn btn-social-icon btn-facebook" id="fb">
            <span class="fa fa-facebook">&nbsp;Sign in with Facebook</span> 
        </a>

        <a class="btn btn-social-icon btn-google" id="gplus">
            <span class="fa fa-google">&nbsp;Sign in with Google</span> 
        </a>
    </div>
    <?php ActiveForm::end(); ?>
</div>