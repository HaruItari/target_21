<?php
/*
 * Жанры ание-релизов.
 */
class MAnimeGenre extends Model
{
    /**
     * Фозвращает класс модели.
     * Класс инициализируется лиш однажды.
     * @static
     * @return object
     */
    public static function model()
    {
        if(!isset(MAnimeGenre::$_model))
            MAnimeGenre::$_model = new MAnimeGenre();

        return MAnimeGenre::$_model;
    }

    /**
     * Возвращает список жанров.
     * @param string $attr Если указан, то будет возвращен одномерный массив со значениями
     * указанного аттрибута иначе весь список.
     * если указанный аттрибут не существует, возвращает fasle
     * @return array or bool
     */
    public function getList($attr = null)
    {
        $list = $this->_list;

        if(!empty($attr)) {
            foreach($list as $item) {
                if(isset($item[$attr]))
                    $return[] =$item[$attr];
                else return false;
            }

            return $return;
        }

        return $list;
    }

    /**
     * Список жанров аниме.
     * @var aaray
     */
    protected $_list = array(
        1 => array('id' => 1, 'name' => 'Триллер',          'url' => 'triller'),
        2 => array('id' => 2, 'name' => 'Фантастика',       'url' => 'fantastika'),
        3 => array('id' => 3, 'name' => 'Повседневность',   'url' => 'povsednevnost'),
        4 => array('id' => 4, 'name' => 'Драма',            'url' => 'drama'),
        5 => array('id' => 5, 'name' => 'Комедия',          'url' => 'komedija'),
    );

    /**
     * экземпляр класса.
     * @var object
     */
    private static $_model;
}