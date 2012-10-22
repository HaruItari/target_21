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
    }

    /**
     * @see Controller::createPageParame()
     */
    protected function createPageParams()
    {

    }
}