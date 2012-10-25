<?php
/**
 * Базовый контроллер администраторской части.
 */
abstract class BackController extends Controller
{
    /**
     * @see CController::beforeAction()
     */
    protected function beforeAction($action)
    {
        if(!parent::beforeAction($action))
            return false;
        
        // Проверяем, авторизирован ли пользователь.
        // Если нет, направляем на страницу авторизации.
        if(Yii::app()->user->isGuest) {
            if($this->module->id.'/'.$this->id.'/'.$action->id != '/index/login')
                $this->redirect(Yii::app()->user->loginUrl);
        } else {
            if(!Yii::app()->user->checkAccess('access_cms')) {
                Yii::app()->user->logout();
                $this->refresh();
            }
        }

        return true;
    }
}
