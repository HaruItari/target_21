<?php
/**
 * Иерархия ролей.
 */
return array(
    'user_add_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление новой группы пользователей',
        'children' => array(
            'user_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'user_edit_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Редактирование группы пользователей',
        'children' => array(
            'user_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'user_remove_group' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Удаление группы пользователей',
        'children' => array(
            'user_access_cms',
        ),
        'bizRule' => 'return ($params["countUsers"] == 0 && $params["isDefault"] == 0) ? true : false;',
        'data' => null,
    ),

    'user_access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'доступ к cms модуля USERS',
        'children' => array(
            'access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
);