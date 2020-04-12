<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo Yii::$app->homeUrl ?>"><?php echo Yii::$app->name ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo \yii\helpers\Url::to(['/site/login']) ?>">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="#videoModal" data-toggle="modal">Create</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo \yii\helpers\Url::to(['/site/logout']) ?>"
                           data-method="post">
                            Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>


    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center">
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
    </div>

    <main class="d-flex">
        <aside style="min-width: 200px;">
            <?php echo Nav::widget([
                'options' => ['class' => 'nav-pills flex-column'],
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'url' => ['/site/index']
                    ],
                    [
                        'label' => 'Videos',
                        'url' => ['/video/index']
                    ],
                ]
            ]) ?>
        </aside>

        <div class="content-wrapper p-3" style="flex: 1">
            <?= $content ?>
        </div>
    </main>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
