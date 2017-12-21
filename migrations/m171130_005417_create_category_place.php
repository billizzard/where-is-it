<?php

use yii\db\Migration;

class m171130_005417_create_category_place extends Migration
{
    private $table = 'category_place';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'place_id' => $this->integer(),
        ]);

        $this->dropColumn('place', 'category_id');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
        $this->addColumn('place', 'category_id', $this->integer());
    }

}
