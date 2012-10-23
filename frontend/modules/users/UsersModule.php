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
            // время кэширования.
            'cacheTime' => array(

            ),
        ));
    }
}