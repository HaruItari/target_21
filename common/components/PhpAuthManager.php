<?php
/**
 * Менеджер авторизации пользователей.
 */
class PhpAuthManager extends CPhpAuthManager
{
    /**
     * @see CPhpAuthManager::init()
     */
    public function init()
    {
        if ($this->authFile === null) {
            $this->authFile = Yii::getPathOfAlias('common.config.auth') . '.php';
        }

        parent::init();

        if (!Yii::app()->user->isGuest)
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
    }

}