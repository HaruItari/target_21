<?php
/**
 * Конфигурация администраторской части.
 */
return array(
    'basePath' => 'backend',

	'import' => array(
		'backend.components.*',
	),

    'components' => array(
        'user' => array(
            'class' => 'BackUser',
            'loginUrl' => '/backend/www/index/login',
        ),
    ),
);