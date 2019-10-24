<?php

namespace App\Http\Controllers\Api;

use Project\Services\HandleService as Handle;
use Project\Services\UtilService as Util;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class BaseController extends Controller
{
    /**
     * 输出
     *
     * @param $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($message, $data = [])
    {
        return Util::response($message, $data);
    }

    /**
     * 处理表单验证报错
     *
     * @param Validator $validator
     * @throws \Project\Exceptions\ApiException
     */
    protected function validatorErrors(Validator $validator)
    {
        return Handle::validatorErrors($validator);
    }

    /**
     * 验证规则信息
     *
     * @param string $code 错误编号
     * @param array $values
     * @return array
     */
    protected function ruleMsg($code, $values = [])
    {
        return Util::rulesErr($code, $values);
    }

    /**
     * 抛出API用的异常
     *
     * @param $code
     * @param array $values
     * @throws \Project\Exceptions\ApiException
     */
    protected function thrown($code, $values = [])
    {
        return Util::thrownErr($code, $values);
    }
}
