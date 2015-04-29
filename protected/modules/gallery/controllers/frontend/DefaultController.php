<?php

class DefaultController extends FrontEndController
{
	public function actionIndex()
	{
		$galleryConfig = GalleryConfig::model()->find();
		
		$criteria = new CDbCriteria;
		$criteria->limit = $galleryConfig->limit;
        $dataProvider = new CActiveDataProvider('Gallery', array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'sort_order',
			),
			'pagination' => array(
				'pageSize' => $galleryConfig->limit,
			),
		));
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

    public function actionView($id)
	{
        $model = $this->loadModel($id);
		
        // Фотографии галереи
        $criteria = new CDbCriteria;
        $criteria->compare('gallery_id', $model->id);
        $dataProvider = new CActiveDataProvider('GalleryPhoto', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sort_order ASC',
            ),
            'pagination' => false,
        ));

        $this->render('gallery_view', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function loadModel($id)
    {
        $model = Gallery::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }
}