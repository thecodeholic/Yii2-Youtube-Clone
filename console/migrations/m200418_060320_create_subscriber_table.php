<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriber}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m200418_060320_create_subscriber_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriber}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(11),
            'user_id' => $this->integer(11),
            'created_at' => $this->integer(11),
        ]);

        // creates index for column `channel_id`
        $this->createIndex(
            '{{%idx-subscriber-channel_id}}',
            '{{%subscriber}}',
            'channel_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscriber-channel_id}}',
            '{{%subscriber}}',
            'channel_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-subscriber-user_id}}',
            '{{%subscriber}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscriber-user_id}}',
            '{{%subscriber}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscriber-channel_id}}',
            '{{%subscriber}}'
        );

        // drops index for column `channel_id`
        $this->dropIndex(
            '{{%idx-subscriber-channel_id}}',
            '{{%subscriber}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscriber-user_id}}',
            '{{%subscriber}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-subscriber-user_id}}',
            '{{%subscriber}}'
        );

        $this->dropTable('{{%subscriber}}');
    }
}
