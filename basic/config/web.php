<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'iRSz3EaTOL88V_zm-1u-iH7G20ZJ-OxG',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'register' => 'site/register',
                'login' => 'site/login',
                'retrieve-password' => 'site/retrieve-password',
                'password-resetting' => 'site/password-resetting',
                'verification' => 'site/verification',
                'about' => 'site/about',
                'contact' => 'site/contact',
                'admin-panel' => 'admin/users',
                'admin-panel/<action>' => 'admin/users/<action>',
                
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.mail.ru',
                'username'   => 'lamer_10@mail.ru',
                'password'   => 'bphfzdhfq',
                'port'       => '465',
                'encryption' => 'ssl',
            ],
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
        'db' => $db,
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
              'facebook' => [
                'class' => 'yii\authclient\clients\Facebook',
                'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                'clientId' => '575683909870844',
                'clientSecret' => '1d35016e35e47c001719c72ed3338de9',
                'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
              ],
              'vkontakte' => [
                'class' => 'yii\authclient\clients\VKontakte',
                'clientId' => '7232882',
                'clientSecret' => '38JdPHVTOa0MZMhU3lbH',
                'attributeNames' => ['uid', 'first_name', 'last_name'],
              ],
              'google' => [
                'class' => 'yii\authclient\clients\Google',
                'clientId' => '926202433572-gk2p7uuclm4kimf02u97ubqiq1353kg2.apps.googleusercontent.com',
                'clientSecret' => 'VZonQLURYYCFrE08lp0_NITT',
              ],
            ],
          ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'params' => $params,
    
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
