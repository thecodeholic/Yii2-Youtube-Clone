<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'tags')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <div class="embed-responsive embed-responsive-16by9">
                <video class="embed-responsive-item" src="<?php echo $model->getVideoUrl() ?>" controls></video>
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

            <?= $form->field($model, 'status')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
