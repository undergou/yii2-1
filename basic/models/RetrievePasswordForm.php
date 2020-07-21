<?php

namespace app\models;
use yii\base\Model;
use yii\helpers\Url;
use Yii;

class RetrievePasswordForm extends Model
{
    public $email;
    public $resetKey;
    public $newPassword;

    public function rules() {
        return [
            ['email', 'email'],
            ['newPassword', 'required'],
            ['newPassword', 'string', 'min' => 6],
            ['newPassword', 'specialSymbols'],
        ];
    }

    public function specialSymbols($password, $params) {
        $input  = $this->$password;
        if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $input)) {
            $this->addError($password, "Your password should have special symbols");
        }
    }

    public function sentEmail($email) {
        $host = Url::base('http');
        $user = $this->getUser();
        $resetKey = $user['resetKey'];
        $result = Yii::$app->mailer->compose()
                ->setFrom('lamer_10@mail.ru')
                ->setTo($email)
                ->setSubject('Восстановление пароля')
                ->setTextBody('Восстановите свой пароль')
                ->setHtmlBody("<b>Восстановите свой пароль</b>
                               <a href=$host/password-resetting?resetKey=$resetKey>Восстановить пароль</a>")
                ->send();
        return $result;
    }

    public function setNewPassword() {

        $user = $this->getUserByResetKey();

        $user->password = sha1($this->newPassword);
        $user->save();
    }

    public function getUser() {
        return Users::findOne(["email" => $this->email]);
    }

    public function getUserByResetKey() {
        return Users::findOne(["resetKey" => $this->resetKey]);
    }

}