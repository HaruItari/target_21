<?php
/**
 * Базовый класс ActiveRecord.
 */
abstract class ActiveRecord extends CActiveRecord
{
	/**
	 * Возвращает список примечаний для полей формы.
     * @return array Массив с примечаниями. Подобно {@link CActiveRecord::attributeLabels()}
     * @abstract
	 */
	abstract public function attributeNotes();

	/**
	 * Возвращает примечание для указанного аттрибута.
	 * @param string $attribute Аттрибут
	 * @return string Строка примечания
	 */
	public function getAttributeNote($attribute)
	{
		$attributesList = $this->attributeNotes();

		return $attributesList[$attribute];
	}

    /**
     * Конвертация bb-кодов в html-эквиваленты.
     * Метод валидации.
     * ВНИМАНИЕ: указывается в самом конце списка rules !
     * @param string $attribute
     * @param array $params
     * @return void
     */
    public function bbConvert($attribute, $params)
    {
        if(!$this->hasErrors()) {
            $this->$attribute = LBbCode::bbToHtml($this->$attribute, 'full');
        }
    }
}