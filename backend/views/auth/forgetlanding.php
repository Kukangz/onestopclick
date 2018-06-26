<?php 
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<div class="card-content signup-padding">
	<h4 class="card-title">Your password and further instructions have been sent to your e-mail address.</h4>


	<label class="control-label">Please click <a href="<?php echo Url::to('/auth/resend/?key='.Yii::$app->request->get('key'));?>">here</a> if you didn't recieve the email.</label>

</div>