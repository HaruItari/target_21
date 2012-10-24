<?php
/**
 * Основной функциона пользователя (регистрация, вход.выход, редактирование личных данных и т.п.).
 */
class IndexController extends FrontController
{
    /**
     * Регистрация нового пользователя.
     * @retrn void
     */
    public function actionRegistration()
    {
        $user = new MUser();
        $userFull = new MUserFull();
        $user->scenario = $userFull->scenario = 'registration';

        $this->performAjaxValidation(array($user, $userFull));

        if(isset($_POST['MUser']) && isset($_POST['MUserFull'])) {
            $user->attributes = $_POST['MUser'];
            $userFull->attributes = $_POST['MUserFull'];

            if($this->multipleValidate(array($user, $userFull))) {
                $user->password = $user->passwordCript($user->password);
                $user->save(false);

                $userFull->id = $user->id;
                $userFull->save(true);

                $lastOnline = new MUserLastOnline();
                $lastOnline->user = $user->id;
                $lastOnline->save();

                $this->checkEmail($user->id, $userFull->email);

                // Сразу входим в систему.
                $user->attributes = $_POST['MUser'];
                $user->scenario = 'login';
                $user->validate();

                Yii::app()->user->setFlash('user_registration_success', 'Вы были успешно зарегистрированы на сайте. В ближайшее время на указанный email придет письмо для подтверждения адреса.');

                $this->redirect(Yii::app()->createUrl('users/index/profile'));
            }
        }

        $this->render('registration', array(
            'user' => $user,
            'userFull' => $userFull,
        ));
    }

    /**
     * Вход в систему.
     * @return void
     */
    public function actionLogin()
    {
        $user = new MUser();
        $user->scenario = 'login';

        $this->performAjaxValidation($user);

        if(isset($_POST['MUser'])) {
            $user->attributes = $_POST['MUser'];

            if($user->validate())
                $this->redirect(Yii::app()->homeUrl);
        }

        $this->render('login', array(
            'user' => $user,
        ));
    }

    /**
     * Выход из системы.
     * @return void
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Просмотр профиля пользователя.
     * @param int $id Id пользователя, чей профиль просматривается.
     * Если не передан - загружается профиль авторизированного пользователя.
     * @return void
     */
    public function actionProfile($id = null)
    {
        // Если это профиль текущего пользователя, кэширование не начинаем.
        if(Yii::app()->user->id == $id) {
            $this->render('profile', array(
                'user' => $this->loadUserData($id),
            ));

        // Если профиль не принадлежит текущему пользователю, начинаем кэширование.
        } else {
            if($this->beginCache('userProfile', array(
                'cacheID' => 'memCache',
                'duration' => $this->module->getParams()->cacheTime['profile'],
                'varyByParam' => array(
                    'id',
                ),
            ))) {
                $this->render('profile', array(
                    'user' => $this->loadUserData($id),
                ));

                $this->endCache();
            }
        }
    }

    /**
     * Востановление забытого пароля.
     * Если email был подтвержден, высылает сообщение с новым паролем.
     * @return void
     */
    public function actionRestorePassword()
	{
		$user = new MUser();
		$user->scenario = 'restorePassword';

        $this->performAjaxValidation($user);

		if(isset($_POST['MUser'])) {
			$user->attributes = $_POST['MUser'];

			if($user->validate()) {
                // Запоминаем адрес почты, переданный из модели в поле пароля.
                $email = $user->password;

				$newPassword = LString::generateString(10);

                Yii::app()->db->createCommand("
                    UPDATE user SET password = '{$user->passwordCript($newPassword)}'
                    WHERE id = {$user->id}
                ")->execute();

				$this->redirect(Yii::app()->createUrl('users/index/restorePasswordOk'));
			}
		}

		$this->render('restorePassword', array(
			'user' => $user,
		));
	}

    /**
     * Востановление забытого пароля (окончание).
     * @see self::actionRestorePassword()
     * @return void
     */
    public function actionRestorePasswordOk()
    {
        $this->render('restorePasswordOk');
    }

    /**
     * Подтверждение e-mail адреса.
     * Переход на страницу осуществляется из письма.
     * @param int $user Id пользователя
     * @param int $solt Соль дял проверки
     * @return void
     */
    public function actionEmailConfirm($user, $solt)
	{
		$user = (int)$_GET['user'];
		$solt = (int)$_GET['solt'];

        $record = $sql = Yii::app()->db->createCommand("
            SELECT
                t.id,
                t.user,
                t.email
            FROM
                user_confirm_email AS t
            WHERE
                t.user = {$user}
            AND t.solt = {$solt}
        ")->queryRow();

        if(isset($record) && $record != null) {
            // Удаляем запись из вспомогательной таблицы.
            Yii::app()->db->createCommand("
                DELETE FROM user_confirm_email WHERE id = {$record['id']}
            ")->execute();

            // Активируем пользователя и обновляем адрес.
            Yii::app()->db->createCommand("
                UPDATE user_full SET email_confirm = 1, email = '{$record['email']}' WHERE id = {$record['user']}
            ")->execute();

            Yii::app()->user->setFlash('user_confirm_email_success', 'Ваш email был успешно подтвержден.');

            $this->redirect(Yii::app()->homeUrl);
        } else {
            throw new CHttpException(404, self::EXC_WRONG_ADDRESS);
        }
	}

    /**
     * Загрузка информации о пользователе.
     * @param int $id Id пользователя
     * @return array
     */
    protected function loadUserData($id)
    {
        $sql = Yii::app()->db->createCommand()
            ->select(array(
                't.id',
                't.login',
                'rFull.date_reg AS dateReg',
                'rFull.birthday',
                'rFull.sex',
                'rFull.name',
                'rGroup.group AS groupName',
                'rGroup.style AS groupStyle',
                'rLastOnline.last_online AS lastOnline',
            ))
            ->from(array(
                'user AS t',
            ))
            ->leftJoin('user_full AS rFull', 't.id = rFull.id')
            ->leftJoin('user_group AS rGroup', 't.group = rGroup.id')
            ->leftJoin('user_last_online AS rLastOnline', 't.id = rLastOnline.user')
            ->where('t.id = :id AND t.is_remove = 0', array(':id' => $id))
            ->limit(1);

        if(!$user = $sql->queryRow())
            throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

        return $user;
    }

    /**
     * Проверка существования указанного e-mail адреса.
     * @param int $userId Id пользователя, меняющего email
	 * @param string $email Проверяемый адрес
	 * @return void
	 */
	protected function checkEmail($userId, $email)
	{
        $record = new MUserConfirmEmail();
		$record->user = $userId;
		$record->email = $email;
		$record->solt = LNumber::generateNumber();
		$record->save();
	}

    /**
     * @see Controller::createPageParams()
     */
    protected function createPageParams()
    {
        switch($this->action->id) {
            case 'registration' :
                if(!Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->baseUrl);

                break;

            case 'login' :
                if(!Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->baseUrl);

                break;

            case 'profile' :
                if(!empty($_GET['id'])) {
                    $_GET['id'] = (int)$_GET['id'];
                } else {
                    if(!Yii::app()->user->isGuest)
                        $_GET['id'] = Yii::app()->user->id;
                    else
                        throw new CHttpException(404, self::EXC_WRONG_ADDRESS);
                }

                break;

            case 'restorePassword' :
                if(!Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->baseUrl);

                break;
        }
    }
}
