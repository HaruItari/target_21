<?php
/**
 * Иерархия ролей.
 */
return array(
    'titles_add_title' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добвление нового релиза',
        'children' => array(
            'titles_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'titles_access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'доступ к cms модуля ANIME',
        'children' => array(
            'access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),

);