<?php


return [
   'defaultRoute' => 'site/index',
   'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
    '@frontend' => 'c:/xampp/htdocs/onestopclick2/frontend/',
    '@backend' => 'c:/xampp/htdocs/onestopclick2/backend/'
],
'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
'components' => [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'assetManager' => [
        'linkAssets' => false,
    ],
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
        'cache' => 'cache',
    ]
    
    
],
];
