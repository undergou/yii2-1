<?php

namespace app\models;
use yii\base\Model;
use Yii;

class RetrievePasswordForm extends Model
{
    public $email;
    public $newPassword;

    public function rules() {
        return [
            ['email', 'email'],
            [['email', 'newPassword'], 'required'],
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
        $url = "http://localhost/password-resetting?email=" . $email;
        $result = Yii::$app->mailer->compose()
                ->setFrom('danik.yura1@mail.ru')
                ->setTo($email)
                ->setSubject("Retrieve password")
                ->setTextBody('Vosstanovi parol suka')
                ->setReturnPath("email@sds.dsds")
                ->setHtmlBody($url)
                ->setHtmlBody($url)
                ->send();
        return $result;
    }

    public function setNewPassword() {

        $user = Users::findOne(["email" => $this->email]);

        $user->password = sha1($this->newPassword);
        $user->save();

    }

}