<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [ 
        'css/bootstrap.min.css',
        'css/material-dashboard.css',
        'css/pluginpro.css',
        'css/site.css',
        'css/bootstrap-social.css',
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css'
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js',
        // 'js/jquery-3.2.1.min.js',
        'js/bootstrap.min.js',
        'js/main.js',
        'js/material.min.js',
        'js/modernizr.js',
        'js/pluginpro.js',
        'js/jquery-jvectormap.js',
        'js/perfect-scrollbar.jquery.min.js',
        'js/material-dashboard.js',
        'js/jquery.validate.min.js',
        'js/jquery.sharrre.js',
        'js/jquery.bootstrap-wizard.js',
        'js/jquery.datatables.js',
        'js/arrive.js',
        'js/jquery.tagsinput.js'
    ];
    public $depends = [
        '\rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset'
    ];
}
