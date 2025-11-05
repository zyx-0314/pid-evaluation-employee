<?php

/**
 * Application Configuration
 * 
 * Following KISS principle: Keep configuration simple and readable
 */

return [
    'id' => 'pid-evaluation-admin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // Cookie validation key - MUST be set via environment variable in production
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY') ?: (YII_ENV === 'dev' ? 'dev-key-not-for-production' : ''),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
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
            'useFileTransport' => true,
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
        'db' => require __DIR__ . '/db.php',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/employees' => 'api/employee/index',
                'api/employees/<id:\d+>' => 'api/employee/view',
                'api/evaluations' => 'api/evaluation/index',
                'api/evaluations/<id:\d+>' => 'api/evaluation/view',
                // Admin UI
                'admin' => 'admin/index',
            ],
        ],
        // AWS S3 service (via LocalStack in development)
        's3' => [
            'class' => 'app\components\S3Service',
            'endpoint' => getenv('AWS_ENDPOINT') ?: 'http://localstack:4566',
            'region' => getenv('AWS_DEFAULT_REGION') ?: 'us-east-1',
            'credentials' => [
                'key' => getenv('AWS_ACCESS_KEY_ID') ?: 'test',
                'secret' => getenv('AWS_SECRET_ACCESS_KEY') ?: 'test',
            ],
        ],
    ],
    'params' => require __DIR__ . '/params.php',
];
