<?php
/**
 * Базовый класс сущностей.
 * Унаследован от CController для поддержания виджетов.
 */
abstract class Essence extends CController
{
    /**
     * @see CController::__construct()
     */
    public function __construct($class)
    {
        $this->_className = $class;
        parent::__construct($class);
    }

    /**
     * Массовое присовение аттрибетов.
     * @param array of object $params Массив с параемтрами или объект AR
     * @return bool
     */
    public function setAttributes($params)
    {
        if(!is_array($params))
            return false;

       while($item = each($params)) {
           if(property_exists($this->_className, $item[0]))
                $this->$item[0] = $item[1];
       }
    }

    /**
     * Имя класса.
     */
    private $_className;
}