<?php
/**
 * User: TheCodeholic
 * Date: 11/14/2020
 * Time: 10:36 AM
 */

/** @var $this \yii\web\View */
/** @var $model \common\models\Comment */

?>
<div class="media media-comment comment-item" data-id="<?php echo $model->id ?>">
    <img class="mr-3 comment-avatar" src="/img/avatar.svg" alt="" style="width: 50px">
    <div class="media-body">
        <h6 class="mt-0">
            <?php echo \common\helpers\Html::channelLink($model->createdBy) ?>
            <small class="text-muted">
                <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                <?php if ($model->created_at !== $model->updated_at): ?>
                    (edited)
                <?php endif; ?>
            </small>
        </h6>
        <div class="comment-text">
            <div class="text-wrapper">
                <?php if ($model->mention): ?>
                    <span class="badge bg-info"><?php echo '@' . $model->mention ?></span>
                <?php endif; ?>
                <?php echo $model->comment ?>
            </div>

            <div class="bottom-actions my-2">
                <button data-action="<?php echo \yii\helpers\Url::to(['/comment/reply']) ?>"
                        class="btn btn-sm btn-light btn-reply">
                    REPLY
                </button>
                <div class="btn-group comment-actions">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item item-delete-comment"
                           href="<?php echo \yii\helpers\Url::to(['/comment/delete', 'id' => $model->id]) ?>">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>
                    </div>
                </div>
            </div>
            <div class="reply-section">

            </div>
            <div class="sub-comments">
                <?php foreach ($model->comments as $comment): ?>
                    <?php echo $this->render('_comment_item', ['model' => $comment]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
