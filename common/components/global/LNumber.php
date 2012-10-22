<?php
/**
 * Библиотека функций работы с числами.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 2.0
 */
class LNumber
{
	/**
	 * Случайное число для указанного типа переменных.
	 * @param strins $size Колличество цифр в результате. От 1 до 10.
     * если указанно иное значение, вернет случайное число.
	 * @return int Сгенрированное число
	 */
	static public function generateNumber($size = null)
	{
        if($size !== null) {
            if((1 <= $size) && ($size <= 10)) {
                $min = '1';
                $max = '9';

                for($i = 1; $i < $size; $i++) {
                    $min .= '0';
                    $max .= '9';
                }

                return rand($min, $max);
            }
        }

        return rand();
	}
}