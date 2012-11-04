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
            // Место расположения обложек релизов.
            'coversDir' => Yii::getPathOfAlias('media') . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'covers',
            'avatarsDirHtml' => '/media/titles/covers',

            // Место расположения скриншотов релизов.
            'screensDir' => Yii::getPathOfAlias('media') . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'screens',
            'screensDirHtml' => '/media/titles/screens',

            // время кэширования.
            'cacheTime' => array(

            ),
        ));
    }
}