<?php
/**
 * Библиотека функций для работы с bb-кодами.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 2.0
 */
class LBbCode
{
	/**
	 * Массив с базовым набором пар bb-код - html-тэг.
	 * @var array
	 */
	static public $base = array(
		'bb'=>array(
			'reg'=>array(
				0=>"/\[b\](.*?)\[\/b\]/si",
				1=>"/\[i\](.*?)\[\/i\]/si",
				2=>"/\[u\](.*?)\[\/u\]/si",
			),
			'code'=>array(
				0=>"[b]\${1}[/b]",
				1=>"[i]\${1}[/i]",
				2=>"[u]\${1}[/u]",
			),
		),
		'html'=>array(
			'reg'=>array(
				0=>"/<span style=\"font-weight: bold;\">(.*?)<\/span>/si",
				1=>"/<span style=\"font-style: italic;\">(.*?)<\/span>/si",
				2=>"/<span style=\"text-decoration: underline;\">(.*?)<\/span>/si",
			),
			'code'=>array(
				0=>"<span style=\"font-weight: bold;\">\${1}</span>",
				1=>"<span style=\"font-style: italic;\">\${1}</span>",
				2=>"<span style=\"text-decoration: underline;\">\${1}</span>",
			),
		)
	);

	/**
	 * Массив с расширенным набором пар bb-код - html-тэг.
	 * @var array
	 */
	static public $full = array(
		'bb'=>array(
			'reg'=>array(

			),
			'code'=>array(

			),
		),
		'html'=>array(
			'reg'=>array(

			),
			'code'=>array(

			),
		)
	);

	/**
	 * Передвод bb-кодов в их html аналоги.
	 * @param string $text Входная строка, подлежащая обработке
	 * @param string $type Тип обработки:
	 * - "base" - Базовая
	 * - "full" - Продвинутая
	 * @return string Обработанная строка
	*/
	static public function bbToHtml($text, $type = 'base')
	{
		$text = trim($text);
		$text = preg_replace("/<br \/>/", "\n", $text);
		$text = htmlspecialchars($text);

		if($type == 'base' || $type == 'full')
			$text =  preg_replace(self::$base['bb']['reg'], self::$base['html']['code'], $text);

		if($type == 'full')
			$text =  preg_replace(self::$full['bb']['reg'], self::$full['html']['code'], $text);

		$text =  preg_replace("/\\n/", "<br />", $text);

		return $text;
	}

	/**
	 * Передвод html-тэгов в их bb аналоги.
	 * @param string $text Входная строка, подлежащая обработке
	 * @return string Обработанная строка
	 */
	static public function htmlToBb($text)
	{
		$text = trim($text);
		$text =  preg_replace("/\\n/", "<br />", $text);

		$text =  preg_replace(self::$base['html']['reg'], self::$base['bb']['code'], $text);
		$text =  preg_replace(self::$full['html']['reg'], self::$full['bb']['code'], $text);

		$text = htmlspecialchars_decode($text);
		$text = preg_replace("/<br \/>/", "\n", $text);

		return $text;
	}
}