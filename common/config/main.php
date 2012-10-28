<?php
/**
 * Глобальная конфигурация приложения.
 */
return array(
    'defaultController' => 'index',

    'sourceLanguage' => 'ru',
    'language' => 'ru',

    'preload' => array(
        'log',
    ),

    'import' => array(
        'common.components.*',
        'common.components.baseClasses.*',
        'common.components.global.*',
        'common.components.validators.*',

        'common.modules.users.models.MUser',
        'common.modules.users.models.MUserGroup',
    ),

    'modules' => array(
        'users',
        'anime',
    ),

    'components' => array(
        'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
			),
		),

        'user' => array(
            'allowAutoLogin' => true,
        ),

        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array(
                'guest',
            ),
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '.html',
            'rules' => array(

            ),
        ),

        'db' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=target_21',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),

        'memCache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'dbCache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'fileCache' => array(
            'class' => 'system.caching.CFileCache',
        ),
    ),
);