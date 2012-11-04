<?php
/**
 * Управление аниме-релизами.
 */
class IndexController extends BackController
{
    /**
     * Добавление нового релиза (аниме).
     * @return void
     */
    public function actionAddAnime()
    {
        $title = new MTitle();
        $anime = new MAnime();
        $title->scenario = $anime->scenario = 'edit';

        $this->performAjaxValidation(array($title, $anime));

        if(isset($_POST['MTitle']) && isset($_POST['MAnime'])) {
            $title->attributes = $_POST['MTitle'];
            $anime->attributes = $_POST['MAnime'];

            if($this->multipleValidate(array($title, $anime))) {
                $title->save();
                $title->url .= '-' . $title->id;
                $title->save(false);
                $anime->id = $title->id;
                $anime->save();

                $this->redirect(Yii::app()->createUrl('titles/index/index'));
            }
        }

        $this->render('editAnime', array(
            'title' => $title,
            'anime' => $anime,
        ));
    }

    /**
     * Редактирование релиза (аниме).
     * @return void
     */
    public function actionEditAnime($id)
    {
        $title = MTitle::model()->findByPk($id);
        $anime = MAnime::model()->findByPk($id);
        if(!isset($title) || !isset($anime))
            throw new CHttpException(404, self::EXC_WRONG_ADDRESS);

        if(!Yii::app()->user->checkAccess('titles_edit_own_title', array('author' => $title->author))
        && !Yii::app()->user->checkAccess('titles_edit_title'))
            throw new CHttpException(404, self::EXC_NO_ACCESS);

        $title->scenario = $anime->scenario = 'edit';

        $this->performAjaxValidation(array($title, $anime));

        if(isset($_POST['MTitle']) && isset($_POST['MAnime'])) {
            $title->attributes = $_POST['MTitle'];
            $anime->attributes = $_POST['MAnime'];

            if($this->multipleValidate(array($title, $anime))) {
                $title->save();
                $title->url .= '-' . $title->id;
                $title->save(false);
                $anime->id = $title->id;
                $anime->save();

                $this->redirect(Yii::app()->createUrl('titles/index/index'));
            }
        }

        $this->render('editAnime', array(
            'title' => $title,
            'anime' => $anime,
        ));
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

            case 'editanime' :
                // Проверка на наличе прав происходит в экшене.
                if(!empty($_GET['id']) && ((int)$_GET['id'] > 0))
                    $_GET['id'] = (int)$_GET['id'];
                else
                    throw new CHttpException(404, self::EXC_WRONG_ADDRESS);
                break;
        }
    }
}