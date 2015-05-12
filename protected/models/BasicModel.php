<?php

class BasicModel extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return BasicModel the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */

}
?>