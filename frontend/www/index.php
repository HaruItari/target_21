<?php
// Вклюячаем дебаг-режим.
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// Инициализируем глобальные константы.
const FRONTEND_URL = 'http://target_17/frontend/www/';
const BACKEND_URL = 'http://target_17/backend/www/';

// Устанавливаем текущую директорию в корень сайта.
chdir(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');

// Подключаем файлы фреймворка и конфигурации.
require_once('common' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'yii_1.1.12' . DIRECTORY_SEPARATOR . 'yii.php');
$frontConfig = require_once('frontend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');
$globalConfig = require_once('common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php');

// Инициализируем алиасы.
$root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('media', $root . DIRECTORY_SEPARATOR . 'media');
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
Yii::setPathOfAlias('www', $root. DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'www');

// Создаем приложение.
require_once('common' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'baseClasses' . DIRECTORY_SEPARATOR . 'WebApplication.php');
$app = Yii::createApplication('WebApplication', CMap::mergeArray($globalConfig, $frontConfig));
$app->run();