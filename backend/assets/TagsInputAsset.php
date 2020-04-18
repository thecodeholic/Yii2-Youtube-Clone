<?php
/**
 * User: TheCodeholic
 * Date: 4/17/2020
 * Time: 11:12 AM
 */

namespace backend\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class TagsInputAsset
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package backend\assets
 */
class TagsInputAsset extends AssetBundle
{
    public $basePath = '@webroot/tagsinput';
    public $baseUrl = '@web/tagsinput';
    public $css = [
        'tagsinput.css'
    ];

    public $js = [
        'tagsinput.js'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}