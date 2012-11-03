<?php
/**
 * Аниме-релизы - фильмы и сериалы.
 *
    CREATE TABLE `target_21`.`anime_film` (
    `id` INT NOT NULL ,
    `type` VARCHAR( 100 ) NULL ,
    `edition_begin` INT NULL ,
    `edition_end` INT NULL ,
    `edition_details` VARCHAR( 100 ) NULL ,
    `dub` VARCHAR( 100 ) NULL ,
    `subs` VARCHAR( 100 ) NULL ,
    `episodes_list` VARCHAR( 5000 ) NULL ,
    `age_limit` VARCHAR( 5 ) NULL ,
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
        return 'anime_file';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('type', 'length', 'max' => 100),

            array('edition_begin, edition_end' , 'match', 'pattenr' => '/^\d\d\.\d\d\.\d\d\d\d$/iu'),

            array('edition_details', 'length', 'max' => 100),

            array('dub, subs', 'length', 'max' => 50),

            array('episodes_list', 'length', 'max' => 5000),

            array('age_limit', 'length', 'max' => 5),

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
            'dub' => 'Озвучка',
            'subs' => 'Субтитры',
            'age_limit' => 'возрастное ограничение',
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
        $this->subs =            (empty($this->subs))            ? new CDbExpression('NULL') : LString::safeText($this->subs);
        $this->dub =             (empty($this->dub))             ? new CDbExpression('NULL') : LString::safeText($this->dub);
        $this->age_limit =       (empty($this->age_limit))       ? new CDbExpression('NULL') : LString::safeText($this->age_limit);
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
        if(!empty($this->subs))            $this->subs = LString::safeText($this->subs, true);
        if(!empty($this->dub))             $this->dub = LString::safeText($this->dub, true);
        if(!empty($this->age_limit))       $this->age_limi = LString::safeText($this->age_limit, true);
        if(!empty($this->type))            $this->type = LString::safeText($this->type, true);
    }
}