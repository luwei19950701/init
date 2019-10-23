<?php
/**
 * 工具服务.
 * User: EcareYu
 * Date: 2017/9/27
 * Time: 16:52
 */

namespace EcareYu\Services;

use EcareYu\Exceptions\ApiException;

class UtilService
{

    /**
     * 数据返回
     *
     * @param $message
     * @param array $meta
     * @param null|string $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public static function response($message, $meta = [], $code = null)
    {
        $out = [
            'msg' => $message,
        ];

        // 有必要时才输入出code
        if ($code) {
            $out['code'] = (string) $code;
        }

        if ($meta) {
            // null转换成'' true|false转换成1|0
            array_walk_recursive($meta, function (&$item, $key) {
                if (is_null($item)) {
                    $item = '';
                } elseif (is_bool($item)) {
                    $item = (true === $item) ? 1 : 0;
                }
            });
            $out['meta'] = $meta;
        }

        return response($out);
    }

    /**
     * 错误文字
     *
     * @param $key errors语言包中key
     * @param array $values 变量
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    public static function error($key, $values = [])
    {
        $msg = __(sprintf('errors.%s', $key));
        if (count($values) > 0) {
            foreach ($values as $key => $value) {
                $msg = str_replace("#${key}#", $value, $msg);
            }
            return $msg;
        } else {
            return $msg;
        }
    }

    /**
     * 表单规则错误格式
     *
     * @param $code
     * @param array $values
     * @return array
     */
    public static function rulesErr($code, $values = [])
    {
        return implode('|', [self::error($code, $values), $code]);
    }

    /**
     * 抛异常专用工具
     *
     * @param $code
     * @param array $values
     * @throws ApiException
     */
    public static function thrownErr($code, $values = [])
    {
        throw new ApiException(self::error($code, $values), $code);
    }

    /**
     * 格式化金钱输出
     *
     * @param $price
     * @return string
     */
    public static function priceFormat($price)
    {
        return bcdiv(bcmul($price, 100, 0), 100, 2);
    }
}
