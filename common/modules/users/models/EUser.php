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
     * Email.
     * @var string
     */
    public $email;

    /**
     * Активация email
     * @var int
     */
    public $emailConfirm;

    /**
     * @see Essence::__construct()
     */
    public function __construct($class = __CLASS__)
    {
        parent::__construct($class);
    }

    /**
     * Отрисовывает аватар пользователя.
     * @return void
     */
    public function getAvatar()
    {
        $this->widget('common.modules.users.components.widgets.WUserAvatar', array(
            'id' => $this->id,
        ));
    }

    /**
     * Выводит на экран логин пользователя.
     * @param $isLink Выводить логин в виде ссылки или текста
     * @return void
     */
    public function getLogin($isLink = true)
    {
        $str = '<span class="user-login">';

        if($isLink == true)
            $str .= '<a href="' . Yii::app()->createFrontUrl('users/index/profile', array('id'=>$this->id)) . '">' . $this->login . '</a>';
        else
            $str .= $this->login;

        $str .= '</span>';

        echo $str;
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
     * Выводит на экран имя пользователя.
     * @return void
     */
    public function getName()
    {
         $str = '<span class="user-name">';

        if(isset($this->name))
            $str .= $this->name;
        else
            $str .= 'Не указано';

        $str .= '</span>';

        echo $str;
    }

    /**
     * Выводит на экран пол пользователя.
     * @return void
     */
    public function getSex()
    {
        $str = '<span class="user-sex">';

        if(isset($this->sex))
            $str .= $this->sex;
        else
            $str .= 'Не указан';

        $str .= '</span>';

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