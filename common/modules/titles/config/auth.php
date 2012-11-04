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
    'titles_edit_title' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Редактирование релиза',
        'children' => array(
            'titles_access_cms',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'titles_edit_own_title' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Редактирование собственного релиза',
        'children' => array(
            'titles_access_cms',
        ),
        'bizRule' => 'return (!empty($params["author"]) && ($params["author"] == Yii::app()->user->id)) ? true : false;',
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