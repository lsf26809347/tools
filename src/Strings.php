<?php

namespace lens;


class Strings
{
    /**
     * 隐藏手机号中间四位
     * @param $phone
     * @return string|string[]|null
     */
    public static function hidetel($phone)
    {
        $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i', $phone); //固定电话
        if ($IsWhat == 1) {
            return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i', '$1****$2', $phone);
        } else {
            return preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
        }
    }
    
    /**
     * 获取字符串开头一部分
     *
     * @param $string
     * @param int $length
     * @return string
     */
    function brief($string, $length = 300)
    {
        return mb_strlen($string) > $length ? mb_substr($string, 0, $length).'...' : $string;
    }
    
    /**
     * 随机字符
     * @param int $length 长度
     * @param string $type 类型，可以传入已有类型，也可以直接传入要生成随机码的字符串
     * @param int $convert 转换大小写 1大写 0小写
     * @return mixed
     */
    public static function random($length = 10, $type = 'letter', $convert = 0)
    {
        $config = [
            'number' => '1234567890',
            'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
            'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ];
        
        $string = $config[$type] ?? $type;
        
        $code = '';
        $strlen = strlen($string) - 1;
        for ($i = 0; $i < $length; $i++) {
            $code .= $string{mt_rand(0, $strlen)};
        }
        if (!empty($convert)) {
            $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
        }
        
        return $code;
    }
    
    
    /**
     * 数字转换为中文
     * @param string|integer|float $num 目标数字
     * @param bool $mode 模式[true:金额（默认）,false:普通数字表示]
     * @param boolean $sim 使用小写（默认）
     * @return string
     */
    public static function number2chinese($num, $mode = true, $sim = true)
    {
        if (!is_numeric($num)) {
            return '含有非数字非小数点字符！';
        }
        $char = $sim ? ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'] : [
            '零',
            '壹',
            '贰',
            '叁',
            '肆',
            '伍',
            '陆',
            '柒',
            '捌',
            '玖',
        ];
        $unit = $sim ? ['', '十', '百', '千', '', '万', '亿', '兆'] : ['', '拾', '佰', '仟', '', '萬', '億', '兆'];
        //    $retval  = $mode ? '元':'点';
        $retval = '';
        
        //小数部分
        if (strpos($num, '.')) {
            $retval = '点';
            list($num, $dec) = explode('.', $num);
            $dec = strval(round($dec, 2));
            if ($mode) {
                //            $retval .= "{$char[$dec[0]]}角{$char[$dec[1]??0]}分";
                for ($i = 0, $c = strlen($dec); $i < $c; $i++) {
                    $retval .= $char[$dec[$i]];
                }
            } else {
                for ($i = 0, $c = strlen($dec); $i < $c; $i++) {
                    $retval .= $char[$dec[$i]];
                }
            }
        }
        
        //整数部分
        $str = $mode ? strrev(intval($num)) : strrev($num);
        $out = [];
        for ($i = 0, $c = strlen($str); $i < $c; $i++) {
            $out[$i] = $char[$str[$i]];
            if ($mode) {
                $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';
                if ($i >= 1 && $str[$i] + $str[$i - 1] == 0) {
                    $out[$i] = '';
                }
                if ($i % 4 == 0) {
                    if ($str[$i] == 0 && $c > 1) {
                        $out[$i] = '';
                    }
                    $out[$i] .= $unit[4 + floor($i / 4)];
                }
            }
        }
        
        $retval = join('', array_reverse($out)).$retval;
        
        return $retval;
        
    }
}