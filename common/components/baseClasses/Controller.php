<?php
/**
 * Базовый класс контроллера.
 */
abstract class Controller extends CController
{

    const EXC_NO_ACCESS = 'Не достаточно прав для выполнения сценария';
    const EXC_WRONG_ADDRESS = 'Неверно указан адрес страницы';

    /**
     * Формирование индивидуальных параметров страницы:
     * Формирование метатегов, подключение js- и css- файлов.
     * Так же здесь необходимо по возможности проводить все проверки прав.
     * Внутри должны описываться все actions. Если действие не нужно - указать явно (в комментарии).
     * @abstract
     * @return bool
     */
    abstract protected function createPageParams();

    /**
     * Динамичные экшены.
     * @return array
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'MathCaptcha',
            ),
        );
    }

    /**
     * Мета-тэг Title.
     * @var string
     */
    protected $_pageTitle;

    /**
     * Мета-тэг Description.
     * @var string
     */
    protected $_pageDescription;

    /**
     * Мета-тэг KeyWords.
     * @var string
     */
    protected $_pageKeyWords;

    /**
     * @see CController::beforeAction()
     */
    protected function beforeAction($action)
    {
        if(!parent::beforeAction($action))
            return false;

        $this->createPageParams();

        return true;
    }

    /**
     * Ajax валидация форм.
     * @param object $model Модель, которую надо проверить
     * @return void
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax'])) {
            echo ActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Валидация сразу нескольких моделей.
     * @param array of Model or ActiveRecord $models Массив с моделями
     * @return boolean True если все модели прошли валидацию, иначе fasle
     */
    protected function multipleValidate(array $models)
    {
        $errors = true;

        foreach($models as $model) {
            if(!$model->validate())
                $errors = false;
        }

        return $errors;
    }
}