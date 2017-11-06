<?php

use yii\db\Migration;

class m171102_083330_add_column_to_user extends Migration
{
    private $table = 'user';
    private $columnLogin = 'login';

    public function safeUp()
    {
        $this->addColumn($this->table, $this->columnLogin, $this->string(50)->unique());
    }

    public function safeDown()
    {
        $this->dropColumn($this->table, $this->columnLogin);
    }
}
