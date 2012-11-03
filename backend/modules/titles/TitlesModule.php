<?php
/**
 * Модуль каталога релизов.
 *
 * @author Хару Итари <HaruItari@gmail.com>
 * @version 1.0 beta
 */
class TitlesModule extends WebModule
{
	public function init()
	{
		$this->setImport(array(
			'common.modules.titles.components.*',

			'common.modules.titles.models.*',
		));

        // Инициализация переменных.
        $this->setParams(array(
            // время кэширования.
            'cacheTime' => array(

            ),
        ));
    }
}