<?php
/**
 * Управление пользователями.
 */
class IndexController extends BackController
{
    /**
     * Главная страница модуля.
     * @return void
     */
    public function actionIndex()
    {
        $this->render('index', array(
            'groupsList' => $this->loadgroupsList(),
        ));
    }

    /**
     * Загрузка из БД списка групп пользователей.
     * @return array
     */
    protected function loadgroupsList()
    {
        $list = Yii::app()->db->createCommand()
            ->select(array(
                't.id',
                't.group',
                't.style',
                't.is_default AS isDefault',
                'count(t.id) AS countUsers',
            ))
            ->from(array(
                'user_group AS t',
                'user as rUser'
            ))
            ->where('t.id = rUser.group')
            ->group('t.id')
            ->order('t.group')
        ->queryAll();
        return $list;
    }

    /**
     * @see Controller::createPageParams()
     */
    protected function createPageParams()
    {
        switch($this->action->id) {
            case 'index' :
                if(!Yii::app()->user->checkAccess('user_access_cms'))
                    $this->redirect(Yii::app()->user->loginUrl);

                break;
        }
    }
}