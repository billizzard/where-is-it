<?php

use yii\db\Migration;

class m170924_205740_add_column extends Migration
{
    public $table = 'place';
    public $address = 'address';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->address, $this->string(255));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->address);
    }

}
