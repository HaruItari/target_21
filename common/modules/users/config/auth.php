<?php
/**
 * Иерархия ролей.
 */
return array(
    'users_add_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление новой группы пользователей',
        'children' => array(
            'users_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'users_edit_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Редактирование группы пользователей',
        'children' => array(
            'users_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'users_remove_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Удаление группы пользователей',
        'children' => array(
            'users_access_cms',
        ),
        'bizRule' => 'return ($params["countUsers"] == 0 && $params["isDefault"] == 0) ? true : false;',
        'data' => null,
    ),

    'users_edit_profile' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Редактирование профиля пользователя',
        'children' => array(
            'users_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
            'users_edit_profile_login' => array(
                'type' => CAuthItem::TYPE_OPERATION,
                'description' => 'Редактирование профиля пользователя (логин)',
                'children' => array(
                    'users_edit_profile',
                ),
                'bizRule' => null,
                'data' => null,
            ),
            'users_edit_profile_email' => array(
                'type' => CAuthItem::TYPE_OPERATION,
                'description' => 'Редактирование профиля пользователя (email)',
                'children' => array(
                    'users_edit_profile',
                ),
                'bizRule' => null,
                'data' => null,
            ),
            'users_edit_profile_group' => array(
                'type' => CAuthItem::TYPE_OPERATION,
                'description' => 'Редактирование профиля пользователя (группа)',
                'children' => array(
                    'users_edit_profile',
                ),
                'bizRule' => 'return (!empty($params["id"]) && Yii::app()->user->id != $params["id"]) ? true : false;',
                'data' => null,
            ),

    'users_remove_profile' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Удаление профиля пользователя',
        'children' => array(
            'users_access_cms',
        ),
        'bizRule' => 'return (!empty($params["id"]) && Yii::app()->user->id != $params["id"]) ? true : false;',
        'data' => null,
    ),

    'users_access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'доступ к cms модуля USERS',
        'children' => array(
            'access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
);