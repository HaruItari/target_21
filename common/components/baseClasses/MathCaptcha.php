<?php
/**
 * Математическая капча.
 * Представляет капчу в виде простого математического выажения.
 */
class MathCaptcha extends CCaptchaAction
{
    /**
     * @see CCaptchaAction::$backColor
     */
	public $backColor = 0xffffff;

    /**
     * @see CCaptchaAction::$foreColor
     */
    public $foreColor = 0x006699;

    /**
     * @see CCaptchaAction::maxLength
     */
    public $maxLength = 15;

    /**
     * @see CCaptchaAction::#minLength
     */
    public $minLength = 5;

    /**
     * @see CCaptchaAction::renderImage()
     */
	public function renderImage($code)
    {
        parent::renderImage($this->showCode($code));
    }

    /**
     * Формирует выражение для отрисовки.
     * @param string $code Текст капчи
     * @raturn string Тект математического выражения
     */
    protected function showCode($code) {
        $rand = rand(1, (int)$code-1);
        return (rand(0, 1)) ? (int)$code-$rand."+".(int)$rand : (int)$code+$rand."-".(int)$rand;
    }

    /**
     * @see CCaptchaAction::generateVerifyCode()
     */
    protected function generateVerifyCode()
    {
        return rand((int)$this->minLength, (int)$this->maxLength);
    }
}