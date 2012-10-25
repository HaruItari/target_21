<?php
/**
 * Конфигурация пользовательскй части.
 */
return array(
    'basePath' => 'frontend',

    'theme' => 'draft',

	'import' => array(
		'frontend.components.*',
	),

    'components' => array(
        'user' => array(
            'class' => 'FrontUser',
            'loginUrl' => '/frontend/www/users/index/login',
        ),
    ),
);