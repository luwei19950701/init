<?php
/**
 * Code里面错误编码对应的输出文案.
 * User: ecareyu
 * Date: 2018/6/20
 * Time: 16:39
 */

use App\Constracts\Code;

return [
    Code::E_AUTH_NAME_REQUIRED => '请输入用户名',
    Code::E_AUTH_PASSWORD_REQUIRED => '请输入密码',
    Code::E_AUTH_LOGIN_FAILED => '登录失败',
    Code::E_AUTH_TOKEN_CREATE_FAILED => '登录令牌创建失败',
    Code::E_AUTH_NAME_MIN_LENGTH => '至少:min位',
    Code::E_AUTH_TOKEN_REFRESH_FAILED => '登录令牌更新失败',
    Code::E_AUTH_REFRESH_TOKEN_REQUIRED => '缺失更新令牌',
];
