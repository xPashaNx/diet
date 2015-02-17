<?php

/**
 * Class WebUser
 */
class WebUser extends CWebUser
{
    /**
     * @var null
     */
    private $_model = null;

    /**
     * Get role
     *
     * @return mixed
     */
    function getRole()
    {
        if ($user = $this->getModel())
            return $user->role;
    }

    /**
     * Get model
     *
     * @return null
     */
    public function getModel()
    {
        if ($this->_model === null)
            $this->_model = User::model()->findByPk($this->id);

        return $this->_model;
    }
}