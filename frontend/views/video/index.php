<?php
/**
 * User: TheCodeholic
 * Date: 4/17/2020
 * Time: 11:56 AM
 */
/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Popular videos | '. Yii::$app->name;
?>

<?php echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'class' => \yii\bootstrap4\LinkPager::class,
    ],
    'itemView' => '_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
]) ?>
