<?php

use yii\db\Migration;

class m171031_143729_create_votes extends Migration
{
    private $table = 'vote';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'ip' => $this->integer()->unsigned(),
            'place_id' => $this->integer(),
            'vote' => $this->boolean(),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
