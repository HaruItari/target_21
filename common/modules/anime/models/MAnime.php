<?php
/**
 * Аниме-релизы. Основная таблица.
 *
    CREATE TABLE `anime` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `headline` VARCHAR( 100 ) NOT NULL ,
    `url` VARCHAR( 100 ) NOT NULL ,
    `description` VARCHAR( 2000 ) NULL ,
    `author` INT NOT NULL ,
    `section` INT NOT NULL ,
    `date_create` INT NOT NULL ,
    `html_title` VARCHAR( 250 ) NULL ,
    `html_description` VARCHAR( 250 ) NULL ,
    `html_keywords` VARCHAR( 250 ) NULL ,
    `edit_comment` VARCHAR( 100 ) NULL
    ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class Manime extends ActiveRecord
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
        return 'anime';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('headline, url', 'length', 'max' => 100),

            array('description', 'length', 'max' => 2000),

            array('date_create', 'default', 'value' => time()),

            array('section', 'in', 'range' => ManimeSection::getList('id')),

            array('html_title, html_description, html_keywords', 'length', 'max' => 250),

            array('edit_comment', 'length', 'max' => 50),
        );
    }

    /**
     * @see ActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'headline' => 'Заголовок',
            'url' => 'Url-адрес',
            'description' => 'Описание',
            'section' => 'Раздел',
            'author' => 'Автор',
            'date_create' => 'Дата добавления',
            'html_title' => 'Title (meta)',
            'html_description' => 'Description (meta)',
            'html_keywords' => 'Key words (meta)',
            'edit_comment' => 'Комментарий к изменениям',
        );
    }

    /**
     * @see ActiveRecord::attributeNotes()
     */
    public function attributeNotes()
    {
        return array(
            'headline' => 'До 100 символов',
            'description' => 'До 2000 символов',
            'html_title' => 'До 250 символов',
            'html_description' => 'До 250 символов',
            'html_keywords' => 'До 250 символов',
            'edit_comment' => 'До 50 символов',
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'rAuthor' => array(
                self::BELONGS_TO,
                'MUser',
                'author',
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

        // Заменяем пустые поля на NULL
        if(empty($this->description)) $this->description = new CDbExpression('NULL');
        if(empty($this->html_title)) $this->html_title = new CDbExpression('NULL');
        if(empty($this->html_description)) $this->html_description = new CDbExpression('NULL');
        if(empty($this->html_keywords)) $this->html_keywords = new CDbExpression('NULL');
        if(empty($this->edit_comment)) $this->edit_comment = new CDbExpression('NULL');

        $this->date_create = strtotime($this->date_create);

        return true;
    }

    /**
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        if(!empty($this->date_create))
            $this->date_create = date('d.m.Y', $this->date_create);
    }
}