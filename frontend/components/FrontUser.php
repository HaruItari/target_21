<?php
/**
 * Базовый класс, представляющий пользователя в пользовательской части.
 */
class FrontUser extends WebUser
{
    /**
     * @see CWebUser::init()
     */
    public function init()
    {
        parent::init();

        $this->setStateKeyPrefix('front');
    }
}