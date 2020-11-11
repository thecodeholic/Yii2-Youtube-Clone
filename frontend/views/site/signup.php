<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="container">
        <h1 class="mb-5"><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-warning">
            <h4>This feature is disabled in demo version.</h4>
            <h4>Please try to <a href="<?php echo \yii\helpers\Url::to(['/site/login']) ?>">Login</a> instead.</h4>
        </div>
    </div>

</div>
