<?php
/**
 * Библиотека функций для работы с датой и временем.
 * Входит в состав Библиотеки глобальных функций.
 * @auhot Пикаев Вкитор <target417@gmail.com>
 * @since 2.0
 */
class LDateTime
{
	/**
	 * Человекопонятная дата.
	 * @param string $date Дата формата YYY-MM-DD [HH-MM-SS]
	 * @param boolen $showTime Вывод времени
	 * @param boolen $showSeconds Вывод секунд
     * @param string $format Вормат вывода даты:
     * - 1 dd {fullMonthName} yyyy [hh:mm[:ss]]
     * - 2 dd {shortMonthName} yyyy [hh:mm[:ss]]
     * - 3 dd.mm.yyyy [hh:mm[:ss]] ($alwaysFull - принудительно true)
     * @param bool $alwaysFull Всегда полная дата (без сокращений ближайших дней)
	 * @return string or boolen
	 */
	public static function formatDate($date, $showTime = false, $showSeconds = false, $format = 2, $alwaysFull = false)
	{
        // Провяем корректность переданой даты.
        if(preg_match("/^\d\d\d\d-\d\d-\d\d( \d\d:\d\d:\d\d){0,1}$/", $date) === 0)
            return false;

        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);

        if($format === 3)
            $alwaysFull = true;

        // Формируем названия месяцев.
        switch($format) {
            case 1:
                $monthList = array(
                    '01'=>'Января',
                    '02'=>'Февраля',
                    '03'=>'Марта',
                    '04'=>'Апреля',
                    '05'=>'Мая',
                    '06'=>'Июня',
                    '07'=>'Июля',
                    '08'=>'Августа',
                    '09'=>'Сентября',
                    '10'=>'Октября',
                    '11'=>'Ноября',
                    '12'=>'Декабря',
                );
                break;

            case 2:
                $monthList = array(
                    '01'=>'Янв',
                    '02'=>'Фев',
                    '03'=>'Мар',
                    '04'=>'Апр',
                    '05'=>'Май',
                    '06'=>'Июн',
                    '07'=>'Июл',
                    '08'=>'Авг',
                    '09'=>'Сен',
                    '10'=>'Окт',
                    '11'=>'Ноя',
                    '12'=>'Дек',
                );
                break;
            case 3:
                $monthList = array(
                    '01'=>'01',
                    '02'=>'02',
                    '03'=>'03',
                    '04'=>'04',
                    '05'=>'05',
                    '06'=>'06',
                    '07'=>'07',
                    '08'=>'08',
                    '09'=>'09',
                    '10'=>'10',
                    '11'=>'11',
                    '12'=>'12',
                );
                break;
        }

        // Если разрешено, формируем короткий вариант ближайшей даты.
        if($alwaysFull == false) {
            $now = date("Y-m-d H:i:s");
            $nowYear = substr($now, 0, 4);
            $nowMonth = substr($now, 5, 2);
            $nowDay = substr($now, 8, 2);

            // Если сегодня...
            if($nowYear.$nowMonth.$nowDay == $year.$month.$day)
                $return = 'Сегодня';
            // Если вчера...
            else if($nowYear.$nowMonth.$nowDay == $year.$month.($day-1))
                $return = 'Вчера';
            // Если позавчера...
            else if($nowYear.$nowMonth.$nowDay == $year.$month.($day-2))
                $return = 'Позавчера';
        }

        // Если дата не была сформированна, формируем полную дату.
        if(!$return) {
            switch($format) {
                case 1:
                    $return = $day . ' ' . $monthList[$month] . ' ' . $year;
                    break;
                case 2:
                    $return = $day . ' ' . $monthList[$month] . ' ' . $year;
                    break;
                case 3:
                    $return = $day . '.' . $monthList[$month] . '.' . $year;
                    break;
            }
        }

        // Добавляем время.
        if($showTime === true) {
            $hour = substr($date, 11, 2);
            $minit = substr($date, 14, 2);
            $return .= ' в '.$hour.':'.$minit;

            if($showSeconds === true) {
                $second = substr($date, 17, 2);
                $return .= ':'.$second;
            }
        }

        // Возвращаем результат
        return $return;
    }
}