<?php

require(__DIR__ . '/bootstrap.php');
$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');
$permissions = require(__DIR__ . '/permissions.php');

$config = [
    'id' => 'gofunding',
    'name' => 'gofunding',
    'homeUrl' => '/',
    'timeZone' => 'Asia/Jakarta',
    'language' => 'id-ID',
    'sourceLanguage' => 'id-ID',
    'defaultRoute' => 'site/index',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['log'],
    'modules' => $modules,
    'as access' => $permissions,
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'p0P8907Pkksdak@#$%^77d8i12kn90iojaksdm9ijow',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'session' => [
            'class' => 'yii\web\Session',
            // 'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
            // 'timeout' => 3600 * 1, //session expire
            'timeout' => 1,
            'useCookies' => true,
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//            'cachePath' => '@app/runtime/cache'
//        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => '127.0.0.1',
//                    'port' => 11211,
//                    'weight' => 100,
//                ],
//            ],
//        ],
        'user' => [
            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => false,
//            'authTimeout' => 3600, // auth expire     
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
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['yii\web\HttpException:404'],
//                    'levels' => ['error', 'warning'],
//                    'logFile' => '@runtime/logs/error.log',
//                ],
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'categories' => ['yii\web\HttpException:404'],
//                    'levels' => ['info', 'trace', 'profile'],
//                    'logFile' => '@runtime/logs/app.log',
//                ],
//                'email' => [
//                    'class' => 'yii\log\EmailTarget',
//                    'except' => ['yii\web\HttpException:404'],
//                    'levels' => ['error', 'warning'],
//                    'message' => ['from' => 'robot@example.com', 'to' => 'admin@example.com'],
//                ],
//            ],
//        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // only support DbManager
//            'cache' => 'cache'
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=gofunding;port=3306',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
//            // Duration of schema cache.
//            'schemaCacheDuration' => 3600,
//            // Name of the cache component used to store schema information
//            'schemaCache' => 'cache',
//            'on afterOpen' => function($event) {
//            // $event->sender refers to the DB connection
//                $event->sender->createCommand("SET time_zone = '+7'")->execute();
//            }
        ],
//         'view' => [
//            'theme' => [
//                'basePath' => '@app/themes/',
//                'baseUrl' => '@web/themes/',
//                'pathMap' => [
//                    '@app/views' => '@app/themes/landy',
//                ],
//            ],
//        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false, // membatasi akses hanya pada aturan yang dikonfigurasi            
            'rules' => [
                'buat-campaign' => 'site/buat-campaign',
                '<alias:\w+>' => 'site/<alias>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        // 'authClientCollection' => [
        //     'class' => 'yii\authclient\Collection',
        //     'clients' => [
        // 	'google' => [
        // 	    'class' => 'yii\authclient\clients\Google',
        // 	    'clientId' => '*****',
        // 	    'clientSecret' => '*****',
        // 	],
        // 	'facebook' => [
        // 	    'class' => 'yii\authclient\clients\Facebook',
        // 	    'clientId' => '*****',
        // 	    'clientSecret' => '*****',
        // 	],
        // 	'twitter' => [
        // 	    'class' => 'yii\authclient\clients\Twitter',
        // 	    'consumerKey' => '*****',
        // 	    'consumerSecret' => '*****',
        // 	],
        //     ],
        // ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '-',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i:s',
            'timeFormat' => 'php:H.i',
            // 'thousandSeparator' => '.',
            // 'decimalSeparator' => ',',
            'currencyCode' => 'Rp ',
            'defaultTimeZone' => 'Asia/Jakarta',
            'locale' => 'id-ID',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
//            yii\web\Response::FORMAT_JSON => [
//                'class' => 'yii\web\JsonResponseFormatter',
//                'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
//                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
//            ],
        ],
        'menus' => [
            'class' => 'app\components\Menus',
        ],
        'actionLogs' => [
            'class' => 'app\modules\log\components\ActionLogs',
        ],
        'helpersLogs' => [
            'class' => 'app\modules\log\components\HelpersLogs',
        ],
        'globalFunction' => [
            'class' => 'app\components\GlobalFunction',
        ],
        'helpers' => [
            'class' => 'app\components\Helpers',
        ],
        'i18n' => [
            'translations' => [
//                '*' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
//                    'sourceLanguage' => 'en',
//                    'fileMap' => [
//                        //'main' => 'main.php', 
//                        'app' => 'app.php',
//                        'app/error' => 'error.php',
//                    ],
//                ],
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    // 'sourceLanguage' => 'id-ID',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'accessFilter' => [
            'class' => 'app\components\AccessFilter',
        ],
        'detect' => [
            'class' => 'app\widgets\MobileDetect\detect',
        ],
//        'assetManager' => [
//            'bundles' => [
//                'edgardmessias\assets\nprogress\NProgressAsset' => [
//                    'configuration' => [
//                        'minimum' => 1.18,
//                        'showSpinner' => true,
//                    ],
//                    'page_loading' => true,
//                    'pjax_events' => true,
//                    'jquery_ajax_events' => false,
//                ],
//            ],
//        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [
                'class' => 'app\widgets\generators\crud\Generator',
                'templates' => ['dzaCrud' => '@app/widgets/generators/crud/dza']
            ],
            'model' => [
                'class' => 'app\widgets\generators\model\Generator',
                'templates' => ['haifahrul' => '@app/widgets/generators/model/haifahrul']
            ],
            'migration' => [
                'class' => 'app\widgets\generators\migration\Generator'
            ],
        ],
    ];
}

return $config;
