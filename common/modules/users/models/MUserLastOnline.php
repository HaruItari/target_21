<?php
/**
 * Дата последнего посещения сайта пользоателем.
 *
   CREATE TABLE `user_last_online` (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `user` INT UNSIGNED NOT NULL ,
   `last_online` datetime NOT NULL
   ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MUserLastOnline extends ActiveRecord
{
    /**
     * @see CActiveRecord::model()
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @see CActiverecord::tebleName()
     */
    public function tableName()
    {
        return 'user_last_online';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('last_online', 'default', 'value' => new CDbExpression('NOW()')),
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
}