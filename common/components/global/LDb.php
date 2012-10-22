<?php
/**
 * Библиотека функций для работы с базой данных.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 1.0
 */
class LDb
{
	/**
	 * Подсчет размера БД.
	 * @param string $bd_host Хост БД
	 * @param string $bd_login Логин
	 * @param string $bd_parol Пароль
	 * @param string $bd_name Имя БД
	 * @return int Размер БД в байтах
	 */
	static public function getMysqlSize($bd_host, $bd_login, $bd_parol, $bd_name)
	{
        $connect = @mysql_connect($bd_host, $bd_login, $bd_parol);

        if ($connect) {
            if (@mysql_select_db($bd_name, $connect) ) {
                mysql_select_db($dbname);
                $result = mysql_query("SHOW TABLE STATUS");
                while($row = mysql_fetch_array($result))
                    $dbsize += $row[ "Data_length" ] + $row[ "Index_length" ];
                return $dbsize;
            } else {
            	return false;
			}
        } else {
			return false;
		}
	}
}