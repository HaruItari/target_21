<?php
/**
 * Библиотека функций для работы с файлами и директориями.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 1.0
 */
class LDirFile
{
	/**
	 * Удаление директории и всех поддиректорий и файлов.
	 * @peram string $dirname  Полное имя директории
	 * @return bool Результат операции
	 */
	static public function deleteDir($dirname)
	{
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);

		if (!$dir_handle)
			return false;

		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				else
					LGlobal::deleteDir($dirname.'/'.$file);
			}
		}

		closedir($dir_handle);
		rmdir($dirname);

		return true;
	}

	/**
	 * Подсчет размера файлов в директории и поддиректориях.
	 * @param string $dir Директория, чей размер будет считаться
	 * @return int Размер директории в байтах
	 */
	static public function getDirSize($dir)
	{
		(int)$f_size = 0;
		$dh = opendir ($dir);

		while ($file = readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath = $dir."/".$file;

				if(!is_dir ($fullpath))
					$f_size = $f_size + filesize ($fullpath);
				else
				   $f_size += LGlobal::getDirSize($fullpath);
			}
		}
		closedir ($dh);

		return $f_size;
	}

	/**
	 * Возвращает расширение файла.
	 * @param string $file Полное имя файла
	 * @param bool $withDot Опредеяет, возвращать расширение с точкой или без
	 * @return string Расширение файла
	 */
	static public function getFileExtension($file, $withDot = true) {
		$path_info = pathinfo($file);

		if($withDot)
			return '.'.$path_info['extension'];
		else
			return $path_info['extension'];
	}
}