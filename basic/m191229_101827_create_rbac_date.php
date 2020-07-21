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


    }

    public function safeDown()
    {
        echo "m191229_101827_create_rbac_date cannot be reverted.\n";

        return false;
    }

}
