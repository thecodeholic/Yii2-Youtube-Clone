<?php

namespace common\models;

use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property string      $video_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null    $status
 * @property string|null $video_name
 * @property int|null $has_thumbnail
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 *
 * @property User        $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_UNLISTED = 0;

    const THUMB_WIDTH = 1280;

    /**
     * @var \yii\web\UploadedFile
     */
    public $video = null;

    /**
     * @var \yii\web\UploadedFile
     */
    public $thumbnail = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['video_id'], 'required'],
            [['description', 'tags'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 2000],
            [['video_name'], 'string', 'max' => 255],
            [['video_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            ['video', 'file', 'extensions' => ['mp4']],
            ['thumbnail', 'image', 'minWidth' => self::THUMB_WIDTH],
            ['status', 'default', 'value' => self::STATUS_UNLISTED]
        ];
    }

    public static function getStatusLabels()
    {
        return [
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_UNLISTED => 'Unlisted',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if ($isInsert) {
            $this->video_id = Yii::$app->security->generateRandomString(16);
            $this->video_name = $this->video->name;
            $this->title = $this->video->name;
        } else if ($this->thumbnail) {
            $this->has_thumbnail = 1;
        }
        $result = parent::save($runValidation, $attributeNames);

        if (!$result) {
            return $result;
        }
        if ($isInsert) {
            $videoPath = Yii::getAlias('@frontend/web/storage/video/' . $this->video_id . '.mp4');
            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }
            $this->video->saveAs($videoPath);
        } else {
            if ($this->thumbnail) {
                $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumb/' . $this->video_id . '.jpg');
                if (!is_dir(dirname($thumbnailPath))) {
                    FileHelper::createDirectory(dirname($thumbnailPath));
                }
                $this->thumbnail->saveAs($thumbnailPath);
                Image::getImagine()
                    ->open($thumbnailPath)
                    ->thumbnail(new Box(self::THUMB_WIDTH, self::THUMB_WIDTH))
                    ->save();
            }
        }

        return $result;
    }

    public function getVideoUrl()
    {
        return Yii::$app->params['frontendUrl'].'/storage/video/' . $this->video_id . '.mp4';
    }

    public function getThumbnailUrl()
    {
        return Yii::$app->params['frontendUrl'].'/storage/thumb/' . $this->video_id . '.jpg';
    }
}
