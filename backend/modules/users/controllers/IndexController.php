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

            if($group->save()) {
                // Обновляем группу "по умолчанию", если требуется.
                if($group->is_default == 1)
                    $this->setDefaultGroup($group->id);

                $this->redirect(Yii::app()->createUrl('users/index/index'));
            }
        }

        $this->render('editGroup', array(
            'group' => $group,
        ));
    }

    /**
     * Редактирование группы пользователей.
     * @return void
     */
    public function actionEditGroup($id)
    {
        $group = MUserGroup::model()->findByPk($id);
        if(empty($group))
            throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

        $group->scenario = 'editGroup';

        $this->performAjaxValidation($group);

        if(isset($_POST['MUserGroup'])) {
            $group->attributes = $_POST['MUserGroup'];

            if($group->save()) {
                // Обновляем группу "по умолчанию", если требуется.
                if($group->is_default == 1)
                    $this->setDefaultGroup($group->id);

                $this->redirect(Yii::app()->createUrl('users/index/index'));
            }
        }

        $this->render('editGroup', array(
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
     * Установка новой группы "по умолчанию".
     * @param int $id Id новой группы "по умолчанию"
     * @return bool
     */
    protected function setDefaultGroup($id)
    {
        Yii::app()->db->createCommand()->update('user_group', array('is_default'=>0));
        Yii::app()->db->createCommand()->update('user_group', array('is_default'=>1), 'id = :id', array(':id'=>$id));
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

            case 'editgroup' :
                if(!Yii::app()->user->checkAccess('user_edit_group'))
                    $this->redirect(Yii::app()->user->loginUrl);

                if(!empty($_GET['id']))
                   $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

                break;
        }
    }
}