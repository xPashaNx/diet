<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.CatalogCategory');
/*
Класс виджета для вывода древовидного меню категорий
*/
class MenuCategoryTreeWidget extends CPortlet {

    public $cssFile;
    
	public function	run() {

        // Берем текущий запрос для определения активного пункта меню
        $request=Yii::app()->request->requestUri;
        $pieces=explode ('/', $request);
        // Если это товар (адрес содержит .html)
        if(strstr(end($pieces), '.')){
             // Убираем из адреса ид товара
             $request=substr ($request, 0, strlen($request)-strlen(end($pieces))-1);
        }

        $category_tree = $this->getCategoryTree(0, '/catalog', $request);
        $treeconfig['data']=$category_tree;
        if($this->cssFile){$treeconfig['cssFile']=$this->cssFile;}

		$this->render('menucategorytreewidget',array(
                           'treeconfig'=>$treeconfig,
        ));
		return parent::run();
	}

    private function getCategoryTree($id_category, $pathPrefix, $request=''){


        $tree_data=array();
        //берем все подкатегории
        $categories=CatalogCategory::model()->findAll(array(
                                                    'condition'=>'parent_id=:parent_id',
                                                    'order'=>'sort_order',
                                                    'params'=>array('parent_id'=>$id_category),
                                                ));

        // если есть подкатегории
        if(!empty($categories)){
			$first=true;
			$after=false;
            foreach ($categories as $category){
                 // По умолчанию - закрыто
                $expanded=false;
				$class='';
                if ($first) {
					$first=false;
					$class="first";
				}
                if ($after) {
					$after=false;
					if ($class!='') $class.="after";
					else $class="after";
				}
                $link=$pathPrefix.'/'.$category->link;

                // Если запрос соответствует ссылке пункта меню - делаем его активным
                if($request==$link){
					if ($class!='') $class.=' active';
					else $class='active';
					$after=true;
                    $htmlOptions=array('class'=>$class);
                    //$text=CHtml::tag('span',array(),$category->title);
                    $text=CHtml::link('<span>'.$category->title.'</span>', $link);
                    // Если элемент активен - открываем подэлементы
                    $expanded=true;
                }else{
                        $htmlOptions=array();
                        $text=CHtml::link('<span>'.$category->title.'</span>', $link);
                }
				if ($class!='') $htmlOptions=array('class'=>$class);
				/*
                // Получаем дочернее дерево
                $children=$this->getCategoryTree($category->id, $link, $request);
                // Определяем, нет ли открытых веток
                foreach($children as $value){
                    // Если хоть одна подветка открыта - открываем всю ветку
                    if($value['expanded']){$expanded=true;}
                }
				*/
                // Формируем элемент массива
                $tree_data[]=array(
                    'text'=>$text,
                    // Строим дерево для потомков
                    //'children'=>$children,
                    //'expanded'=>$expanded,
                    'htmlOptions'=>$htmlOptions,
                );
            }

        }

        return $tree_data;
    }

}
?>
