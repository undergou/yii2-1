<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $displayname
 * @property string $password
 * @property string $resetKey
 * @property int $privileges
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'displayname' => 'Displayname',
            'password' => 'Password',
            'resetKey' => 'Reset Key',
            'privileges' => 'Privileges',
        ];
    }

    public function generateResetKey(): void
    {
        $this->resetKey = Yii::$app->security->generateRandomString();
    }

    public function validateResetKey(string $resetKey): bool
    {
        return $this->getResetKey() === $resetKey;
    }

    public function getResetKey(): string
    {
        return $this->resetKey;
    }
}
