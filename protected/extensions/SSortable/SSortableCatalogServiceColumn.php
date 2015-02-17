<?php

class SSortableCatalogServiceColumn extends CButtonColumn
{
	public $disableSortable = false;
	
    function __construct($grid)
    {
        parent::__construct($grid);
        if($this->disableSortable)
        {
            foreach ($grid->columns as $key=>$column)
            {
                if(is_object($column))
                    if(get_class($column)=='CDataColumn')
                        $column->sortable = false;
            }
        }

        //CVarDumper::dump($this->grid->dataProvider->getSort()->orderBy,2,true);

        $this->template = '{moveup}{movedown}';

        $imgPath = $this->publish();

        $move =<<< EOD
            function() {

                $.fn.yiiGridView.update('{$this->grid->id}', {
                    type:'POST',
                    url:$(this).attr('href'),
                    success:function() {
                        $.fn.yiiGridView.update('{$this->grid->id}');
                    }
                });

                return false;

            }
EOD;

        $this->buttons = array(
            'moveup' => array(
                'label'  => 'Вверх',
                'url'   => 'array("service/move", "method"=>"up", "id" => $data->id)',
                'imageUrl'  => $imgPath.'/up.png',
                'options' => array('class' => 'moveup'),
                'click' => $move,
            ),
            'movedown' => array(
                'label'  => 'Вниз',
                'url'   => 'array("service/move", "method"=>"down", "id" => $data->id)',
                'imageUrl'  => $imgPath.'/down.png',
                'options' => array('class' => 'movedown'),
                'click' => $move,
            ),
        );

    }

	private function publish()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images';
        return Yii::app()->getAssetManager()->publish($dir);
	}
}
?>