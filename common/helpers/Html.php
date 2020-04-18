<?php
/**
 * User: TheCodeholic
 * Date: 4/18/2020
 * Time: 10:18 AM
 */

namespace common\helpers;


use yii\helpers\Url;

/**
 * Class Html
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package common\helpers
 */
class Html
{
    public static function channelLink($user, $schema = false)
    {
        return \yii\helpers\Html::a($user->username,
            Url::to(['/channel/view', 'username' => $user->username], $schema),
            ['class' => 'text-dark']);
    }
}