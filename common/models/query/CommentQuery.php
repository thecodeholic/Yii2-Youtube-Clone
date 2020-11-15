<?php

namespace common\models\query;

use common\models\Comment;
use common\models\Video;

/**
 * This is the ActiveQuery class for [[\common\models\Comment]].
 *
 * @see \common\models\Comment
 */
class CommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Comment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Comment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function videoId($videoId)
    {
        return $this->andWhere(['video_id' => $videoId]);
    }

    public function parent()
    {
        return $this->andWhere(['parent_id' => null]);
    }

    public function latest()
    {
        return $this->orderBy("pinned DESC, created_at DESC");
    }

    public function byChannel($userId)
    {
        return $this->innerJoin(Video::tableName() . ' v', 'v.video_id = ' . Comment::tableName() . '.video_id')
            ->andWhere(['v.created_by' => $userId]);
    }
}
