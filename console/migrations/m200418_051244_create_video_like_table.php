<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video_like}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%video}}`
 * - `{{%user}}`
 */
class m200418_051244_create_video_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video_like}}', [
            'id' => $this->primaryKey(),
            'video_id' => $this->string(16)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'type' => $this->integer(1),
            'created_at' => $this->integer(11),
        ]);

        // creates index for column `video_id`
        $this->createIndex(
            '{{%idx-video_like-video_id}}',
            '{{%video_like}}',
            'video_id'
        );

        // add foreign key for table `{{%video}}`
        $this->addForeignKey(
            '{{%fk-video_like-video_id}}',
            '{{%video_like}}',
            'video_id',
            '{{%video}}',
            'video_id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-video_like-user_id}}',
            '{{%video_like}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-video_like-user_id}}',
            '{{%video_like}}',
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
        // drops foreign key for table `{{%video}}`
        $this->dropForeignKey(
            '{{%fk-video_like-video_id}}',
            '{{%video_like}}'
        );

        // drops index for column `video_id`
        $this->dropIndex(
            '{{%idx-video_like-video_id}}',
            '{{%video_like}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-video_like-user_id}}',
            '{{%video_like}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-video_like-user_id}}',
            '{{%video_like}}'
        );

        $this->dropTable('{{%video_like}}');
    }
}
