<?php
/**
 * Модуль каталога релизов.
 *
 * @author Хару Итари <HaruItari@gmail.com>
 * @version 1.0 beta
 */
class AnimeModule extends WebModule
{
	public function init()
	{
		$this->setImport(array(
			'common.modules.anime.components.*',

			'common.modules.anime.models.*',
		));

        // Инициализация переменных.
        $this->setParams(array(
            // время кэширования.
            'cacheTime' => array(

            ),
        ));
    }
}