<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <?php echo $form->errorSummary($model) ?>

                <div class="upload-icon mb-4">
                    <i class="fas fa-upload"></i>
                </div>

                <div>
                    <p class="mb-0">Drag and drop a file you want to upload</p>
                    <p class="text-muted">Your video will be private until you publish it</p>
                </div>

                <div class="btn btn-primary btn-file">
                    Select File
                    <input type="file" id="videoFile" name="video">
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
