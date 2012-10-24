<?php
/**
 * Выводит аватар пользователя.
 * Если аватар не найден, выводит аватар по умолчанию.
 */
class WUserAvatar extends Widget
{
    /**
     * Id пользователя.
     * @var int
     */
    public $id;

    /**
     * @see CWidget::run()
     */
    public function run()
    {
        $userAvatar = Yii::app()->controller->module->getParams()->avatarsDir . DIRECTORY_SEPARATOR . $this->id . '.jpg';
        $userAvatarHtml = Yii::app()->controller->module->getParams()->avatarsDirHtml . DIRECTORY_SEPARATOR . $this->id . '.jpg';

        $defaultAvaHtml = Yii::app()->controller->module->getParams()->defaultAvatarHtml;

        if(file_exists($userAvatar)) {
            ?><img src="<?php echo $userAvatarHtml; ?>" alt="" class="user-avatar" /><?php
        } else {
            ?><img src="<?php echo $defaultAvaHtml; ?>" alt="" class="user-avatar" /><?php
        }
    }
}