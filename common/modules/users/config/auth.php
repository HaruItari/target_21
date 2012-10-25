<?php
/**
 * Иерархия ролей.
 */
return array(
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