<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /** @var  User */
    protected $_user;

	public function authenticate() {
        $this->_user = User::model()->resetScope()->findByAttributes(array('email' => $this->username));
		if (!$this->_user) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            return false;
        }
		if(!$this->_user->checkPassword($this->password)) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
            return false;
        }
        $this->errorCode=self::ERROR_NONE;
		return true;
	}

    /**
     * Returns the unique identifier for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId()
    {
        return $this->_user->id;
    }

    /**
     * Returns the display name for the identity.
     * The default implementation simply returns {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName()
    {
        return $this->_user->username;
    }
}