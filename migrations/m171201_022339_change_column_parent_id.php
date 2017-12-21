<?php

use yii\db\Migration;

class m171201_022339_change_column_parent_id extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('place', 'parent_id', $this->integer()->defaultValue(0));
        $this->alterColumn('schedule', 'parent_id', $this->integer()->defaultValue(0));
        $this->alterColumn('contact', 'parent_id', $this->integer()->defaultValue(0));
        $this->alterColumn('gallery', 'parent_id', $this->integer()->defaultValue(0));
        $this->addColumn('discount', 'parent_id', $this->integer()->defaultValue(0));
        $this->dropColumn('discount', 'image_id');
    }

    public function safeDown()
    {
        $this->dropColumn('discount', 'parent_id');
        $this->addColumn('discount', 'image_id', $this->integer());
    }

}
