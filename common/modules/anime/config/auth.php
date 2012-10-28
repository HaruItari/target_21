<?php
/**
 * Иерархия ролей.
 */
return array(
    'snime_access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'доступ к cms модуля ANIME',
        'children' => array(
            'access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
);