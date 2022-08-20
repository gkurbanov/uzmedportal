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
    'bootstrap' => ['log', function () {
        //Global settings
        $main_settings = (new \yii\db\Query())->from(["main_setting"])->where(["id" => 1])->one();

//        $main_settings = \Yii::$app->cache->getOrSet("global_settings", function () {
//            return (new \yii\db\Query())->from(["main_setting"])->where(["id" => 1])->one();
//        });
        Yii::$app->params["main_settings"] = $main_settings;
    }],
    'controllerNamespace' => 'frontend\controllers',
    'sourceLanguage' => 'ru', // использован в качестве ключей переводов
    'modules' => [
        'languages' => [
            'class' => 'klisl\languages\Module',
            //Языки используемые в приложении
            'languages' => [
                'RU' => 'ru',
                'UZ' => 'uz',
            ],
            'default_language' => 'ru', //основной язык (по-умолчанию)
            'show_default' => false, //true - показывать в URL основной язык, false - нет
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '', //убрать frontend/web
            'class' => 'klisl\languages\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ]
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
            'rules' => [
                'languages' => 'languages/default/index', //для модуля мультиязычности
                '' => 'site/index',
                'page/<slug:[-a-zA-Z && 0-9]+>' => 'page/index',
                'page/<slug:[-a-zA-Z && 0-9]+>/<slug2:[-a-zA-Z && 0-9]+>' => 'page/index',
                'page/<slug:[-a-zA-Z && 0-9]+>/<slug2:[-a-zA-Z && 0-9]+>/<slug3:[-a-zA-Z && 0-9]+>' => 'page/index',

                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                'anons/<slug:[-a-zA-Z && 0-9]+>' => 'anons/index',
                'events/<slug:[-a-zA-Z && 0-9]+>' => 'events/index',
                'projects/<slug:[-a-zA-Z && 0-9]+>' => 'projects/index',
            ],
        ],
    ],
    'params' => $params,
];
