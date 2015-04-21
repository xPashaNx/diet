<?php
class SSortableAction extends CAction
{
	public function run(){
		$id = (int)$_GET['id'];
		$method = $_GET['method'];
		if(Yii::app()->request->isPostRequest)
		{
			$this->getController()->loadModel($id)->move($method);

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
}
?>
