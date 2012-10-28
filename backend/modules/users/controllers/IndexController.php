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
        $groupsList = $this->loadgroupsList();
        $usersList = $this->loadUsersList();

        $this->render('index', array(
            'groupsList' => $groupsList,
            'usersList' => $usersList[0],
            'usersListPages' => $usersList[1],
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
     * Удаление группы пользователей.
     * @param int $id Id удаляемой группы
     * @return bool
     */
    public function actionRemoveGroup($id)
    {
        $group = Yii::app()->db->createCommand()
            ->select(array(
                't.is_default AS isDefault',
                'count(rUser.id) AS countUsers',
            ))
            ->from(array(
                'user_group AS t'
            ))
            ->leftjoin('user AS rUser', 't.id = rUser.group')
            ->group('t.id')
            ->where('t.id = :id', array(':id' => $id))
            ->limit(1)
        ->queryRow();

        if(Yii::app()->user->checkAccess('users_remove_group', $group))
            Yii::app()->db->createCommand()->delete('user_group', 'id = :id', array(':id'=>$id));

        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Редактирование профиля пользователя.
     * @param int $id Id редактируемого профиля
     * @return void
     */
    public function actionEditUser($id)
    {
        $user = MUser::model()->findByPk($id);
        $userFull = MUserFull::model()->findByPk($id);
        $user->scenario = $userFull->scenario = 'adminProfile';

        $this->performAjaxValidation(array($user, $userFull));

        if(isset($_POST['MUser']) && isset($_POST['MUserFull'])) {
            if(Yii::app()->user->checkAccess('users_edit_profile_login'))
                $user->login = $_POST['MUser']['login'];

            if(Yii::app()->user->checkAccess('users_edit_profile_group', array('id'=>$user->id)))
                $user->group = $_POST['MUser']['group'];

            if(Yii::app()->user->checkAccess('users_edit_profile_email'))
                $userFull->email = $_POST['MUserFull']['email'];
                $userFull->email_confirm = $_POST['MUserFull']['email_confirm'];

            if($this->multipleValidate(array($user, $userFull))) {
                $user->save(false);
                $userFull->save(false);

                $this->redirect(Yii::app()->createUrl('users/index/index'));
            }
        }

        $this->render('editUser', array(
            'user' => $user,
            'userFull' => $userFull,
        ));
    }

    /**
     * Удаление пользователя.
     * @param int $id Id удаляемого пользователя
     * @return void
     */
    public function actionRemoveuser($id)
    {
        $record = Yii::app()->db->createCommand()
            ->select(array(
                't.id',
                't.login'
            ))
            ->from('user AS t')
            ->where('t.id = :id', array(':id'=>$id))
            ->limit(1)
        ->queryRow();

        $user = new Euser();
        $user->attributes = $record;

        if(!empty($_POST)) {
            Yii::app()->db->createCommand()->update('user', array('is_remove'=>1), 'id = :id', array(':id'=>$id));
            $this->redirect(Yii::app()->createUrl('users/index/index'));
        } else {
            $this->render('removeUser', array(
                'user' => $user,
            ));
        }
    }

    /**
     * Загрузка из БД списка групп.
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

        return true;
    }

    /**
     * Загрузка из БД исписка пользователей.
     * @return array
     * 0=> Массив сущностей пользователя
     * 1 => Переменная страниц
     */
    protected function loadUsersList()
    {
        $sql = Yii::app()->db->createCommand()
            ->select(array(
                't.id',
                't.login',
                'rFull.date_reg AS dateReg',
                'rFull.email_confirm AS emailConfirm',
                'rLastOnline.last_online AS lastOnline'
            ))
            ->from(array(
                'user AS t'
            ))
            ->leftjoin('user_full AS rFull', 't.id = rFull.id')
            ->leftjoin('user_last_online AS rLastonline', 't.id = rLastonline.id')
            ->where('t.is_remove = 0')
            ->order('t.login');

        // Разделяем на страницы.
        $countSql = clone $sql;
        $count = $countSql->select('COUNT(t.id)')->queryScalar();
        $pages = new Pagination($count);
        $pages->pageSize = $this->module->getParams()->usersOnPage;
        $sql->limit($pages->pageSize, $pages->currentPage * $pages->pageSize);

        $list = $sql->queryAll();

        // Вормируем сущности.
        foreach($list AS $item) {
            $user = new EUser();
            $user->attributes = $item;
            $return[] = $user;
        }

        return array($return, $pages);
    }

    /**
     * @see Controller::createPageParams()
     */
    protected function createPageParams()
    {
        switch(mb_strtolower($this->action->id)) {
            case 'index' :
                if(!Yii::app()->user->checkAccess('users_access_cms'))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;

            case 'addgroup' :
                if(!Yii::app()->user->checkAccess('users_add_group'))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;

            case 'editgroup' :
                if(!empty($_GET['id']) && is_int((int)$_GET['id']))
                   $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

                if(!Yii::app()->user->checkAccess('users_edit_group'))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;

            case 'removegroup' :
                // Проверка на наличие прав роизводится в экшенепотому,
                // что необходимо знать колличество пользователей в группе.
                if(!empty($_GET['id']) && is_int((int)$_GET['id']))
                   $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);
                break;

            case 'edituser' :
                if(!empty($_GET['id']) && is_int((int)$_GET['id']))
                   $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

                if(!Yii::app()->user->checkAccess('users_edit_profile', array('id'=>$_GET['id'])))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;

            case 'removeuser' :
                if(!empty($_GET['id']) && is_int((int)$_GET['id']))
                   $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

                if(!Yii::app()->user->checkAccess('users_remove_profile', array('id'=>$_GET['id'])))
                    throw new CHttpException(404, self::EXC_NO_ACCESS);
                break;
        }
    }
}