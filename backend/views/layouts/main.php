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
                        <a class="nav-link" href="#">Create</a>
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
