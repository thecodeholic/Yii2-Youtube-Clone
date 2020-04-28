<p align="center">
    <a href="#" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">FreeCodeTube - Yii2 Youtube Clone</h1>
    <br>
</p>

#### The project was created while recording [video for FreeCodeCamp](https://youtu.be/whuIf33v2Ug)

Installation
============

## Requirements

The minimum requirement by this project template is that your Web server supports PHP 5.6.0.

## Installing using Composer

##### Clone the repository from github.

    git clone git@github.com:thecodeholic/Yii2-Youtube-Clone.git [YourDirectoryName]
    
The command installs the project in a directory named `YourDirectoryName`. You can choose a different
directory name if you want.

##### Install dependencies

For this we need composer to be installed on our operating system. 
If you do not have [Composer](http://getcomposer.org/), follow the instructions in the
[Installing Yii](https://github.com/yiisoft/yii2/blob/master/docs/guide/start-installation.md#installing-via-composer) section of the definitive guide to install it.

With Composer installed, navigate to the project folder from command line and run

    composer install


## Preparing application

Follow the steps from [yii2 advanced template](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#preparing-application)
to prepare installation.

After doing all the steps from [yii2 advanced template](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#preparing-application)
open `common/config/params-local.php` and add your frontend domain on key `frontendUrl`. 
Example:

```php
return [
    'frontendUrl' => 'http://frontend.test/'
];
```
