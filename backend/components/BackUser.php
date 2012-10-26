<?php
/**
 * Базовый класс, представляющий пользователя в администраторской части.
 */
class BackUser extends WebUser
{
    /**
     * @see CWebUser::init()
     */
    public function init()
    {
        parent::init();

        $this->setStateKeyPrefix('back');
    }
}