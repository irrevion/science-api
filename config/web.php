<?php

// $params = require __DIR__ . '/params.php';
// $db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads' => 'uploads',
    ],
	'timeZone' => 'Asia/Baku',
    // 'language' => 'az-AZ',
    'language' => 'en-US',
	'sourceLanguage' => 'en-US',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JEVlfdRyISiGi-9_0iIm4SMJg-F0yqXr',
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
            'useFileTransport' => true,
        ],
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'class' => 'yii\log\FileTarget',
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
        // 'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				'/' => 'site/welcome',
				'GET api/physics/units/categories/?' => 'api-converter/unit-categories',
				'GET api/physics/units/categories' => 'api-converter/unit-categories',
				'GET api/physics/units/category/<category>/?' => 'api-converter/units-by-category',
				'GET api/physics/units/category/<category>' => 'api-converter/units-by-category',
				'OPTIONS,POST api/physics/units/convert/?' => 'api-converter/convert',
				'OPTIONS,POST api/physics/units/convert' => 'api-converter/convert',
				// '<url:.+/>' => 'site/redirect'
            ],
        ],
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
					//'sourceLanguage' => 'en-US',
					'fileMap' => [
						'app' => 'app.php',
						'app/error' => 'error.php',
					],
				],
			],
		],
    ],
    // 'params' => $params,
];

/*if (YII_ENV_DEV) {
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
}*/

//date_default_timezone_set($config['timeZone']);

return $config;
