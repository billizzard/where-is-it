<?php

use yii\db\Migration;

class m171122_015807_add_column_to_users extends Migration
{
    private $table = 'user';
    private $column = 'avatar';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->column, $this->string(10));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->column);
    }

}
