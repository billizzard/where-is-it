<?php

use yii\db\Migration;

class m171110_162209_add_column_to_schedule extends Migration
{
    private $table = 'schedule';
    private $column = 'add_info';

    private $tableD = 'place';
    private $columnD = 'work_time';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->column, $this->text());
        $this->dropColumn($this->tableD, $this->columnD);
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->column);
        $this->addColumn($this->tableD, $this->columnD, $this->text());
    }
}
