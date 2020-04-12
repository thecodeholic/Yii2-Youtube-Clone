<?php
/**
 * User: TheCodeholic
 * Date: 4/12/2020
 * Time: 10:18 PM
 */
/** @var $model \common\models\Video */
?>
<div class="media video-item">
    <a href="<?php echo \yii\helpers\Url::to(['update', 'id' => $model->video_id]) ?>">
        <?php if ($model->has_thumbnail): ?>
            <img src="<?php echo $model->getThumbnailUrl() ?>" class="mr-3" style="max-width: 160px" alt="...">
        <?php else: ?>
            <div class="video-wrapper mr-3">
                <div class="embed-responsive embed-responsive-16by9" style="width: 160px">
                    <video class="embed-responsive-item" src="<?php echo $model->getVideoUrl() ?>">
                    </video>
                </div>
            </div>
        <?php endif; ?>
    </a>
    <div class="media-body">
        <h5 class="mt-0"><?php echo $model->title ?></h5>
        <?php echo \yii\helpers\StringHelper::truncate($model->description, 100) ?>
    </div>
</div>


