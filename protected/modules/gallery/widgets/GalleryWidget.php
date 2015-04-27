<?php

Yii::import('zii.widgets.CWidget');
Yii::import('application.modules.gallery.models.*');
/*
 *Класс виджета для вывода случайного фото из галерей
 *
*/
class GalleryWidget extends CWidget {

	public function	run() 
	{
		$galleryConfig = GalleryConfig::model()->find();
		$displayMode = $galleryConfig->display_mode;
		
		switch ($displayMode)
		{
			case 0:
				$gallery = Gallery::getFirstGallery();
				break;
			case 1:
				$gallery = Gallery::getRandomGallery();
				break;
			case 2:
				$gallery = Gallery::getSelectedGallery($galleryConfig->selected_gallery_id);
				break;
		}
        $this->render('gallery', array(
			'gallery' => $gallery,
		));
        
		return parent::run();
	}
}
?>
