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
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
          ]
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\Employee',
            'enableAutoLogin' => false,
            'enableSession' => false,
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
                [
                  'class' => 'yii\rest\UrlRule',
                  'controller' => 'employee',
                  'pluralize' => false,
                    'extraPatterns' => [
                        'GET foo' => 'foo',
                        'OPTIONS foo' => 'options',
                    ],
                    'except' => ['index', 'create', 'view', 'update', 'delete'],
                ],
                [
                  'class' => 'yii\rest\UrlRule',
                  'controller' => 'category',
                  'pluralize' => false,
                    'extraPatterns' => [
                        'GET foo' => 'foo',
                        'OPTIONS foo' => 'options',
                    ],
                    'except' => ['index', 'create', 'view', 'update', 'delete'],
                ],
                [
                  'class' => 'yii\rest\UrlRule',
                  'controller' => 'dish',
                  'pluralize' => false,
                    'extraPatterns' => [
                        'GET foo' => 'foo',
                        'OPTIONS foo' => 'options',
                    ],
                    'except' => ['index', 'create', 'view', 'update', 'delete'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
