<?php 


use frontend\assets\AppAsset;
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
    <meta name="fb:app_id" content="598310047210333" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrapper" base-color="red">
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
    <?php 
    $this->registerJs(
    /* facebook SDK */ "FBSdkInit({ appId: '598310047210333', secret: 'ee088c65cf48a17823dc6c8bf1697d72', xfbml: true, version: 'v2.5' });" /* end-facebook SDK */);
    ?>
    <?php \shifrin\noty\NotyWidget::widget([
      'options' => [ // you can add js options here, see noty plugin page for available options
      'dismissQueue' => true,
      'layout' => 'topCenter',
      'theme' => 'relax',
      'animation' => [
          'open' => 'animated flipInX',
          'close' => 'animated flipOutX',
      ],
      'timeout' => false
  ],
  'enableSessionFlash' => true,
  'enableIcon' => true,
  'registerAnimateCss' => false,
  'registerButtonsCss' => false,
  'registerFontAwesomeCss' => false,
]);?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>