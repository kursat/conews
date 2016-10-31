<?php

namespace app\models;

use app\models\AuthItem;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],
            ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            $role = Yii::$app->authManager->getRole(AuthItem::ROLE_UNCONFIRMED);

            Yii::$app->authManager->assign($role, $user->id);


            Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom([Yii::t('app', 'conewsmailer@gmail.com') => Yii::t('app', 'Conews')])
                    ->setSubject(Yii::t('app', 'Please confirm your email address'))
                    ->setTextBody(Yii::t('app', 'Link: {url}/confirm-email/{auth_key}', [
                                'url' => Yii::$app->getUrlManager()->getHostInfo(),
                                'auth_key' => $user->auth_key
                    ]))
                    ->send();

            return $user;
        } else
            return null;
    }

}
