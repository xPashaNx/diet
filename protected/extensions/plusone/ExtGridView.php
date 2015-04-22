<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('zii.widgets.grid.CButtonColumn');

/**
 * Class ExtGridView
 * Extended grid view
 */
class ExtGridView extends CGridView
{
	/**
	 * @var boolean
	 */
	public $enablePageSizing = true;
	
	/**
	 * @var integer Default grid page size
	 */
	public $pageSize = 10;
	
	/**
	 * @var string Default grid template
	 */
	public $template = "{sizes}\n{summary}\n{items}\n{pager}\n{sizes}";
	
	/**
	 * @var string Default grid css
	 */
	public $cssFile = '/css/admin/gridstyles.css';
	
	/**
	 * @var array Default page size ist
	 */
	public $pageSizeList = array(
		10 => 10, 
		20 => 20, 
		50 => 50
	);
	
	/**
	 * Renders page size list
	 */
	public function renderSizes()
	{
		if ($this->enablePageSizing)
		{
			echo CHtml::openTag('div', array('class' => 'grid-view-page-size'));
			echo 'Отображать по:';
			echo CHtml::dropDownList($this->id . '-page-size', $this->pageSize, $this->pageSizeList);
			echo CHtml::closeTag('div');
		}
	}
	
	/**
	 * Register client script
	 */
	public function registerClientScript()
	{
		parent::registerClientScript();
		
		if ($this->enablePageSizing)
		{
			Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->id . '-page-size', "
				$(document).on('change', '#{$this->id}-page-size', function(){
					$.fn.yiiGridView.update('{$this->id}',{data: { '{$this->id}-page-size': $(this).val()}});
					return false;
				});
			");
		}
	}
	
	/**
	 * Redeclare initialization
	 */
	public function init()
	{
		parent::init();
		
		if ($this->enablePageSizing)
		{
			if ($pageSize = Yii::app()->request->getParam($this->id . '-page-size'))
			{
				$this->pageSize = $pageSize;
				Yii::app()->session[$this->id . '-page-size'] = $this->pageSize;
			}
			elseif (isset(Yii::app()->session[$this->id . '-page-size']))
				$this->pageSize = Yii::app()->session[$this->id . '-page-size'];
				
			if ($this->dataProvider->getPagination() !== false)
				$this->dataProvider->getPagination()->setPageSize($this->pageSize);
			else
			{
				$this->dataProvider->setPagination(array(
					'class' => 'CPagination',
					'pageSize' => $this->pageSize,
				));
				$this->enablePagination = true;
			}
			
			$this->dataProvider->getData(true);
		}
	}
}

/**
 * Class ExtButtonColumn
 * Extended button column
 */
class ExtButtonColumn extends CButtonColumn
{
	/**
	 * @var string Default buttons template
	 */
	public $template = '{update}{delete}';

	/**
	 * Initialization
	 */
	public function init()
	{
		$this->buttons = CMap::mergeArray(
			$this->buttons,
			array(
				'view' => array(
					'imageUrl' => '/images/admin/view_grid.png',
				),
				'update' => array(
					'imageUrl' => '/images/admin/edit.png',
				),
				'delete' => array(
					'imageUrl' => '/images/admin/del.png',
				),
			)
		);

		parent::init();
	}
}
?>