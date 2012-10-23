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

            case 'restorePassword' :
                if(!Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->baseUrl);
                break;
        }
    }
}
