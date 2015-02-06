<?php
Yii::import('zii.widgets.CPortlet');

/**
 * Class CallbackAdminmenuWidget
 */
class GalleryAdminmenuWidget extends CPortlet
{
    /**
     * Initialization
     */
    public function	init()
    {
        $this->title = 'Фотогалерея';
        return parent::init();
    }

    /**
     * Running
     *
     * @throws CException
     */
    public function	run()
    {
        $this->render('gallery');
        return parent::run();
    }

}
?>