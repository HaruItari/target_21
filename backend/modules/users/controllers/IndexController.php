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
     * Добавление новой группы пользователей.
     * @return void
     */
    public function actionAddGroup()
    {
        $group = new MUserGroup();
        $group->scenario = 'addGroup';

        $this->performAjaxValidation($group);

        if(isset($_POST['MUserGroup'])) {
            $group->attributes = $_POST['MUserGroup'];

            if($group->save())
                $this->redirect(Yii::app()->createUrl('users/index/index'));
        }

        $this->render('addGroup', array(
            'group' => $group,
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
                'count(rUser.id) AS countUsers',
            ))
            ->from(array(
                'user_group AS t'
            ))
            ->leftjoin('user AS rUser', 't.id = rUser.group')
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
        switch(mb_strtolower($this->action->id)) {
            case 'index' :
                if(!Yii::app()->user->checkAccess('user_access_cms'))
                    $this->redirect(Yii::app()->user->loginUrl);

                break;

            case 'addgroup' :
                if(!Yii::app()->user->checkAccess('user_add_group'))
                    $this->redirect(Yii::app()->user->loginUrl);

                break;
        }
    }
}