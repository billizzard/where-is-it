<?php

use yii\db\Migration;

class m171113_151138_add_column_to_place extends Migration
{
    private $table = 'place';

    public function safeUp()
    {
        $this->addColumn($this->table, 'prev_description', $this->string(500));
        $this->dropColumn($this->table, 'city_id');
        $this->dropColumn($this->table, 'img_dir');
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, 'prev_description');
        $this->addColumn($this->table, 'city_id', $this->integer());
        $this->addColumn($this->table, 'img_dir', $this->string(255));
    }

}
