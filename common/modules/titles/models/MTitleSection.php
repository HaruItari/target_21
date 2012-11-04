<?php
/**
 * Разделы аниме-релизов.
 */
class MTitleSection extends Model
{
    /**
     * Фозвращает класс модели.
     * Класс инициализируется лиш однажды.
     * @static
     * @return object
     */
    public static function model()
    {
        if(!isset(MTitleSection::$_model))
            MTitleSection::$_model = new MTitleSection();

        return MTitleSection::$_model;
    }

    /**
     * Возвращает список разделов.
     * @params string $block Блок релизов, для которого выбираются разделы.
     * если укзанно "all" - выбираются все разделы
     * @param string $attr Если указан, то будет возвращен одномерный массив со значениями
     * указанного аттрибута иначе весь список.
     * если указанный аттрибут не существует, возвращает fasle
     * @return array or bool
     */
    public function getList($block, $attr = null)
    {
        // Выбираем из списка указанный блок.
        if($block == 'all') {
            $list[] = '';
            foreach($this->_list as $item)
                $list += $item;

            unset($list[0]);
        } else {
            $list = $this->_list[$block];
            if(empty($list)) return false;
        }

        // Если передан аттрибут, собираем массив из указанных элементов.
        if(!empty($attr)) {
            foreach($list as $item) {
                if(isset($item[$attr]))
                    $return[] =$item[$attr];
                else
                    return false;
            }

            return $return;
        }

        return $list;
    }

    /**
     * Возвращает список разделов для выпадающег осписка.
     * @params string $block Блок релизов, для которого выбираются разделы.
     * @return array or bool
     */
    public function getListForDdl($block)
    {
        $list = $this->getList($block);

        if(empty($list))
            return false;

        foreach($list AS $item) {
            if($item['parent'] == 0) {
                $parent = &$return[$item['name']];

                foreach($list AS $children) {
                    if($children['parent'] == $item['id']) {
                        $parent[$children['id']] = $children['name'];
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Список разделов аниме.
     * Разделы хранятся в виде двухуровневого ассоциативного массива.
     * Первый уровень - разделы-контейнеры, которые не могут содержать в себе релизов.
     * Второй уровень - разделы, содержащие в себе релизы.
     * @var array
     */
    protected $_list = array(
        'anime' => array(
            1  => array('id' => 1,  'name' => 'Аниме с озвучкой', 'url' => 'anime-rus',   'parent' => 0),
            11 => array('id' => 11, 'name' => 'ТВ-сериалы',       'url' => 'tv-rus',      'parent' => 1),
            12 => array('id' => 12, 'name' => 'Фильмы',           'url' => 'film-rus',    'parent' => 1),
            13 => array('id' => 13, 'name' => 'OVA',              'url' => 'ova-rus',     'parent' => 1),
            14 => array('id' => 14, 'name' => 'Онгоинги',         'url' => 'ongoing-rus', 'parent' => 1),

            2  => array('id' => 2,  'name' => 'Аниме с субтитрами', 'url' => 'anime-sub',   'parent' => 0),
            21 => array('id' => 21, 'name' => 'ТВ-сериалы',         'url' => 'tv-sub',      'parent' => 2),
            22 => array('id' => 22, 'name' => 'Фильмы',             'url' => 'film-sub',    'parent' => 2),
            23 => array('id' => 23, 'name' => 'OVA',                'url' => 'ova-sub',     'parent' => 2),
            24 => array('id' => 24, 'name' => 'Онгоинги',           'url' => 'ongoing-sub', 'parent' => 2),
        ),
        'manga' => array(
            3  => array('id' => 3,  'name' => 'Манга', 'url' => 'manga',   'parent' => 0),
            31  => array('id' => 31,  'name' => 'Завершенная манга', 'url' => 'manga-complete',   'parent' => 3),
            32  => array('id' => 32,  'name' => 'Незавершенная манга', 'url' => 'manga-incomplete',   'parent' => 3),
        ),
    );

    /**
     * экземпляр класса.
     * @var object
     */
    private static $_model;
}