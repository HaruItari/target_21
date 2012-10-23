<?php
/**
 * Пользователи. Расширеная таблица.
 *
   CREATE TABLE `user_full` (
   `id` INT UNSIGNED NOT NULL ,
   `email` VARCHAR( 100 ) NOT NULL ,
   `email_confirm` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' ,
   `name` VARCHAR( 25 ) NULL ,
   `sex` ENUM( 'Мужской', 'Женский' ) NULL ,
   `birthday` DATE NULL ,
   `date_reg` DATETIME NOT NULL ,
   PRIMARY KEY ( `id` )
   ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MUserFull extends ActiveRecord
{
    /**
     * Список полов.
     * @var array
     */
    public $sexList = array(
        'Мужской' => 'Мужской',
        'Женский' => 'Женский',
    );

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
        return 'user_full';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('email', 'length', 'max' => 100),
            array('email', 'match', 'pattern' => '/^[a-z0-9\-_\.]+@[a-z0-9\-_\.]+.[a-z]{2,5}$/iu'),

            array('name', 'length', 'max' => 25),
            array('name', 'match', 'pattern' => '/^([а-яa-z0-9 _\-]+)$/iu'),

            array('sex', 'in', 'range' => array('Мужской', 'Женский')),

            array('birthday', 'match', 'pattern' => '/^\d\d\d\d-\d\d-\d\d$/'),

            array('date_reg', 'default', 'value' => new CDbExpression('NOW()')),

            // Регистрация нового пользователя.
            array('email', 'required', 'on' => 'registration'),
            array('email', 'unique', 'on' => 'registration'),
        );
    }

    /**
     * @see ActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'sex' => 'Пол',
            'birthday' => 'День рождения',
            'email' => 'E-mail',
        );
    }
    /**
     * @see ActiveRecord::attributeNotes()
     */
    public function attributeNotes()
    {
        return array(
            'name' => 'До 25 символов.',
            'sex' => '',
            'birthday' => 'В формате гггг-мм-дд',
            'email' => 'Адрес электронной почты',
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
                'MUser',
                'di',
            ),
        );
    }
}