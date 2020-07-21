<?php

namespace app\models;
use yii\base\Model;
use yii\helpers\Url;
use Yii;

class SignupForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $displayname;
    public $resetKey;
    public $privileges;

    public function attributeLabels() {
        return ['username' => 'Login', 'displayname'=> 'Nickname', 'email' => 'E-mail', 'id' => 'ID'];
    }

    public function rules() {
        return [[['username', 'email', 'password', 'displayname'], 'required'],
        ['email', 'email'],
        ['id', 'safe'],
        ['password', 'string', 'min' => 6],
        ['password', 'specialSymbols'],
        ['username', 'match', 'pattern' => '^[a-zA-Z0-9]+$^'],
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
        $result = Yii::$app->mailer->compose()
                ->setFrom('lamer_10@mail.ru')
                ->setTo($email)
                ->setSubject('Подтверждение регистрации')
                ->setTextBody('Подтвердите регистрацию')
                ->setHtmlBody("<b>Подтвердите регицстрацию</b>
                               <a href=$host/verification?username=$this->username>Подтвердить регистрацию</a>")
                ->send();
        return $result;
    }

    public function activating($username) {
        $auth = Yii::$app->authManager;
        $user = User::findByUsername($username);
        $id = $user['id'];
        $activeRole = $auth->getRole('active');
        $auth->assign($activeRole, $user->getId($id));
    }

    public function register() {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->displayname = $this->displayname;
        $user->password = sha1($this->password);
        $user->resetKey = $this->resetKey;
        $user->privileges = 101;
        $user->save();

        return $user;
    }

    public function createNewUser() {
        $user = new User();
        $dbUser = $user->find()->asArray()->where(["username" => $this->username])->one();
        if($this->username == !$dbUser)
            {
                $this->resetKey = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 16);
            
                if(!isset($this->email)) {
                    $this->email = "";
                    $this->register();
                } else {
                    $this->sentEmail($this->email);
                    return $this->register();
                }
                
        } else {
                return 0;
        }       
    }

    public static function getAll() 
    {
        $data = self::find()->all();
        return $data;
    }

}