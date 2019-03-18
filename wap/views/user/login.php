<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $reload_page string
 */
?>
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">用户登录</div>
    </div>
</div>
<div class="page no-tabbar" data-page="user-login">
    <div class="page-content user-login">
            <form action="<?=Url::toRoute('user/login')?>" class="login-form">
                <input name="_csrf" type="hidden" value="<?=Yii::$app->request->csrfToken?>">
                <div class="item username"><img src="../image/login01.png" alt=""><input type="text" placeholder="手机号" name="username"></div>
                <div class="item password"><img src="../image/login02.png" alt=""><input type="password" placeholder="密码" name="password"></div>
                <div class="btn login-btn" data-reload-page="<?=Url::toRoute($reload_page)?>">登  录</div>
            </form>
            <div class="loginmore">
                <span class="forget">忘记密码？</span>
                <a class="phone" href="<?=Url::toRoute('/user/signup?reload_page='.$reload_page)?>">立即注册</a>
            </div>
    </div>
</div>
