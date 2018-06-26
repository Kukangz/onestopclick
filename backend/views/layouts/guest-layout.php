<?php 


use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrapper" base-color="yellow">
        <!--you can change the template color of the data page using: base-color="red | yellow | green " -->
        <div class="login-page">
            <div class="content">
                <div class="container">
                    <div class="card card-login card-hidden" style="height: 600px;">
                        <div class="card-info">
                            <?php echo Html::img('@web/image/Master.png') ?>
                        </div>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>