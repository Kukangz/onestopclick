<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [  
        '//fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300',
        '//fonts.googleapis.com/css?family=Raleway:400,100',
        'css/bootstrap.min.css',
        'css/owl.carousel.css',
        'css/style.css',
        'css/responsive.css',
        'css/jquery.toastmessage.css',
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        '//use.fontawesome.com/47cff9eb2f.js',
        'js/owl.carousel.min.js',
        'js/jquery.sticky.js',
        'js/jquery.easing.1.3.min.js',
        'js/main-fo.js',
        'js/bxslider.min.js',
        'js/script.slider.js',
        'js/social-login.js',
        'js/jquery.toastmessage.js',
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.js'
    ];
    // public $depends = [
    // ];

    public $publishOptions = [
        'only' => [
            'fonts/*',
            'css/*',
        ]
    ];

    public $depends = [
        '\rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
