<?php 

use frontend\assets\SiteAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use frontend\components\CMS;
use yii\helpers\ArrayHelper;
use yii\widgets\activeForm;
use yii\web\View;

$bundle = SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://use.fontawesome.com/47cff9eb2f.js"></script>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fb:app_id" content="598310047210333" />
    <meta name="og:url" content="http://frontend.test" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body>

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="<?php echo Url::to('/');?>"> <?php echo Html::img('@web/image/logo.png');?></a></h1>
                    </div>
                </div>

                <div class="col-sm-6">

                    <?php if (Yii::$app->user->isGuest):?>
                        <div class="shopping-item" >
                            <a href="<?php echo Url::to('/login');?>">Login / Signup
                            </a>
                        </div>
                        <div class="shopping-item" style="margin-right: 15px;">
                            <a href="<?php echo Url::to('/cart');?>">Cart - 
                                <span class="cart-amunt"><?php echo CMS::getTotalCart();?> Rupiah</span> 
                                <i class="fa fa-shopping-cart"></i> 
                                <span class="product-count"><?php echo CMS::getCartItems();?></span>
                            </a>
                        </div>
                        <?php else:?>
                            <div class="login-header" >
                                <label class="pull-right"><?php echo Yii::$app->user->identity->name;?></label>
                                <div class="clearfix"></div>
                                <label class="pull-right">Balance : <?php echo number_format(Yii::$app->user->identity->balance);?></label>
                                <div class="clearfix"></div>
                                <a class="pull-right" href="<?= Url::to('/member/');?>">Member Area</a>
                                <div class="clearfix"></div>
                                <a class="pull-right" href="<?= Url::to(['/member','#' => 'downloads']);?>">Downloads</a>
                                <div class="clearfix"></div>
                                <a class="pull-right" href="<?= Url::to('/auth/logout');?>">Sign out</a>

                            </div>
                            <div class="shopping-item" style="margin-top: 98px;position: absolute;right: 200px;">
                                <a href="<?php echo Url::to('/cart');?>">Cart - 
                                    <span class="cart-amunt"><?php echo CMS::getTotalCart();?> Rupiah</span> 
                                    <i class="fa fa-shopping-cart"></i> 
                                    <span class="product-count"><?php echo CMS::getCartItems();?></span>
                                </a>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div> <!-- End site branding area -->

        <div class="mainmenu-area">
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div> 
                    <div class="navbar-collapse collapse pull-right">
                        <div class="col-md-12">
                            <form method="get" action="<?php echo Url::to('/search');?>" class="form-horizontal">
                                <div class="form-group" style="margin-top:10px;">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <?php 
                                            $search_criteria = ArrayHelper::map(CMS::getMenu(),'id','name');
                                            echo Html::dropDownList('category', ['prompt' => 'All Categories'], 
                                                $search_criteria,['class' => 'pull-right form-control','prompt' => 'All Categories']);
                                                ?>    
                                            </div>
                                        </div>        
                                        <div class="col-md-4">                                
                                            <div class="row">
                                                <?php echo Html::input('text', 'q', null,['name'=> 'search','class' => 'form-control' ,'style' => 'width: 185px;','required' => TRUE]);?>
                                            </div>
                                        </div>

                                        <div class="col-md-2" style="padding-right:0;">                                
                                            <button type="submit" style="padding:10px 16px;"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-nav pull-left">

                            <?php
                            $items[] = ['label' => 'Home', 'url' => '/', 'active' => ($this->params['menu'] === 'home')];
                            $source = CMS::getMenu();
                            foreach($source as $item):
                                $items[] = ['label' => ucwords($item->name), 'url' => '/category/'.$item->slug, 'active' => ($this->params['menu'] === $item->slug)];
                            endforeach;

                            foreach(CMS::getOtherMenu() as $key =>  $item){
                                $items[] = ['label' => ucwords($key), 'url' => $item, 'active' => ($this->context->route === $item)];
                            }
                            echo Menu::widget([
                                'items' => $items,
                                'options' => array('class' => 'navbar-nav nav'),
                                'activeCssClass'=>'active']);
                                ?>
                            </ul>

                        </div>  
                    </div>
                </div>
            </div> <!-- End mainmenu area -->
            
            <?php echo $content;?>


            <div class="footer-top-area">
                <div class="zigzag-bottom"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="footer-about-us">
                                <h2>One<span>Stopclick</span></h2>
                                <p>One Stop Clicking is a digital content marketplace, which provide kinds of downloadable content, such as movie, book, music, and mobile/desktop application.</p>
                                <div class="footer-social">
                                    <a href="//www.facebook.com/myonlywawa" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="//www.twitter.com/myonlywawa" target="_blank"><i class="fa fa-twitter"></i></a>
                                    <a href="//www.youtube.com/myonlywawa" target="_blank"><i class="fa fa-youtube"></i></a>
                                    <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">

                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="footer-newsletter">
                                <h2 class="footer-wid-title">Newsletter</h2>
                                <p>Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!</p>
                                <div class="newsletter-form">
                                    <?php $form = ActiveForm::begin(['action' => ['/newsletter/subscribe/']]); ?>

                                    <input type="email" placeholder="Type your email" name="email">

                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End footer top area -->

            <div class="footer-bottom-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="copyright">
                                <p>&copy; 2018 OneStopclick. All Rights Reserved.</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="footer-card-icon">
                                <i class="fa fa-cc-discover"></i>
                                <i class="fa fa-cc-mastercard"></i>
                                <i class="fa fa-cc-paypal"></i>
                                <i class="fa fa-cc-visa"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End footer bottom area -->
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                    s1.async=true;
                    s1.src='https://embed.tawk.to/5b16167d8859f57bdc7bd827/default';
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                })();
                
            </script>
            <!--End of Tawk.to Script-->
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
'registerAnimateCss' => true,
'registerButtonsCss' => true,
'registerFontAwesomeCss' => true,
]);;?>
            <?php 
            $this->registerJs("url = '".Url::home(true)."';$('#fb-share').fbSharePopup({ width: '450', height: '300', url: url});
                $('#tw-share').twitterSharePopup({ width: '450', height: '300', url: url});
                $('#gplus-share').gplusSharePopup({ width: '450', height: '300', url: url});",View::POS_READY);
                ?>
            </body>
            <?php $this->endBody() ?>
            </html>
            <?php $this->endPage() ?>