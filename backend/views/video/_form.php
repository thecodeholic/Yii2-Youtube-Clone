<?php

use common\models\Video;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */

\backend\assets\TagsInputAsset::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-sm-8">

            <div class="form-group">
                <label>Thumbnail</label>
                <div class="custom-file">
                    <input type="file"
                           class="custom-file-input<?php echo $model->hasErrors('thumbnail') ? ' is-invalid' : '' ?>"
                           id="thumbnail" name="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                    <div class="invalid-feedback"><?php echo $model->getFirstError('thumbnail') ?></div>
                </div>
            </div>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'tags', [
                'inputOptions' => ['data-role' => 'tagsinput']
            ])->textInput() ?>
        </div>
        <div class="col-sm-4">
            <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item"
                       poster="<?php echo $model->getThumbnailUrl() ?>"
                       src="<?php echo $model->getVideoUrl() ?>" controls>
                </video>
            </div>
            <p class="mt-3">
                <a href="<?php echo $model->getVideoUrl() ?>" target="_blank">
                    Open Video
                </a>
            </p>
            <p class="mt-3">
                <small>Video name</small><br>
                <?php echo $model->video_name ?>
            </p>

            <?= $form->field($model, 'status')->dropDownList(Video::getStatusLabels()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
