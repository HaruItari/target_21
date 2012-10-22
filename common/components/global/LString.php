<?php
/**
 * Библиотека функций работы с строками.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 1.0
 */
class LString
{
	/**
	 * Перевод первого символа строки в верхний регистр с учетом кодировки.
	 * @param string $string Входная строка
	 * @param string $code Кодировка
	 * @return string Измененная строка
	 */
	static public function upFirsChar($string, $code = 'UTF-8')
	{
		return mb_strtoupper(mb_substr($string, 0, 1, $code), $code) . mb_substr($string, 1, mb_strlen($string), $code);
	}

	/**
	 * Обработка введенных пользователем данных.
	 * Удаление лишних пробелов по краям строки и замена html сушностей знаками.
	 * @param string $text Текст для обработки
	 * @param boolean $decode Преобразование спецсимволов обратно
	 * @return string Обработанный текст
	 */
	static public function safeText($text, $decode = false)
	{
		$text = trim($text);

		if($decode)
			$text = htmlspecialchars_decode($text);
		else
			$text = htmlspecialchars($text);

		return $text;
	}

	/**
	 * Написание русского текста транслитом.
	 * @param string $text Входная строка дял транслита для адресной строки
	 * @pram bool $forUrl Тип транслита, для url или обычный
	 * @return string Строка в транслите
	 */
	static public function translit($text, $forUrl = true)
	{
		if($forUrl === true) {
			$text = strtr($text, array(
				'А'=>'a',  'Б'=>'b',  'В'=>'v',  'Г'=>'g',  'Д'=>'d',  'Е'=>'e',   'Ё'=>'e',   'Ж'=>'zh', 'З'=>'z',   'И'=>'i',
				'Й'=>'j',  'К'=>'k',  'Л'=>'l',  'М'=>'m',  'Н'=>'n',  'О'=>'o',   'П'=>'p',   'Р'=>'r',  'С'=>'s',   'Т'=>'t',
				'У'=>'u',  'Ф'=>'f',  'Х'=>'h',  'Ц'=>'c',  'Ч'=>'ch', 'Ш'=>'sh', 'Щ'=>'sch', 'Ъ'=>'',   'Ы'=>'y',   'Ь'=>'',
				'Э'=>'je', 'Ю'=>'ju', 'Я'=>'ja', 'а'=>'a',  'б'=>'b',  'в'=>'v',   'г'=>'g',   'д'=>'d',  'е'=>'e',   'ё'=>'e',
				'ж'=>'zh', 'з'=>'z',  'и'=>'i',  'й'=>'j',  'к'=>'k',  'л'=>'l',   'м'=>'m',   'н'=>'n',  'о'=>'o',   'п'=>'p',
				'р'=>'r',  'с'=>'s',  'т'=>'t',  'у'=>'u',  'ф'=>'f',  'х'=>'h',   'ц'=>'c',   'ч'=>'ch', 'ш'=>'sh', 'щ'=>'sch',
				'ъ'=>'',   'ы'=>'y',  'ь'=>'',   'э'=>'je', 'ю'=>'ju', 'я'=>'ja',  '.'=>'',    ','=>'',   '?'=>'',    '!'=>'',
				'@'=>'',   '$'=>'',   '%'=>'',   '&'=>'',   '*'=>'',   '#'=>'',    '^'=>'',    '<'=>'',   '>'=>'',    '/'=>'',
				' '=>'-',  ':'=>'',   ':'=>'',   '['=>'',   ']'=>'',   '('=>'',    ')'=>'',
			));

			$text = preg_replace('/--+/', '-', $text);
			$text = trim($text," -");
		}

        return $text;
	}

	/**
	 * Генерация случайной строки.
	 * @param int $length Колличество символов в строке
	 * @return string Сгенерированная строка
	 */
	public static function generateString($length = 10)
	{
		$chars = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
		$maxChar = strlen($chars);

		$string = '';

		for ($i = 0; $i < $length; $i++)
			$string .= substr($chars, rand(1, $maxChar) - 1, 1);

		return $string;
	}
}