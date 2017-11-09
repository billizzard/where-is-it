<?php

use yii\db\Migration;

class m171030_135112_add_column_to_schedule extends Migration
{
    private $table = 'schedule';
    private $column = 'status';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->column, $this->smallInteger()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->column);
    }

}
