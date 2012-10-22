<?php
/**
 * Навигация по страницам.
 * Класс, ответсвенный за создание списка страниц.
 */
class LinkPager extends CLinkPager 
{
	/**
	 * @var string the text label for the next page button. Defaults to 'Next &gt;'.
	 */
	public $nextPageLabel = '&gt;';
	
	/**
	 * @var string the text label for the previous page button. Defaults to '&lt; Previous'.
	 */
	public $prevPageLabel = '&lt;';
	
	/**
	 * @var string the text label for the first page button. Defaults to '&lt;&lt; First'.
	 */
	public $firstPageLabel = '&laquo;';
	
	/**
	 * @var string the text label for the last page button. Defaults to 'Last &gt;&gt;'.
	 */
	public $lastPageLabel = '&raquo;';
	
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to page: '.
	 */
	public $header = '';
	
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer = '';
	
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile = false;
	
	/**
	 * @var integer maximum number of page buttons that can be displayed. Defaults to 10.
	 */
	public $maxButtonCount=10;
}