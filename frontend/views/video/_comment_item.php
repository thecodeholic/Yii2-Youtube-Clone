<?php
/**
 * User: TheCodeholic
 * Date: 11/12/2020
 * Time: 9:19 AM
 */

/** @var $model \common\models\Comment */

$subCommentCount = $model->getComments()->count();
?>

<div class="comment-item <?php echo $model->pinned ? 'pinned-comment' : ''?>" data-parent-id="<?php echo $model->parent_id ?>" data-id="<?php echo $model->id ?>">
    <div class="media media-comment">
        <img class="mr-3 comment-avatar" src="/img/avatar.svg" alt="">
        <div class="media-body">
            <h6 class="mt-0">
                <?php if ($model->pinned): ?>
                    <div class="pinned-text text-muted mb-1">
                        <i class="fas fa-thumbtack"></i> Pinned comment
                    </div>
                <?php endif; ?>
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
                        <span class="badge bg-info"><?php echo '@'.$model->mention ?></span>
                    <?php endif; ?>
                    <?php echo $model->comment ?>
                </div>

                <div class="bottom-actions my-2">
                    <button data-action="<?php echo \yii\helpers\Url::to(['/comment/reply']) ?>"
                            class="btn btn-sm btn-light btn-reply">
                        REPLY
                    </button>
                </div>
                <div class="reply-section">

                </div>
                <?php if ($subCommentCount): ?>
                    <div class="mb-2">
                        <a href="<?php echo \yii\helpers\Url::to(['/comment/by-parent', 'id' => $model->id]) ?>"
                           class="view-sub-comments">View <?php echo $subCommentCount ?> replies</a>
                    </div>
                <?php endif; ?>
                <div class="sub-comments">

                </div>
            </div>
            <?php if ($model->belongsTo(Yii::$app->user->id) || $model->video->belongsTo(Yii::$app->user->id)): ?>
                <div class="dropdown comment-actions">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <?php if (!$model->parent_id && $model->video->belongsTo(Yii::$app->user->id)): ?>
                            <a class="dropdown-item item-pin-comment"
                               data-pinned="<?php echo $model->pinned ?>"
                               href="<?php echo \yii\helpers\Url::to(['/comment/pin', 'id' => $model->id]) ?>">
                                <i class="fas fa-thumbtack"></i>
                                <?php if ($model->pinned): ?>
                                    Unpin
                                <?php else: ?>
                                    Pin
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($model->belongsTo(Yii::$app->user->id)): ?>
                            <a class="dropdown-item item-edit-comment" href="#">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                        <?php endif; ?>
                        <a class="dropdown-item item-delete-comment"
                           href="<?php echo \yii\helpers\Url::to(['/comment/delete', 'id' => $model->id]) ?>">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="media media-input">
        <img class="mr-3 comment-avatar" src="/img/avatar.svg" alt="">
        <div class="media-body">
            <form class="comment-edit-section" method="post"
                  action="<?php echo \yii\helpers\Url::to(['/comment/update', 'id' => $model->id]) ?>">
            <textarea rows="1"
                      class="form-control"
                      name="comment"
                      placeholder="Add a public comment"></textarea>
                <div class="action-buttons text-right mt-2">
                    <button type="button" class="btn btn-light btn-cancel">Cancel</button>
                    <button class="btn btn-primary btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
