<?php

use yii\db\Migration;

class m170917_120202_create_categories extends Migration
{
    private $table = 'category';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'parent_id' => $this->integer()->defaultValue(0),
            'sort' => $this->integer()->defaultValue(0)
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
