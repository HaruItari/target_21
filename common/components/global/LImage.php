<?php
/**
 * Библиотека функций для работы с изображениями.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 1.0
 */
class LImage
{
	/**
	 * Изменение размера изображения.
	 * @param string $outFile  Файл, в который будет сохранено получившиеся изображение
	 * @param string $inFile  Файл, с исходным изображением
	 * @param string $resizeType  Тип пересчета размеров:
	 * - "abs" Абсолютное задание размеров нового изображения
	 * - "rel" Задание размеров нового изображения в процентах от исходного
	 * - "in" Новое изображение будет вписанно в заданные размеры
	 * @param array $size размеры изображения (ширина, высота)
	 * - При $resizeType равном "abs' или "in" задается колличество пикселов,
	 * - При "rel" задается колличество процентов, при чем учитывается только значение ширины
	 * @param integet $quality качество получившегося изображения (0-100)
	 */
	static public function resizeImage($outFile, $inFile, $resizeType, $size, $quality = 100)
	{
		$im = imagecreatefromjpeg($inFile);

		switch($resizeType) {
			case 'abs' :
				$w = $size[0];
				$h = $size[1];
			break;

			case 'rel' :
				$w=imagesx($im) * $size[0]/100;
				$h=imagesy($im) * $size[0]/100;
			break;

			case 'in' :
				$k1=$size[0] / imagesx($im);
				$k2=$size[1] / imagesy($im);
				$k=$k1>$k2?$k2:$k1;

				$w=intval(imagesx($im) * $k);
				$h=intval(imagesy($im) * $k);
			break;
		}

		$im1 = imagecreatetruecolor($w,$h);
		imagecopyresampled($im1, $im, 0, 0, 0, 0, $w, $h, imagesx($im), imagesy($im));
		imagejpeg($im1, $outFile, $quality);
		imagedestroy($im);
		imagedestroy($im1);
	}
}