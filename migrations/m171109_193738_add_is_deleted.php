<?php

use yii\db\Migration;

class m171109_193738_add_is_deleted extends Migration
{
    private $column = 'is_deleted';

    public function safeUp()
    {
        $this->addColumn('user', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('place', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('contact', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('category', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('discount', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('gallery', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('image', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('message', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('review', $this->column, $this->boolean()->defaultValue(false));
        $this->addColumn('schedule', $this->column, $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('user', $this->column);
        $this->dropColumn('place', $this->column);
        $this->dropColumn('contact', $this->column);
        $this->dropColumn('category', $this->column);
        $this->dropColumn('discount', $this->column);
        $this->dropColumn('gallery', $this->column);
        $this->dropColumn('image', $this->column);
        $this->dropColumn('message', $this->column);
        $this->dropColumn('review', $this->column);
        $this->dropColumn('schedule', $this->column);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171109_193738_add_is_deleted cannot be reverted.\n";

        return false;
    }
    */
}
