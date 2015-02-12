<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.*');

/*
Класс виджета для вывода формы быстрого подбора товаров
*/
class SearchboxWidget extends CPortlet {

    public $view;
    public $category=0;

	public function	run() {

        $root_category=new CatalogCategory();
        $root_category->id=0;

        // Если переданы параметры - берем их
        if(isset($_GET['selectionParameters'])){
            $selectionParameters=$_GET['selectionParameters'];
        }

        // Если передан параметр "Категория" - устанавливаем ее
        if(isset($selectionParameters['category'])){
            $this->category=$selectionParameters['category'];
        }else{
            $selectionParameters['category']=$this->category;
        }

        $category=CatalogCategory::model()->with('use_attribute')->findByPk($this->category);
        if(!$category){
            $category=$root_category;
        }

        // Отбираем атрибуты
        $attributes=array();
        foreach($category->use_attribute as $attr){
            if($attr->id_attribute_kind==3 || $attr->id_attribute_kind==4){
                $attributes[]=$attr;
                if(!isset($selectionParameters['attributes'][$attr->name])){
                    $selectionParameters['attributes'][$attr->name]=array();
                }
            }
        }

        $category_list=$root_category->allChildsList;
        $brand_list=CatalogBrands::arrayDropList();
        $priceRange=CatalogProduct::getCurrencyPriceProfiledRange($this->category);

        // Если какие-то параметры не переданы - выставляем умолчания
        if(!isset($selectionParameters['pricefrom'])) $selectionParameters['pricefrom']=$priceRange['min'];
        if(!isset($selectionParameters['priceto'])) $selectionParameters['priceto']=$priceRange['max']+1;
        if(!isset($selectionParameters['brand'])) $selectionParameters['brand']=array();

        if(!isset($this->view)){$this->view='searchbox';}

		$this->render($this->view, array(
             'category_list'=>$category_list,
             'brand_list'=>$brand_list,
             'priceRange'=>$priceRange,
             'selectionParameters'=>$selectionParameters,
             'attributes'=>$attributes,
        ));
		return parent::run();
	}

}
?>
