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

            'users_add_group',
            'users_edit_group',
            'users_remove_group',
            'users_edit_profile_login',
            'users_edit_profile_group',
            'users_edit_profile_email',
            'users_edit_profile_email_confirm',
            'users_remove_profile',

            'titles_add_title',
            'titles_edit_title',
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
// Модуль TITLES.
$global += require_once(Yii::getPathOfAlias('common.modules.titles.config.auth') . '.php');

return $global;