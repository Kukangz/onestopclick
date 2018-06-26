<?php
$params = array_merge(
  require __DIR__ . '/../../common/config/params.php',
  require __DIR__ . '/../../common/config/params-local.php',
  require __DIR__ . '/params.php',
  require __DIR__ . '/params-local.php'
);

return [
  'id' => 'app-frontend',
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'frontend\controllers',
  'bootstrap' => ['log'],
  'modules' => [],
  'defaultRoute' => 'site/index',
  'components' => [
    'request' => [
      'csrfParam' => '_csrf-frontend',
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
    ],
    'session' => [
            // this is the name of the session cookie used for login on the frontend
      'name' => 'advanced-frontend',
    ],
    'redis' => [
      'class' => 'yii\redis\Connection',
      'hostname' => 'localhost',
      'port' => 6379,
      'database' => 0,
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'cart' => [
      'class' => 'yii2mod\cart\Cart',
            // you can change default storage class as following:
      'storageClass' => [
        'class' => 'yii2mod\cart\storage\DatabaseStorage',
                // you can also override some properties 
        'deleteIfEmpty' => true
      ]
    ],

    'errorHandler' => [
      // 'errorAction' => 'site/error',
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      // 'enableStrictParsing' => false,
      'suffix' => '',
      'rules' => [
        'member/transaction/<id:(.*)>' => 'member/transaction',
        'brand/<slug:(.*)>' => 'brand/item',
        'downloads/product' => 'member/download',
        'payment-complete' => 'payment/done',
        'cart/voucher' => 'cart/voucher',
        'checkout' => 'cart/checkout',
        'cart/destroy' => 'cart/destroy',
        'cart/delete/<item:(.*)>' => 'cart/delete',
        'cart/update/<item:(.*)>/<qty:(.*)>' => 'cart/update',
        'cart/add/<item:(.*)>/<qty:(.*)>' => 'cart/add',
        'cart/add/<item:(.*)>' => 'cart/add',
        'cart/add/' => 'cart/add',
        'cart/' => 'cart/index',
        'cart' => 'cart/index',
        'dashboard' => 'site/index',
        'search' => 'search/index',
        'newsletter/subscribe' => 'newsletter/subscribe',
        'newsletter/subscribe/<item:(.*)>' => 'newsletter/subscribe',
        'product/review' => 'product/review',
        'product/<slug:(.*)>' => 'product/index',
        'category/<cats:(.*)>/<subcategory:(.*)>' => 'category/index',
        'category/<cats:(.*)>' => 'category/index/',
        'login' => 'auth/index',
        'auth' => 'auth/index',
        'auth/<act:(.*)>' => 'auth/<act>',
      ]
    ],
  // 'reCaptcha' => [
  //   'name' => 'reCaptcha',
  //   'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
  //   'siteKey' => '6LdniF0UAAAAAFv-BulVUDN-EagSkMq5EGURVt1T',
  //   'secret' => '6LdniF0UAAAAAOTgw5cEtgZ7HS5rN7JmRdBLgnoG',
  // ],

    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@app/mail',
      'transport' => [
        'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.sendgrid.net', // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'apikey',
                'password' => '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',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
              ],
//            'viewPath' => 'app/view/layouts/mail',
              'useFileTransport' => false,
            ],

          ],
          'params' => $params,
        ];
