<?
Yii::import('zii.widgets.grid.CGridView');
Yii::import('zii.widgets.grid.CButtonColumn');
class MyGridView extends CGridView
{
	public $cssFile='/css/admin/gridstyles.css';

}

class MyButtonColumn extends CButtonColumn
{

	function __construct($grid) {
		parent::__construct($grid);

		$this->buttons=array
					(
						'view' => array
						(
							'imageUrl'=>'/images/admin/view_grid.png',
						),
						'update' => array
						(
							'imageUrl'=>'/images/admin/edit.png',
						),
						'delete' => array
						(
							'imageUrl'=>'/images/admin/del.png',
						),
					);

	}
}
?>