<?php

namespace app\models;

use app\models\AuthItem;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Register form
 */
class RegisterForm extends Model {

    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 254],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register() {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->setPassword(uniqid());
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        if ($user->save()) {
            $role = Yii::$app->authManager->getRole(AuthItem::ROLE_REGISTERED);
            Yii::$app->authManager->assign($role, $user->id);
            
            if ($this->sendEmail()) {
                Yii::$app->session->setFlash('success', 'An email sent to your email address. Check your email for further instructions.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            
            return $user;
        } else {
            return null;
        }
    }

    public function sendEmail() {

        $view = [
            'html' => 'confirmEmailToken-html',
            'text' => 'confirmEmailToken-text'
        ];

        $params = ['user' => User::findByEmail($this->email)];

        return Yii::$app->mailer
                        ->compose($view, $params)
                        ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name])
                        ->setTo($this->email)
                        ->setSubject('Welcome to ' . \Yii::$app->name)
                        ->send();
    }

}
