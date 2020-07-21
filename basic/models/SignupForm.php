<?php

namespace app\models;
use yii\base\Model;
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

    public function createNewUser() {
        if(!isset($this->email)) {
            $this->email = " ";
        }
        $user = new Users();
        $dbUser = $user->find()->asArray()->where(["username" => $this->username])->one();
        if($this->username == !$dbUser)
        {
            
            $user->username = $this->username;
            $user->email = $this->email;
            $user->displayname = $this->displayname;
            $user->password = sha1($this->password);
            $user->generateResetKey();
            $user->privileges = 101;
            
            return $user->save();
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