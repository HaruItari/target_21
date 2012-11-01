<?php
/**
 * Иерархия ролей.
 */
return array(
    'anime_add_anime' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добвление нового релиза',
        'children' => array(
            'anime_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'anime_access_cms' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'доступ к cms модуля ANIME',
        'children' => array(
            'access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),

);