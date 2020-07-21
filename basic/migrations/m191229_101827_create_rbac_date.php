<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m191229_101827_create_rbac_date
 */
class m191229_101827_create_rbac_date extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $crud = $auth->createPermission('CRUD');
        $auth->add($crud);

        $active = $auth->createRole('active');
        $auth->add($active);
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $crud);

//        $user = new User([
//            'username' => 'admin',
//            'displayname' => 'Admin',
//            'email' => 'admin@mail.ru',
//            'password' => 'c8292d7fbfe1c7aff91fe5f1c27391bcdd2ac6a1'
//        ]);
//        $user->save();

//        $auth->assign($admin, $user->getId());
//        $auth->assign($active, $user->getId());
    }

    public function safeDown()
    {
        echo "m191229_101827_create_rbac_date cannot be reverted.\n";

        return false;
    }

}
