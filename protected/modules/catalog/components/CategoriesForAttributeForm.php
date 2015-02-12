<?php

class CategoriesForAttributeForm extends CWidget {

    public $category;

    public function run() {

        $data_tree=array($this->getCategoryTree(0, 'Все категории', 1));

        $this->render('cat_for_attr', array('category'=>$this->category, 'data_tree'=>$data_tree));

        parent::run();
       
    }

    private function getCategoryTree($id_category, $name, $checked){

        // если категория ненулевая - присоединяем чекбокс
        if($id_category){
            $text=CHtml::checkBox('UseCategory[]', $checked, array('value'=>$id_category)).$name;
        } else{$text=$name;}

        //Запоминаем в массив название текущей категории
        $tree_data=array(
            'text'     => $text,
            'expanded' => true,
        );

        //берем все подкатегории
        $categories=CatalogCategory::model()->findAll('parent_id=:parent_id', array('parent_id'=>$id_category));

        // если есть подкатегории
        if(!empty($categories)){
            $children=array();
            foreach ($categories as $category){
                //для каждой подкатегории строим форму
                $children[]=$this->getCategoryTree($category->id, $category->title, $this->chekedCategory($category->id));
            }

            // помещаем сформированный массив в элемент children
            $tree_data['children']=$children;

        }

        return $tree_data;
    }

    // узнаем, существует ли категория с таким id в переданных
    private function chekedCategory($id){
        foreach($this->category as $cat){
            if($cat->id==$id) return true;
        }
         return false;
    }

}

?>