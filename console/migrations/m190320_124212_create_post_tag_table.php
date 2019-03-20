<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_tag}}`.
 */
class m190320_124212_create_post_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_tag}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-post_tag-post_id',
            'post_tag',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-post_tag-tag_id',
            'post_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-post_tag-post_id',
            'post_tag'
        );
        $this->dropForeignKey(
            'fk-post_tag-tag_id',
            'post_tag'
        );

        $this->dropTable('{{%post_tag}}');
    }
}
