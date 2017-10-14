<?php

use yii\db\Migration;

class m171004_084212_add_column_to_places extends Migration
{
    private $table = 'place';
    private $column = 'user_id';
    private $columnImg = 'dir';
    private $columnTime = 'work_time';
    private $columnYes = 'yes';
    private $columnNo = 'no';
    private $columnType = 'type';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->column, $this->integer());
        $this->addColumn($this->table, $this->columnYes, $this->integer()->defaultValue(0));
        $this->addColumn($this->table, $this->columnNo, $this->integer()->defaultValue(0));
        $this->addColumn($this->table, $this->columnType, $this->smallInteger()->defaultValue(0));
        $this->addColumn($this->table, $this->columnImg, $this->string(100));
        $this->addColumn($this->table, $this->columnTime, $this->text());
        $this->createIndex($this->column, $this->table, $this->column);
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->column);
        $this->dropColumn($this->table, $this->columnImg);
        $this->dropColumn($this->table, $this->columnTime);
        $this->dropColumn($this->table, $this->columnYes);
        $this->dropColumn($this->table, $this->columnNo);
        $this->dropColumn($this->table, $this->columnType);
    }

}
