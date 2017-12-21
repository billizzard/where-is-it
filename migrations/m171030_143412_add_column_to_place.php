<?php

use yii\db\Migration;

class m171030_143412_add_column_to_place extends Migration
{
    private $table = 'place';
    private $column = 'parent_id';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->column, $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->column);
    }

}
