<?php
/**
 * Базовый класс ActiveForm.
 */
class ActiveForm extends CActiveForm
{
    /**
     * @see CActiveForm::$clientOptions
     */
	public $clientOptions = array(
		'validateOnSubmit' => true,
		'validateOnChange' => false,
		'errorCssClass' => 'error_row',
		'successCssclass' => 'success_row',
	);

	/**
	 * Возвращает примечание к полю формы.
	 * @param object $model Модель
     * @param string $attribute Аттрибут
	 * @return string Строка с примечанием
	 */
	public function note($model, $attribute)
	{
		$text = $model->getAttributeNote($attribute);

        if(isset($text))
			return '<span class="form_note">' . $text . '</span>';
	}
}