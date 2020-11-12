<?php
/**
 * User: TheCodeholic
 * Date: 11/12/2020
 * Time: 9:19 AM
 */

/** @var $model \common\models\Comment */

?>

<div class="media comment-item mb-3">
    <img class="mr-3 comment-avatar" src="/img/avatar.svg" alt="">
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
                <?php echo $model->comment ?>
            </div>

            <div>
                <button class="btn btn-sm btn-light">
                    REPLY
                </button>
            </div>
        </div>
        <form class="comment-edit-section" method="post" action="<?php echo \yii\helpers\Url::to(['/comment/update', 'id' => $model->id]) ?>">
            <textarea rows="1"
                      class="form-control"
                      name="comment"
                      placeholder="Add a public comment"></textarea>
            <div class="action-buttons text-right mt-2">
                <button type="button" class="btn btn-light btn-cancel">Cancel</button>
                <button class="btn btn-primary btn-save">Save</button>
            </div>
        </form>
        <?php if ($model->belongsTo(Yii::$app->user->id) || $model->video->belongsTo(Yii::$app->user->id)): ?>
            <div class="dropdown comment-actions">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <?php if ($model->video->belongsTo(Yii::$app->user->id)): ?>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-thumbtack"></i> Pin
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
