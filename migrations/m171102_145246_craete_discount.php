<?php

use yii\db\Migration;

class m171102_145246_craete_discount extends Migration
{
    private $table = 'discount';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
            'place_id' => $this->integer(),
            'title' => $this->string(150),
            'message' => $this->string(1000),
            'type' => $this->smallInteger()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(0),
            'start_date' => $this->timestamp()->defaultValue(null),
            'end_date' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
