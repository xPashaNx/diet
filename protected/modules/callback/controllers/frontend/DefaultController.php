<?php

/**
 * Class DefaultController
 */
class DefaultController extends FrontEndController
{
    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'testLimit' => '1',
            ),
        );
    }

    /**
     * Returns form for send message to admin
     *
     * @throws CException
     */
    public function actionIndex()
    {
        $this->metaInfoGenerate('Отправка сообщения', '', '');
        $this->breadcrumbs[] = 'Отправка сообщения';
        $model = new CallbackForm;
        if (isset($_POST['CallbackForm']))
        {
            $config = CallbackConfig::model()->findByPk(1);
            $model->attributes = $_POST['CallbackForm'];
            if ($model->validate())
            {
                if(CallbackConfig::model()->checkTimeout())
                {
                    $body = $this->renderPartial('callback_template', array_merge(array('model' => $model)), true);
                    if ($this->module->sendMessage($config->email, 'Сообщение с сайта ' . Yii::app()->config->sitename, $body))
                    {
                        Yii::app()->user->setFlash('callback_message', 'Ваше письмо успешно отправлено администратору сайта.');
                        Yii::app()->session['timeoutCallback'] = date("Y-m-d H:i:s");
                    }
                    else
                        Yii::app()->user->setFlash('callback_message', 'В данный момент отправка сообщений невозможна.');
                }
                else
                    Yii::app()->user->setFlash('callback_message', 'Разрешено оправлять одно сообщение в ' . $config->timeout . ' минут.');
            }
            $this->renderPartial('_form', array('model'=>$model));
        }
        else
            $this->render('index', array('model' => $model));
    }


    /**
     * Returns form for phoneback request
     *
     * @throws CException
     */
    public function actionPhoneback()
    {
        $this->metaInfoGenerate('Просьба перезвонить', '', '');
        $this->breadcrumbs[] = 'Просьба перезвонить';
        $model = new PhonebackForm;
        if (isset($_POST['PhonebackForm']))
        {
            $model->attributes = $_POST['PhonebackForm'];
            if ($model->validate())
            {
                $admin = CallbackConfig::model()->findByPk(1);
                $body = $this->renderPartial('phoneback_template', array_merge(array('model' => $model)), true);
                if ($this->module->sendMessage($admin->email, 'Просьба перезвонить '.Yii::app()->config->sitename, $body))
                    Yii::app()->user->setFlash('callback_message', 'Сообщение отправлено.');
                else
                    Yii::app()->user->setFlash('callback_message', 'В данный момент отправка сообщений невозможна.');

                $this->refresh();
            }
        }

        $this->render('phoneback', array('model' => $model));
    }

}