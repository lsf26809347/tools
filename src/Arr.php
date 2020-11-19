<?php

namespace lens;


class Arr
{
    /**
     * 返回数组的（key）奇数数组
     * @param $arr
     * @return array
     */
    public static function filterOddKey(array $arr) : array
    {
        return array_filter(
            array_values($arr),
            function ($value) {
                return $value & 1;
            },
            ARRAY_FILTER_USE_KEY
        );
    }
    
    /**
     * 返回数组的（key）偶数数组
     * @param array $arr
     * @return array
     */
    public static function filterEvenKey(array $arr) : array
    {
        return array_filter(
            array_values($arr),
            function ($value) {
                return !($value & 1);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
    
    /**
     * 二维数组排序（以指定的二维数组中的KEY排序）
     * @param array $array
     * @param string $on
     * @param int $order
     * @return array
     */
    public static function array_sort(array $array, string $on, $order = SORT_ASC) : array
    {
        $new_array = [];
        $sortable_array = [];
        
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
                //            array_push($new_array, $array[$k]);
            }
        }
        
        return $new_array;
    }
    
    
    /**
     * 对象转数组
     * @param $object
     * @return mixed
     */
    public static function objectToarray($object) : array
    {
        $array = [];
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        } else {
            $array = $object;
        }
        
        return $array;
    }
    
    
    /**
     * 计算多个数组的笛卡尔积
     * @param array $array
     * @return array
     */
    public static function cartesianProduct(array $array) : array
    {
        $res = [];
        
        for ($i = 0; $i < count($array) - 1; $i++) {
            if ($i == 0) {
                $res = $array[$i];
            }
            
            $temp = [];
            
            foreach ($res as $value) {
                foreach ($array[$i + 1] as $v) {
                    $temp[] = array_merge((array)$value, (array)$v);
                }
            }
            $res = $temp;
        }
        
        return $res;
    }
    
    /**
     * 计算带KEY的笛卡尔积
     * @param array $array
     * @return array
     */
    public static function cartesianProductWithKey(array $array) : array
    {
        $res = [];
        
        for ($i = 0; $i < count($array); $i++) {
            if ($i == 0) {
                $res = $array[$i];
            }
            
            $temp = [];
            
            foreach ($res as $key => $value) {
                $value = is_array($value) ? $value : [$key => $value];
                if (isset($array[$i + 1])) {
                    foreach ($array[$i + 1] as $k => $v) {
                        $temp[] = (array)$value + [$k => $v];
                    }
                } else {
                    $temp[] = $value;
                }
            }
            $res = $temp;
        }
        
        return $res;
    }
}