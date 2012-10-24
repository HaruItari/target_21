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
}