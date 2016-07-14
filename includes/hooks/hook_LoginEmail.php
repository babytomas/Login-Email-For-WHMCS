<?php
/**
 * @author Tomas <mail@cheuknang.cn>
 * @link https://www.zntec.cn/
 * @version 1.0.0
 */

// 常量检查，仅允许 WHMCS 访问
if(!defined("WHMCS")){
    die("This file cannot be accessed directly");
}

/**
 * 声明一个别名，稍候我们要使用 Capsule
 * 有关文档：http://docs.whmcs.com/SQL_Helper_Functions
 */
use Illuminate\Database\Capsule\Manager as Capsule;

// 改为 ClientAreaHomepage 可以打开客户中心首页测试，改为 ClientLogin 将在登陆后执行
add_hook('ClientLogin', 1, function ($vars){
    /**
     * 使用 Capsule 读取 WHMCS 管理员用户名，用于 API，这样就不必你自己输入了
     * 有关文档：https://laravel.com/docs/4.2/queries
     */
    $whmcsadmin = Capsule::table('tbladmins')->select('username')->first(); // 返回一个对象

    /**
     * 判断是否管理员登陆，不是管理员登陆我们才发邮件
     */
    if ($_SESSION['adminid'] == false) {
        $command = "sendemail";
        $values["messagename"] = "Login Prompt";
        $values["id"] = $vars['userid'];
        /**
         * 使用内部 API 发信
         * 有关文档：http://docs.whmcs.com/API:Send_Email
         */
        localAPI($command, $values, $whmcsadmin->username);
    }
});
