<?php

use yii\db\Migration;

class m171018_102127_create_schedule extends Migration
{
    public $table = 'schedule';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'place_id' => $this->integer(),
            '1_from' => $this->integer()->unsigned(),
            '1_to' => $this->integer()->unsigned(),
            '2_from' => $this->integer()->unsigned(),
            '2_to' => $this->integer()->unsigned(),
            '3_from' => $this->integer()->unsigned(),
            '3_to' => $this->integer()->unsigned(),
            '4_from' => $this->integer()->unsigned(),
            '4_to' => $this->integer()->unsigned(),
            '5_from' => $this->integer()->unsigned(),
            '5_to' => $this->integer()->unsigned(),
            '6_from' => $this->integer()->unsigned(),
            '6_to' => $this->integer()->unsigned(),
            '7_from' => $this->integer()->unsigned(),
            '7_to' => $this->integer()->unsigned(),
            'ip' => $this->string(50),
            'parent_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-place-schedule',
            $this->table,
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
