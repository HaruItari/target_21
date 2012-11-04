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
    `edit_comment` VARCHAR( 100 ) NULL ,
    `age_limit` VARCHAR( 5 ) NULL ,
    ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MTitle extends ActiveRecord
{
    /**
     * Обложка релиза.
     * @var file
     */
    public $cover;

    /**
     * Файлы скриншотов.
     * var file
     */
    public $screen;

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

            array('section', 'in', 'range' => MTitleSection::model()->getList('all', 'id')),

            array('edit_comment', 'length', 'max' => 50),

            array('author', 'default', 'value' => Yii::app()->user->id),

            array('date_create', 'default', 'value' => time()),

            array('age_limit', 'length', 'max' => 5),

            array('cover', 'ImageValidator',  'minWidth' => 300, 'minHeight' => 500, 'mime' => array('image/jpg', 'image/jpeg'), 'safe' => false),

            array('screen', 'ImageValidator',  'minWidth' => 300, 'minHeight' => 500, 'mime' => array('image/jpg', 'image/jpeg'), 'safe' => false),



            // Редактирвоание релизов
            array('headline, section', 'required', 'on' =>'edit'),
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
            'age_limit' => 'Возрастное ограничение',
            'cover' => 'Обложка',
            'screens' => 'Скриншоты',
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
        $this->age_limit = (empty($this->age_limit)) ? new CDbExpression('NULL') : Lstring::safeText($this->age_limit);
        $this->headline =     Lstring::safeText($this->headline);
        $this->date_create =  strtotime($this->date_create);
        if(empty($this->url))
            $this->url = LString::translit($this->headline);

        return true;
    }

    /**
     * @see CActiveRecord::afterSave()
     */
    protected function afterSave()
    {
        /**
         * Сохраняем обложку.
         */
        if($cover = CUploadedFile::getInstance($this, 'cover')) {
            // Задаем директории обложки.
            $coverDir = Yii::app()->controller->getModule()->getParams()->coversDir . DIRECTORY_SEPARATOR . date('Ym'). DIRECTORY_SEPARATOR;
            $coverDirBig = $coverDir . $this->id . '_big.jpg';
            $coverDirSmall = $coverDir . $this->id . '_small.jpg';

            // Если директория не существует, создаем ее.
            if(!file_exists($coverDir))
                mkdir($coverDir);

            // Сохраняем обложку.
            $this->cover = $cover;
            $this->cover->saveAs($coverDirBig);
            LImage::resizeImage($coverDirSmall, $coverDirBig, 'in', array(240, 340));
        }

        /**
         * Сохраняем скриншоты.
         */
        for($i = 0; $i < 4; $i++) {
            // Задаем директории скриншотов.
            $screensDir = Yii::app()->controller->getModule()->getParams()->screensDir . DIRECTORY_SEPARATOR . date('Ym'). DIRECTORY_SEPARATOR;
            $screensDirBig = $screensDir . $this->id . '_' . $i . '_big.jpg';
            $screensDirSmall = $screensDir . $this->id . '_' . $i . '_small.jpg';

            // Если директория не существует, создаем ее.
            if(!file_exists($screensDir))
                mkdir($screensDir);

            // Сохраняем скриншот.
            if($screen = CUploadedFile::getInstance($this, 'screen[' . $i . ']')) {
                $this->screen = $screen;
                $this->screen->saveAs($screensDirBig);
                LImage::resizeImage($screensDirSmall, $screensDirBig, 'in', array(240, 340));;
            }
        }
    }

    /**
     * @see CActiveRecord::afterFind()
     */
    protected function afterFind()
    {
        $this->date_create = date('d.m.Y', $this->date_create);
        $this->description = LBbCode::htmlToBb($this->description);
        $this->headline = LString::safeText($this->headline, true);
        $this->age_limit = Lstring::safeText($this->age_limit, true);
    }
}