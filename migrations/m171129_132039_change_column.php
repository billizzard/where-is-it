<?php

use yii\db\Migration;

class m171129_132039_change_column extends Migration
{
    private $table = 'contact';
    private $column = 'status';

    public function safeUp()
    {
        $this->alterColumn($this->table, $this->column, $this->smallInteger()->defaultValue(0));
    }

    public function safeDown()
    {
    }

}
