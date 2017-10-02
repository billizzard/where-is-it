<?php

use yii\db\Migration;

class m170928_064743_create_city extends Migration
{
    public $table = 'city';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'lat' => $this->double(),
            'lon' => $this->double(),
            'status' => $this->integer()->defaultValue(0),
        ]);

        $this->insert($this->table, [
            'id' => 1,
            'name' => 'Минск',
            'lat' => '',
            'lon' => ''
        ]);

        $this->insert($this->table, [
            'id' => 2,
            'name' => 'Витебск',
        ]);

        $this->createIndex('name', $this->table, 'name');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
