<?php

use yii\db\Migration;

class m171109_182154_create_gallery extends Migration
{
    private $table = 'gallery';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'place_id' => $this->integer(),
            'ip' => $this->text(),
            'parent_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
