<?php
/**
 * User: TheCodeholic
 * Date: 4/18/2020
 * Time: 8:48 AM
 */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \common\models\Video */
/** @var $similarVideos \common\models\Video[] */
/** @var $comments \common\models\Comment[] */

$this->title = $model->title . ' | ' . Yii::$app->name;
?>
<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item"
                   poster="<?php echo $model->getThumbnailLink() ?>"
                   src="<?php echo $model->getVideoLink() ?>"
                   controls></video>
        </div>
        <h6 class="mt-2"><?php echo $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <?php echo $model->getViews()->count() ?> views •
                <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php \yii\widgets\Pjax::begin() ?>
                <?php echo $this->render('_buttons', [
                    'model' => $model
                ]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
        <div>
            <p>
                <?php echo \common\helpers\Html::channelLink($model->createdBy) ?>
            </p>
            <?php echo Html::encode($model->description) ?>
        </div>
        <div class="comments mt-5">
            <h4 class="mb-3"> <span id="comment-count"><?php echo $model->getComments()->count() ?></span> Comments</h4>
            <div class="create-comment mb-4">
                <div class="media">
                    <img class="mr-3 comment-avatar" src="/img/avatar.svg" alt="">
                    <div class="media-body">
                        <form class="create-comment-form" method="post"
                              action="<?php echo Url::to(['/comment/create', 'id' => $model->video_id]) ?>">
                            <input type="hidden" name="video_id" value="<?php echo $model->video_id ?>">
                            <textarea rows="1"
                                      class="form-control comment-input"
                                      name="comment"
                                      placeholder="Add a public comment"></textarea>
                            <div class="action-buttons text-right mt-2">
                                <button type="button" class="btn btn-light btn-cancel">Cancel</button>
                                <button class="btn btn-primary btn-save">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="comments-wrapper" class="comments-wrapper">
                <?php foreach ($comments as $comment) {
                    echo $this->render('_comment_item', [
                        'model' => $comment,
                    ]);
                } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="media mb-3">
                <a href="<?php echo Url::to(['/video/view', 'id' => $similarVideo->video_id]) ?>">
                    <div class="embed-responsive embed-responsive-16by9 mr-2"
                         style="width: 120px">
                        <video class="embed-responsive-item"
                               poster="<?php echo $similarVideo->getThumbnailLink() ?>"
                               src="<?php echo $similarVideo->getVideoLink() ?>"></video>
                    </div>
                </a>
                <div class="media-body">
                    <h6 class="m-0"><?php echo $similarVideo->title ?></h6>
                    <div class="text-muted">
                        <p class="m-0">
                            <?php echo \common\helpers\Html::channelLink($similarVideo->createdBy) ?>
                        </p>
                        <small>
                            <?php echo $similarVideo->getViews()->count() ?> views •
                            <?php echo Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
