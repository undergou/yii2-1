<?php

use yii\db\Migration;

/**
 * Class m191120_133908_create_table_users
 */
class m191120_133908_create_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE `users` (
            `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            `username` varchar(64) NOT NULL,
            `email` varchar(64) NOT NULL,
            `displayname` varchar(64) NOT NULL,
            `password` varchar(64) NOT NULL,
            `resetKey` varchar(64) NOT NULL,
            `privileges` tinyint(1) NOT NULL DEFAULT '0' 
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $sql = "DROP TABLE users";
      Yii::$app->db->createCommand($sql)->execute();
    }

}
