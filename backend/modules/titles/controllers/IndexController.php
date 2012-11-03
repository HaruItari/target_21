<?php
/**
 * Управление аниме-релизами.
 */
class IndexController extends BackController
{
    /**
     * Добавление нового релиза.
     * @return void
     */
    public function actionAddAnime()
    {

    }

    /**
     * @see Controller::createPageParams()
     */
    protected function createPageParams()
    {
        switch(mb_strtolower($this->action->id)) {
            case 'addanime' :
                if(!Yii::app()->user->checkAccess('titles_add_title'))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;
        }
    }
}