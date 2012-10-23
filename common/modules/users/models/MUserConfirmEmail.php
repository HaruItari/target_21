<?php
/**
 * Список подтверждаемых email.
 *
   CREATE TABLE `user_confirm_email` (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `user` INT UNSIGNED NOT NULL ,
   `email` VARCHAR( 100 ) NOT NULL ,
   `solt` INT UNSIGNED NOT NULL
   ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MUserConfirmEmail extends ActiveRecord
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
        return 'user_confirm_email';
    }

    /**
     * @see ActiveRecord::attributeNotes
     */
	public function attributeNotes()
	{
		return array(

		);
	}
}