<?php

use yii\db\Migration;

class m171101_140051_create_star extends Migration
{
    private $table = 'review';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer(),
            'user_id' => $this->integer(),
            'message' => $this->string(1000),
            'star' => $this->smallInteger(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
