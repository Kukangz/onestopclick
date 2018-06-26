<?php 


use app\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\CMS;

$bundle = AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
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
        <div class="sidebar" data-background-color="black" data-image="<?php echo Url::to('@web/image/sidebar-master.jpg', true) ?>">
                <!--
                    Tip 2: you can also add an image using data-image tag
                -->
                <div class="sidebar-wrapper">
                    <div class="user">                          
                        <div class="photo">
                            <img src="http://kitacerdas.com/wp-content/uploads/2015/03/9-300x401.jpg" />
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                                <span>
                                    <small><?php echo YII::$app->user->identity->name;?></small> <b class="caret"></b>
                                </span>
                            </a>
                            <div class="collapse" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="account">
                                            <span class="sidebar-mini">Pr</span>
                                            <span class="sidebar-normal">Profile</span>
                                        </a>
                                    </li>                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav">
                        <li <?php echo CMS::activeMenu($this->params['menu'],'dashboard');?>>
                            <a href="<?php echo Url::to('/dashboard');?>">
                                <i class="material-icons">dashboard</i>
                                <p> Dashboard </p>
                            </a>
                        </li>

                        <?php $menus = CMS::getMenu(); if($menus): foreach($menus['group'] as $key =>  $item):?>
                        <li <?php echo CMS::activeMenu($this->params['menu'],$key);?> <?php echo CMS::activeMenu($this->params['menu'],strtolower($key),'aria-expanded="true"','aria-expanded="false"');?>>
                            <a data-toggle="collapse" href="#<?php echo $key;?>" <?php echo CMS::activeMenu($this->params['menu'],strtolower($key),'aria-expanded="true"','aria-expanded="false"');?>>
                                <i class="material-icons"><?php echo $item['icon'];?></i>
                                <p> <?php echo $item['name'];?><b class="caret"></b></p>
                            </a>
                            <div class="<?php echo CMS::activeMenu($this->params['menu'],strtolower($key),'collapsed collapse in','collapsed collapse');?>" id="<?php echo strtolower($key);?>" aria-expanded="true">
                                <ul class="nav">
                                    <?php foreach($menus['menu'][$key] as $key => $menu):
                                        if($menu['access'] == '0'):continue;endif;
                                        ?>
                                        <li <?php echo CMS::activeMenu($this->params['submenu'],strtolower($menu['slug']));?>>
                                            <a href="<?php echo Url::to('/'.$menu['slug']);?>" style="padding-left: 25px;">
                                                <i class="material-icons">navigate_next</i>
                                                <!-- <i class="material-icons"><?php echo $menu['icon'];?> </i> -->
                                                <span class="sidebar-normal"><?php echo $menu['name'];?> </span>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                            <ul class="treeview-menu">
                            </ul>
                        </li>
                    <?php endforeach; endif;?>

                    <li>
                        <a href="<?php echo Url::to('/signout');?>">
                            <i class="material-icons">exit_to_app</i>
                            <p> Logout </p>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Dashboard &raquo;</a>

                        <?php if($this->params['menu'] !== 'dashboard'):?>
                            <a class="navbar-brand" href="#"><?php echo ucwords($this->params['menu']);?> 
                        <?php endif;?>
                        <?php if($this->params['submenu']):?>
                            &raquo;
                        <?php endif;?>
                    </a>
                    <?php if($this->params['submenu']):?>
                        <a class="navbar-brand" href="#"><?php echo ucwords($this->params['submenu']);?> </a>
                    <?php endif;?>

                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">dashboard</i>
                                <p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
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


<script>
    $("#uploadbtn").change(function () {
        readFile(this, "#picture");
    });

    function slugify(text)
    {
      return text.toString().toLowerCase()
    .replace(/\s+/g, '-')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
}

$('#product-name').blur(function(){
    $('#product-slug').val(slugify($(this).val()));
});


$('#picture').click(function(){
    $('#uploadbtn').trigger('click');
});



</script>



</body>
</html>
<?php $this->endPage() ?>