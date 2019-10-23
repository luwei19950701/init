<?php
/**
 * 错误编码定义处.
 * User: ecareyu
 * Date: 2018/6/20
 * Time: 15:43
 */

namespace App\Constracts;

/*
 * 命名规则：
 * 模块名-错误编号
 * 例如:E01-1001
 */

interface Code
{
    const E_AUTH_NAME_REQUIRED = 'E01-1001';         // 请输入用户名
    const E_AUTH_PASSWORD_REQUIRED = 'E01-1002';     // 请输入密码
    const E_AUTH_LOGIN_FAILED = 'E01-1003';          // 登录失败
    const E_AUTH_TOKEN_CREATE_FAILED = 'E01-1004';   // 登录令牌创建失败
    const E_AUTH_NAME_MIN_LENGTH = 'E01-1005';       // 用户名最小长度
    const E_AUTH_TOKEN_REFRESH_FAILED = 'E01-1005';   // 登录令牌更新失败
    const E_AUTH_REFRESH_TOKEN_REQUIRED = 'E01-1006'; // 缺少更新令牌
}
