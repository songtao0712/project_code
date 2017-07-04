<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\User::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl'=>['user/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix'=>'.html',
            'rules' => [
//                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>.html'=>'<controller>/<action>',
            ]
        ],
        'qiniuyun'=>[
            'class'=>\backend\components\Qiniuyun::className(),
            'up_host'=>'http://up.qiniu.com',
            'accessKey'=>'NlTgCT_-2XyFs7Nh6yCjTIhje7xXTWeJmhXODigX',
            'secretKey'=>'ypGwG_N6ydlQdKfpMofIG0Da4xpy_WXHKI9p_sPs',
            'bucket'=>'images',
            'domain'=>'http://or9uzw595.bkt.clouddn.com/'
        ],
        'sms'=>[
            'class'=>\frontend\components\Sms::className(),
            'app_key'=>'24479144',
            'app_secret'=>'798fa6430e49a58ef6762f22251f7969',
            'sign_name'=>'宋氏涛哥',
            'template_code'=>'SMS_71550197'
        ]

    ],
    'params' => $params,
    'defaultRoute' => 'user/login'  //控制器/方法
];
