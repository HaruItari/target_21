<?php
/**
 * Базовый класс, представляющий пользователя.
 */
class WebUser extends CWebUser
{
    /**
     * @see CWebUser::getRole()
     */
    public function getRole()
    {
        if ($user = $this->getModel()) {
             return Yii::app()->db->createCommand("
                SELECT
                    t.role
                FROM
                    user_group AS t,
                    user
                WHERE
                    t.id = user.group
                AND user.id = {$this->id}
            ")->queryScalar();
        }
    }

    /**
     * Получение flash-сообщения и обрамление его в тематические блоки.
     * Перегрузка стандартного метода {@link parent::getFlash}.
     * @param string $key Ключ сообщения
     * @param string $type Тип возвращаемого значения
     * @param mixed $defaultValue Возвращаемое значение в случае отсутствия сообщения
     * @param boolean $delete Удалить сообщение после вывода
     * @return mixed or bool
     */
    public function getFlash($key, $type = null, $defaultValue = null, $delete = true)
    {
        $return = parent::getFlash($key, $defaultValue, $delete);

        if (isset($return)) {
            switch ($type) {
                case 'info' :
                    return '<div class="info">' . $return . '</div>';
                    break;

                case 'note' :
                    return '<div class="note">' . $return . '</div>';
                    break;

                case 'error' :
                    return '<div class="error">' . $return . '</div>';
                    break;

                default :
                    return $return;
                    break;
            }
        }

        return false;
    }

    /**
     * Проверка наличия flash-сообщения.
     * Перегрузка стандартного метода {@link parent::hasFlash}.
     * @param string $key Ключ сообщения
     * @return boolean Существование сообщения
     */
    public function hasFlash($key)
    {
        return $this->getFlash($key, null, null, false) !== null;
    }

    /**
     * Установка якорной страницы, на которую в дальнейшем будет возвращен пользователь.
     * @params string $url Фиксируемый адрес. Если не указан, присваивается текущая страница.
     * @return void
     */
    public function setAnchorUrl($url = null)
    {
        if($url === null)
            $url = $_SERVER['PHP_SELF'];

        $this->setState('_anchorUrl', $url);
    }

    /**
     * Возвращает адрес якорной страницы.
     * @return string
     */
    public function getAnchorUrl($url = null)
    {
        $url = $this->getState('_anchorUrl');
        $this->clearState('_anchorUrl');

        return $url;
    }

    /**
     * @see CWebUser::beforeLogin()
     */
    protected function beforeLogin($id, $states, $fromCookie)
    {
        if ($fromCookie) {
            if(!empty($states['cookiesSolt']))
                return MUser::model()->findByAttributes(array(
                    'id' => $states['id'],
                    'cookies_solt' => $states['cookiesSolt'],
                ));
            else
                return false;
        } else {
            return true;
        }
    }

    /**
     * Данные о пользователе (модель MUser).
     * @var object
     */
    private $_model = null;

    /**
     * Получение экземпляра $this->_model.
     * Если он не опреелен, создание нового.
     * @return object
     */
    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = MUser::model()->findByPk($this->id);
        }

        return $this->_model;
    }
}