<?php
/**
 * Аниме-релизы - фильмы и сериалы.
 *
    CREATE TABLE `title_anime` (
    `id` INT NOT NULL ,
    `type` VARCHAR( 100 ) NULL ,
    `edition_begin` INT NULL ,
    `edition_end` INT NULL ,
    `edition_details` VARCHAR( 100 ) NULL ,
    `dub_type` INT NULL ,
    `dub_author` VARCHAR( 100 ) NULL ,
    `dub_type` INT NULL ,
    `subs_author` VARCHAR( 100 ) NULL ,
    `episodes_list` VARCHAR( 5000 ) NULL ,
    `film_director` VARCHAR( 50 ) NULL ,
    PRIMARY KEY ( `id` )
    ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MAnime extends ActiveRecord
{
    /**
     * @see CActiveRecord::model()
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return 'title_anime';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('type', 'length', 'max' => 100),

            array('edition_begin, edition_end' , 'match', 'pattern' => '/^\d\d\.\d\d\.\d\d\d\d$/iu'),

            array('edition_details', 'length', 'max' => 100),

            array('dub_author, subs_author', 'length', 'max' => 50),

            array('dub_type', 'in', 'range' => MAnime::getDubTypesList('id')),

            array('subs_type', 'in', 'range' => MAnime::getSubsTypesList('id')),

            array('episodes_list', 'length', 'max' => 5000),

            array('film_director', 'length', 'max' => 50),
        );
    }

    /**
     * @see ActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'type' => 'Тип релиза',
            'edition' => 'Премьера',
            'edition_begin' => 'Трансляция (начало)',
            'edition_end' => 'трансляция (конец)',
            'edition_details' => 'Трансляция (детали)',
            'episodes_list' => 'Список эпизодов',
            'dub_type' => 'Тип озвучки',
            'dub_author' => 'Озвучивает',
            'subs_type' => 'Тип субтитров',
            'subs_author' => 'Автор субтитров',
            'film_director' => 'Режисер',
        );
    }

    /**
     * @see ActiveRecord::attributeNotes()
     */
    public function attributeNotes()
    {
        return array(

        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'rBase' => array(
                self::HAS_ONE,
                'MAnime',
                'id',
            ),
        );
    }

    /**
     * Возвращает список типов озвучки.
     * @static
     * @params string @attr Если передан, возвращает одномерный массив с указанным аттрибутом,
     * иначе возвращает полный список.
     * Если аттрибут не существует - возвращает false
     * @return array or bool
     */
    public static function getDubTypesList($attr = null)
    {
        $list = MAnime::$_dubTypesList;

        if(!empty($attr)) {
            foreach($list as $item) {
                if(isset($item[$attr]))
                    $return[] = $item[$attr];
                else
                    return false;
            }

            return $return;
        }

        return $list;
    }

    /**
     * Возвращает тип озвучки по умолчанию.
     * @static
     * @return int
     */
    public static function getDubTypeDefault()
    {
        return MAnime::$_dubTypeDefault;
    }

    /**
     * Возвращает список типов озвучки для dropDownList
     * @static
     * @return array
     */
    public static function getDubTypesListForDdl()
    {
        $list = MAnime::getDubTypesList();

        foreach($list as $item) {
            $return[$item['id']] = $item['name'];
        }

        return $return;
    }


    /**
     * Возвращает список типов субтитров.
     * @static
     * @params string @attr Если передан, возвращает одномерный массив с указанным аттрибутом,
     * иначе возвращает полный список.
     * Если аттрибут не существует - возвращает false
     * @return array or bool
     */
    public static function getSubsTypesList($attr = null)
    {
        $list = MAnime::$_subsTypesList;

        if(!empty($attr)) {
            foreach($list as $item) {
                if(isset($item[$attr]))
                    $return[] = $item[$attr];
                else
                    return false;
            }

            return $return;
        }

        return $list;
    }

    /**
     * Возвращает тип субтитров по умолчанию.
     * @static
     * @return int
     */
    public static function getSubsTypeDefault()
    {
        return MAnime::$_subsTypeDefault;
    }

    /**
     * Возвращает список типов субтитров для dropDownList
     * @static
     * @return array
     */
    public static function getSubsTypesListForDdl()
    {
        $list = MAnime::getSubsTypesList();

        foreach($list as $item) {
            $return[$item['id']] = $item['name'];
        }

        return $return;
    }

    /**
     * Список типов озвучки.
     * @static
     * @var array
     */
    protected static $_dubTypesList = array(
        1 => array('id' => 1, 'name' => 'Оригинальная'),
        2 => array('id' => 2, 'name' => 'Одноголосая'),
        3 => array('id' => 3, 'name' => 'Двуголосая'),
        4 => array('id' => 4, 'name' => 'Многоголосая'),
        5 => array('id' => 5, 'name' => 'Дублированная'),
    );

    /**
     * Тип озвучки по умолчанию.
     * @static
     * @var int
     */
    protected static $_dubTypeDefault = 2;

    /**
     * Список типов субтитров.
     * @static
     * @var array
     */
    protected static $_subsTypesList = array(
        1 => array('id' => 1, 'name' => 'Отсутствуют'),
        2 => array('id' => 2, 'name' => 'Внешние'),
        3 => array('id' => 3, 'name' => 'В контейнере'),
        4 => array('id' => 4, 'name' => 'Хардсаб'),
    );

    /**
     * Тип субтитров по умолчанию.
     * @static
     * @var int
     */
    protected static $_subsTypeDefault = 1;

     /**
     * @see CActiveRecord:beforeSave()
     */
    protected function beforeSave()
    {
        if(!parent::beforeSave())
            return false;

        // Обрабатываем введенные данные и замещаем пустые поля на NULL.
        $this->edition_begin =   (empty($this->edition_begin))   ? new CDbExpression('NULL') : strtotime($this->edition_begin);
        $this->edition_end =     (empty($this->edition_end))     ? new CDbExpression('NULL') : strtotime($this->edition_end);
        $this->edition_details = (empty($this->edition_details)) ? new CDbExpression('NULL') : LString::safeText($this->edition_details);
        $this->film_director =   (empty($this->film_director))   ? new CDbExpression('NULL') : LString::safeText($this->film_director);
        $this->episodes_list =   (empty($this->episodes_list))   ? new CDbExpression('NULL') : LBbCode::bbToHtml($this->episodes_list, 'full');
        $this->subs_author =     (empty($this->subs_author))     ? new CDbExpression('NULL') : LString::safeText($this->subs_author);
        $this->dub_author =      (empty($this->dub_author))      ? new CDbExpression('NULL') : LString::safeText($this->dub_author);
        $this->type =            (empty($this->type))            ? new CDbExpression('NULL') : LString::safeText($this->type);

        return true;
    }

    /**
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        if(!empty($this->edition_begin))   $this->edition_begin = date('d.m.Y', $this->edition_begin);
        if(!empty($this->edition_end))     $this->edition_end = date('d.m.Y', $this->edition_end);
        if(!empty($this->edition_details)) $this->edition_details = LString::safeText($this->edition_details, true);
        if(!empty($this->film_director))   $this->film_directo = LString::safeText($this->film_director, true);
        if(!empty($this->episodes_list))   $this->episodes_list = LBbCode::htmlToBb($this->episodes_list);
        if(!empty($this->subs_author))     $this->subs_author = LString::safeText($this->subs_author, true);
        if(!empty($this->dub_author))      $this->dub_author = LString::safeText($this->dub_author, true);
        if(!empty($this->type))            $this->type = LString::safeText($this->type, true);
    }
}