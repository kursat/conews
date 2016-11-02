<?php

namespace app\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model {

    public $password;

    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword() {

        if (!$this->validate())
            return false;

        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
		
		Yii::$app->authManager->revokeAll($user->id);
		$role = Yii::$app->authManager->getRole(AuthItem::ROLE_CONFIRMED);
		Yii::$app->authManager->assign($role, $user->id);
		
		Yii::$app->user->login($user, 0);

        return $user->save(false);
    }

}
