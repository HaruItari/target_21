<?php
/**
 * Релизы. Основная таблица.
 *
    CREATE TABLE `title` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `headline` VARCHAR( 100 ) NOT NULL ,
    `url` VARCHAR( 100 ) NOT NULL ,
    `description` VARCHAR( 2000 ) NULL ,
    `author` INT NOT NULL ,
    `section` INT NOT NULL ,
    `date_create` INT NOT NULL ,
    `edit_comment` VARCHAR( 100 ) NULL
    ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MTitle extends ActiveRecord
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
        return 'title';
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

            array('section', 'in', 'range' => MAnimeSection::model()->getList('id')),

            array('edit_comment', 'length', 'max' => 50),

            array('author', 'default', 'value' => Yii::app()->user->id),

            array('date_create', 'default', 'value' => time()),

            // Добавление нового релиза.
            array('headline, section', 'required', 'on' =>'add'),
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
        $this->description =  (empty($this->description))  ? new CDbExpression('NULL') : LBbCode::bbToHtml($this->description, 'full');
        $this->edit_comment = (empty($this->edit_comment)) ? new CDbExpression('NULL') : Lstring::safeText($this->edit_comment);
        $this->headline = Lstring::safeText($this->headline);
        $this->date_create =  strtotime($this->date_create);

        return true;
    }

    /**
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        $this->date_create = date('d.m.Y', $this->date_create);
        $this->description = LBbCode::htmlToBb($this->description);
        $this->headline = LSafeText($this->headline, true);
    }
}