<?php
/**
 * Входной контроллер пользовательской части.
 */
class IndexController extends FrontController
{
    /**
     * Точка входа в пользовательскую часть "по умолчанию".
     */
    public function actionIndex()
    {
        echo 'Frontend is started...';
    }

    /**
     * @see Controller::createPageParame()
     */
    protected function createPageParams()
    {

    }
}