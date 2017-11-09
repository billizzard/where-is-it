<?php

use yii\db\Migration;

class m171101_141127_add_column_to_place extends Migration
{
    private $table = 'place';
    private $columnStars = 'stars';
    private $columnStarsCount = 'stars_count';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->columnStars, $this->double()->defaultValue(0));
        $this->addColumn($this->table, $this->columnStarsCount, $this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->columnStars);
        $this->dropColumn($this->table, $this->columnStarsCount);
    }
}
