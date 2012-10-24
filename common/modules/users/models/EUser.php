<?php
/**
 * Пользователь (сущность).
 */
class EUser extends Essence
{
    /**
     * Логин.
     * @var string
     */
    public $login;

    /**
     * Id.
     * @var int
     */
    public $id;

    /**
     * Имя.
     * @var string
     */
    public $name;

    /**
     * Пол.
     * @var string
     */
    public $sex;

    /**
     * Дата рождения.
     * @var string
     */
    public $birthday;

    /**
     * Дата регистрации.
     * @var string
     */
    public $dateReg;

    /**
     * Последнее посещение.
     * @var string
     */
    public $lastOnline;


    /**
     * Имя группы.
     * @var string
     */
    public $groupName;

    /**
     * Стиль группы.
     * @var string
     */
    public $groupStyle;

    /**
     * @see Essence::__construct()
     */
    public function __construct($class = __CLASS__)
    {
        parent::__construct($class);
    }

    /**
     * Выводит на экран логин пользователя.
     * @return void
     */
    public function getLogin()
    {
        echo '<span class="user-login">' . $this->login . '</span>';
    }

    /**
     * Выводит на экран имя пользователя.
     * @return void
     */
    public function getName()
    {
        echo '<span class="user-name">' . $this->name . '</span>';
    }

    /**
     * Выводит на экран пол пользователя.
     * @return void
     */
    public function getSex()
    {
        echo '<span class="user-sex">' . $this->sex . '</span>';
    }

    /**
     * Выводит на экран группу пользователя.
     * @return void
     */
    public function getGroup()
    {
        if(isset($this->groupStyle))
            $str = '<span class="user-group" style="' . $this->groupStyle . '">';
        else
            $str = '<span class="user-group">';

        $str .= $this->groupName . '</span>';

        echo $str;
    }

    /**
     * Выводит на экран дату рождения пользователя.
     * @return void
     */
    public function getBirthday()
    {
        $str = '<span class="user-birthday">';

        if(isset($this->birthday))
            $str .= date('d.m.Y', $this->birthday);
        else
            $str .= 'Не указан';

        $str .= '</span>';

        echo $str;
    }

    /**
     * Выводит на экран дату регистрации пользователя.
     * @return void
     */
    public function getDateReg()
    {
        echo '<span class="user-datereg">' . $str .= date('d.m.Y', $this->dateReg) . '</span>';
    }

    /**
     * Выводит на экран дату последнего посещения пользователя.
     * @return void
     */
    public function getLastOnline()
    {
        echo '<span class="user-lastonline">' . $str .= date('d.m.Y', $this->lastOnline) . '</span>';
    }
}