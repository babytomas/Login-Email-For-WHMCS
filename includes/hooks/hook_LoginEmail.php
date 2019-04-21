<?php
/**
 * @author Tomas <mail@cheuknang.cn>
 * @link https://www.geebastudio.com/
 * @version 1.0.1
 */

use WHMCS\Database\Capsule;

/**
 * 禁止非 WHMCS 访问
 */
defined('WHMCS') OR die('Access denied');

/**
 * 注册钩子 ( 改为 ClientAreaHomepage 可以打开客户中心首页测试 )
 */
add_hook('ClientLogin', 1, function ($vars)
{
    /**
     * 非管理员登录则发信
     */
    $_SESSION['adminid'] OR localAPI(
        'sendemail',
        [
            'messagename' => 'Login Prompt',
            'id' => $vars['userid']
        ],
        Capsule::table('tbladmins')
            ->select('username')
            ->first()->username
    );
});
