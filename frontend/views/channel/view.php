<?php
/**
 * User: TheCodeholic
 * Date: 4/18/2020
 * Time: 9:50 AM
 */

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $channel \common\models\User */
/**@var $dataProvider \yii\data\ActiveDataProvider */
?>

<div class="jumbotron">
    <h1 class="display-4"><?php echo $channel->username ?></h1>
    <hr class="my-4">
    <?php \yii\widgets\Pjax::begin() ?>
    <?php echo $this->render('_subscribe', [
        'channel' => $channel
    ]) ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>

<?php echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/video/_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
]) ?>
