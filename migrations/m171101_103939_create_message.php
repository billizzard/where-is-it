<?php

use yii\db\Migration;

class m171101_103939_create_message extends Migration
{
    private $table = 'message';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'email' => $this->string(100),
            'place_id' => $this->integer(),
            'message' => $this->text(),
            'type' => $this->smallInteger(),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
