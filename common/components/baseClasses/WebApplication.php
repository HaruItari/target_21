<?php
/*
 * Базовый класс всего приложения.
 */
class WebApplication extends CWebApplication
{
    /**
     * Создание ulr-ссылки на frontend-часть системы.
     * Подобно {@link CApplication::createUrl()}
     * @param string $rout Строка с url-путем
     * @param array $params GET-переменные, которые необходимо включить в адрес
     * @param strings $ampersand Символ-разделитель GET-переменных
     * @return string Строка с url-адресом
     */
    public function createFrontUrl($route, $params=array(), $ampersand='&')
    {
        return FRONTEND_URL . substr($this->getUrlManager()->createUrl($route,$params,$ampersand), 12);
    }

    /**
     * Создание ulr-ссылки на backend-часть системы.
     * Подобно {@link CApplication::createUrl()}
     * @param string $rout Строка с url-путем
     * @param array $params GET-переменные, которые необходимо включить в адрес
     * @param strings $ampersand Символ-разделитель GET-переменных
     * @return string Строка с url-адресом
     */
    public function createBackUrl($route, $params=array(), $ampersand='&')
    {
        return BACKEND_URL . substr($this->getUrlManager()->createUrl($route,$params,$ampersand), 12);
    }
}