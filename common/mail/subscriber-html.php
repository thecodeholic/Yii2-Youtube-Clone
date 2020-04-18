<?php
/**
 * User: TheCodeholic
 * Date: 4/18/2020
 * Time: 10:27 AM
 */
/** @var $channel \common\models\User */
/** @var $user \common\models\User */
?>

<p>Hello <?php echo $channel->username ?></p>
<p>User <?php echo \common\helpers\Html::channelLink($user, true) ?>
    has subscribed to you</p>

<p>FreeCodeTube team</p>

