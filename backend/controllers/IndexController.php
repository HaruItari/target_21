<?php
/**
 * Входной контроллер администраторской части.
 */
class IndexController extends BackController
{
    /**
     * Точка входа в административную часть "по умолчанию".
     */
    public function actionIndex()
    {
        echo 'Backend is started...';
        $this->render('index');
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
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * @see Controller::createPageParame()
     */
    protected function createPageParams()
    {
        switch(mb_strtolower($this->action->id)) {
            case 'login' :
                if(!Yii::app()->user->isGuest)
                    $this->redirect(Yii::app()->homeUrl);

                break;
        }
    }
}