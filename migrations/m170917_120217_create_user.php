<?php

use yii\db\Migration;

class m170917_120217_create_user extends Migration
{
    private $table = 'user';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'email' => $this->string(100),
            'password' => $this->string(200),
            'access_token' => $this->string(200),
            'auth_key' => $this->string(200),
            'role' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert($this->table, [
            'id' => 1,
            'access_token' => Yii::$app->security->generateRandomString(32),
            'auth_key' => Yii::$app->security->generateRandomString(32),
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => Yii::$app->security->generatePasswordHash('aaaaaa'),
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->createIndex('email', $this->table, 'email');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
