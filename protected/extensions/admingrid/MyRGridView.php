<?
Yii::import('ext.RGridView.RGridViewWidget');
Yii::import('zii.widgets.grid.CButtonColumn');
class MyRGridView extends RGridViewWidget
{
	public $cssFile='/css/admin/gridstyles.css';

    public $successOrderMessage='Порядок успешно сохранен!';
    public $buttonLabel='Сохранить порядок';

}

class MyRButtonColumn extends CButtonColumn
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