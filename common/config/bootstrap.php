<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-18
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@wap', dirname(dirname(__DIR__)) . '/wap');
Yii::setAlias('@data', dirname(dirname(__DIR__)) . '/data');

if(strpos($_SERVER['HTTP_HOST'], 'local.') === 0)
    Yii::setAlias('@dataHost', 'http://local.data.eleteam.com'); //本地地址
else
    Yii::setAlias('@dataHost', 'http://data.eleteam.com'); //外网地址
