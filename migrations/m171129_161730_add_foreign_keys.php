<?php

use yii\db\Migration;

class m171129_161730_add_foreign_keys extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-place-review',
            'review',
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );

        $this->addForeignKey(
            'fk-place-vote',
            'vote',
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );

        $this->addForeignKey(
            'fk-place-gallery',
            'gallery',
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );

        $this->addForeignKey(
            'fk-place-discount',
            'discount',
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );

        $this->addForeignKey(
            'fk-place-contact',
            'contact',
            'place_id',
            'place',
            'id',
            'CASCADE',
            null
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-place-review', 'review');
        $this->dropForeignKey('fk-place-vote', 'vote');
        $this->dropForeignKey('fk-place-gallery', 'gallery');
        $this->dropForeignKey('fk-place-discount', 'discount');
        $this->dropForeignKey('fk-place-contact', 'contact');
    }
}
