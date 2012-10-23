<?php
/**
 * Пользователи. Основная таблица.
 *
   CREATE TABLE `user` (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
   `login` VARCHAR( 20 ) NOT NULL ,
   `password` VARCHAR( 32 ) NOT NULL ,
   `group` INT UNSIGNED NOT NULL ,
   `cookies_solt` INT UNSIGNED NULL ,
   `is_remove` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'
   ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
 */
class MUser extends ActiveRecord
{
    /**
     * Поле "запомнить меня".
     * @var bool
     */
    public $saveMe;

    /**
	 * Текущий пароль.
	 * @var string
	 */
	public $oldPassword;

	/**
	 * Новый пароль.
	 * @var string
	 */
	public $newPassword;

	/**
	 * повторный ввод нового пароля.
	 * @var string
	 */
	public $newPassword2;

	/**
	 * Файл аватара пользователя.
	 * @var file
	 */
	public $img;

    /**
     * Капча.
     * @var string
     */
    public $verifyCode;

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
        return 'user';
    }

    /**
     * @see CActiveRecord::rules()
     */
    public function rules()
    {
        return array(
            array('login', 'length', 'min' => 5, 'max' => 20),
            array('login', 'match', 'pattern' => '/^([a-z0-9 _\-]+|[а-я0-9 _\-]+)$/iu'),

            array('password, newPassword', 'length', 'min' => 6),

            array('is_remove', 'default', 'value' => 0),

            array('group', 'default', 'value' => MUserGroup::getDefault()),

            array('saveMe', 'numerical'),

            array('img', 'ImageValidator', 'mime' => array('image/jpg', 'image/jpeg'), 'maxWidth' => 150, 'maxHeight' => 150),

            // Регистрация нового пользователя.
            array('login, password, verifyCode', 'required', 'on' => 'registration'),
            array('login', 'unique', 'on' => 'registration'),
			array('verifyCode', 'captcha', 'allowEmpty' => !extension_loaded('gd'), 'on' => 'registration'),

            // Вход в систему.
            array('login, password', 'required', 'on' => 'login'),
			array('password', 'authenticate', 'on' => 'login'),

            // Востановление пароля.
            array('login', 'required', 'on' => 'restorePassword'),
			array('login', 'checkUserByLogin', 'on' => 'restorePassword'),
			array('verifyCode', 'captcha', 'allowEmpty' => !extension_loaded('gd'), 'on' => 'restorePassword'),

            // Редактирвоание личных данных.
			array('email', 'required', 'on' => 'editProfile'),
			array('email', 'unique', 'on' => 'editProfile'),

			array('newPassword2', 'compare', 'compareAttribute'=>'newPassword', 'on' => 'editProfile'),
			array('oldPassword', 'checkOldPassword', 'on' => 'editProfile'),
        );
    }

    /**
     * @see ActiveRecord::attributeLabels()
     */
    public function attributeLabels()
    {
        return array(
            'login' => 'Логин',
            'password' => 'Пароль',
            'group' => 'Группа',
            'theme' => 'Тема оформления',
            'is_remove' => 'Удален',
            'saveMe' => 'Запомнить меня',
            'verifyCode' => 'Код проверки',
            'img' => 'Аватар',
            'oldPassword' => 'Текущий пароль',
            'newPassword' => 'Новый пароль',
            'newPassword2' => 'Повтор пароля',
        );
    }

    /**
     * @see ActiveRecord::attributeNotes()
     */
    public function attributeNotes()
    {
        return array(
            'login' => '5-20 символов. Русские или английские буквы и цыфры.',
            'password' => 'Не меньше 5 символов.',
            'verifyCode' => 'Решите уравнение.',
            'img' => '.jpeg максимум 150x150',
            'newPassword' => 'Не меньше 6 символов.',
        );
    }

    /**
     * @see CActiveRecord::relations()
     */
    public function relations()
    {
        return array(
            'rFull' => array(
                self::HAS_ONE,
                'MUserFull',
                'id',
            ),
            'rGroup' => array(
                self::BELONGS_TO,
                'MUserGroup',
                'group',
            ),
        );
    }

    /**
	 * Ищет в БД пользоватея с указанными логином и паролем.
     * Метод валидации.
	 */
	public function authenticate()
    {
        if(!$this->hasErrors())
        {
            $identity = new UserIdentity($this->login, $this->password, $this->saveMe);
            $identity->authenticate();

            switch($identity->errorCode)  {
                case UserIdentity::ERROR_NONE:
                    Yii::app()->user->login($identity, 604800); // 60*60*24*7 = 604800
					break;

                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('login','Пользователь с указанным логином не зарегистрирован.');
					break;

                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password','Неварно указан пароль.');
					break;
            }
        }
    }

    /**
	 * Проверка правильности текущего пароля.
     * Метод валидации.
	 */
	public function checkOldPassword()
	{
		if($this->oldPassword && ($this->password != $this->passwordCript($this->oldPassword)))
			$this->addError('oldPassword', 'Неверно указан текущий пароль.');
	}

    /**
	 * Проверка наличия пользователя с указанными логином.
     * Метод валидации.
	 */
	public function checkUserByLogin()
	{
		if(!$this->hasErrors()) {
			if(!$user = MUser::model()->find('t.login = :login', array(':login' => $this->login)))
				$this->addError('login', 'Пользователь с указанным логином не существует.');
			else if(!$userFull = MUserFull::model()->find('t.id = :id AND t.email_confirm = 1', array(':id' => $user->id,)))
				$this->addError('login', 'Email адрес указанного пользователя неактивирован. Обратитесь к администрации для востановления пароля.');
            else
				$this->id = $user->id;
                // записываем email в поле "password", дял передачи в контроллер.
                $this->password = $userFull->email;
		}
	}

    /**
     * Возвращает хэш-сумму пароля.
     * @param string $password Пароль
     * @return string хэш-сумма
     */
    public function passwordCript($password)
    {
        return strrev(md5($password));
    }
}