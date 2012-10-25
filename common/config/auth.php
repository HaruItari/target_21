<?php
/**
 * Иерархия ролей.
 */

// Глобальные роли.
$global = array(
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администраторы',
        'children' => array(
            'user',

            'user_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователи',
        'children' => array(
        ),
        'bizRule' => null,
        'data' => null,
    ),

    'access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Доступ к CMS',
        'children' => array(
        ),
        'bizRule' => null,
        'data' => null,
    ),
);

// Модуль USERS.
$global += require_once(Yii::getPathOfAlias('common.modules.users.config.auth') . '.php');

return $global;