<?php

use yii\db\Migration;

class m170917_115154_create_places extends Migration
{
    private $table = 'place';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'lat' => $this->double(),
            'lon' => $this->double(),
            'city_id' => $this->integer(),
            'address' => $this->string(255),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_ip' => $this->string(50),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('category_id', $this->table, 'category_id');
        $this->createIndex('city_id', $this->table, 'city_id');
        $this->createIndex('lat', $this->table, 'lat');
        $this->createIndex('lon', $this->table, 'lon');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
