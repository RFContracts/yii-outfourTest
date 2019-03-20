<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m190320_123338_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'created_at' => $this->string(100),
            'updated_at' => $this->string(100),
            'title' => $this->string(255),
            'text' => $this->text(),
            'image' => $this->string(100),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);

        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
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
            'fk-post-user_id',
            'post'
        );

        $this->dropTable('{{%post}}');
    }
}
