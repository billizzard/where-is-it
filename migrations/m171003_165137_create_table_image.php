<?php

use yii\db\Migration;

class m171003_165137_create_table_image extends Migration
{
    public $table = 'image';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer(),
            'url' => $this->string(100),
            'description' => $this->string(255),
            'type' => $this->smallInteger()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex('place_id', $this->table, 'place_id');
        $this->createIndex('type', $this->table, 'type');
        $this->createIndex('status', $this->table, 'status');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
