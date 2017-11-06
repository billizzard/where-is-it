<?php

use yii\db\Migration;

class m171106_121453_create_contacts extends Migration
{
    private $table = 'contact';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'phone' => $this->text(),
            'place_id' => $this->integer(),
            'email' => $this->text(),
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
