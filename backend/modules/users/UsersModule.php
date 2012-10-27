<?php
/**
 * Модуль пользовательского функционала.
 *
 * @author Хару Итари <HaruItari@gmail.com>
 * @version 1.0 beta
 */
class UsersModule extends WebModule
{
	public function init()
	{
		$this->setImport(array(
			'common.modules.users.components.*',

			'common.modules.users.models.*',
		));

        // Инициализация переменных.
        $this->setParams(array(
            // Место расположения аватаров пользователей.
            'avatarsDir' => Yii::getPathOfAlias('media') . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'avatars',
            'avatarsDirHtml' => '/media/users/avatars',

            'defaultAvatar' => Yii::getPathOfAlias('media') . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . 'default.png',
            'defaultAvatarHtml' => '/media/users/avatars/default.png',

            // время кэширования.
            'cacheTime' => array(
                
            ),
        ));
    }
}