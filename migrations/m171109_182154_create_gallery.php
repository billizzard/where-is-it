<?php

use yii\db\Migration;

class m171109_182154_create_gallery extends Migration
{
    private $table = 'gallery';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'place_id' => $this->integer(),
            'ip' => $this->integer(),
            'parent_id' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
