<?php

/**
 * This is the model class for table "callback_config".
 *
 * The followings are the available columns in table 'callback_config':
 * @property string $id
 * @property integer $enabled
 * @property string $type
 * @property string $host
 * @property string $username
 * @property string $password
 * @property string $port
 * @property string $encryption
 * @property string $sender
 * @property string $email
 * @property integer $timeout
 * @property integer $verify_code
 */
class CallbackConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'callback_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('email', 'required'),
            array('email', 'length', 'max'=>255),
            array('email', 'email'),
			array('enabled, timeout', 'numerical', 'integerOnly' => true),
			array('type, host, username, password, port, encryption, sender, email', 'length', 'max' => 255),
			array('enabled, type, host, username, password, verify_code, port, encryption, sender, email, timeout', 'safe'),
			array('type', 'checkType'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'enabled' => 'Разрешить отправку писем',
			'type' => 'Тип транспорта',
			'host' => 'Адрес почтового сервера',
			'username' => 'Логин',
			'password' => 'Пароль',
			'port' => 'Порт',
			'encryption' => 'Шифрование',
			'sender' => 'Имя отправителя',
            'email' => 'Email',
			'verify_code' => 'Использовать проверочный код',
			'timeout' => 'Таймаут (минут)',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CallbackConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array
	 */
	public function getTransportTypes()
	{
		return array(
			'php' => 'php',
			'smtp' => 'smtp',
		);
	}

	/**
	 * @return array
	 */
	public function getEncryptions()
	{
		return array(
			'ssl' => 'ssl',
			'tls' => 'tls',
		);
	}

	/**
	 * Checks the transport type.
	 * This is the 'checkType' validator as declared in rules().
	 */
	public function checkType($attribute, $params)
	{
		if ($this->type == 'smtp')
		{
			$requireValidator = CValidator::createValidator('required', $this, 'host, username, password');
			$requireValidator->validate($this);
			$emailValidator = CValidator::createValidator('email', $this, 'username');
			$emailValidator->validate($this);
		}
	}

    public function checkCaptchaEnabled()
    {
        $model = CallbackConfig::model()->find(array('limit'=>1));
        if(isset($model->verify_code) && $model->verify_code != "0")
            return true;
        return false;
    }

    public function checkTimeout()
    {
        $config = CallbackConfig::model()->findByPk(1);
        if(isset(Yii::app()->session["timeoutCallback"]) and (int)$config->timeout > 0)
        {
            $date = new DateTime(Yii::app()->session["timeoutCallback"]);
            $date->add(new DateInterval('PT'. $config->timeout .'M'));
            if($date->format('Y-m-d H:i:s') >= date('Y-m-d H:i:s'))
                return false;
        }
        return true;
    }
}
