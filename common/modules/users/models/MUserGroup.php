<?php
/**
 * Список групп (ролей) пользователей.
 *
   CREATE TABLE `user_group` (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `group` VARCHAR( 25 ) NOT NULL ,
   `role` VARCHAR( 25 ) NOT NULL ,
   `style` VARCHAR( 100 ) NULL ,
   `is_default` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'
   ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MUserGroup extends ActiveRecord
{
    /**
     * Возвращает группу по умолчанию.
     * @static
     * @retunr int
     */
    static public function getDefault()
    {
        $record = MUserGroup::model()->find('t.is_default = 1');

        return $record->id;
    }

    /**
     * Возвращает список групп для выпадающего списка.
     * @return array
     */
    static public function getListForDdl()
    {
        $list = MUserGroup::model()->findAll(array(
            'order' => 't.group',
        ));

        $return = CHtml::listData($list, 'id', 'group');

        return $return;
    }

    /**
     * @see CActiveForm::model()
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
        return 'user_group';
    }

    /**
     * see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('group', 'length', 'min' => 5, 'max' => 25),
            array('group', 'match', 'pattern' => '/^[а-я0-9 \-]+$/iu'),

            array('role', 'length', 'min' => 3, 'max' => 25),
            array('role', 'match', 'pattern' => '/^[a-z0-9\_]+$/iu'),

            array('style', 'length', 'max' => 100),
            array('style', 'match', 'pattern' => '/^[^<^>]+$/iu'),

            // Добавление новой группы.
            array('group, role', 'required'),
            array('group, role', 'unique'),
        );
    }

    /**
     * @see ActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'group' => 'Группа',
            'role' => 'Роль в системе',
            'style' => 'CSS-стиль',
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
            'rUser' => array(
                self::HAS_MANY,
                'MUser',
                'group',
            ),
        );
    }
}