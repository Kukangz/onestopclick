<?php 

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<div class="card-content signup-padding">
	<h4 class="card-title">Forget Password</h4>
	<?php 

	if($error):?>
		<label class="form-label"><?= $error;?></label>
		<div class="clearfix">&nbsp;</div>
	<?php endif;?>
	<?php $form = ActiveForm::begin(['action' => ['/auth/forget']]); ?>
	<div class="form-group label-floating">
		<label class="control-label">Email</label>
		<?= $form->field($model, 'email') ?>
	</div>

	<button type="submit" class="btn">Request new Password</button>
	<?php ActiveForm::end(); ?>

</div>