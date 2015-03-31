<?php
/**
 * Created by PhpStorm.
 * User: yunlong
 * Date: 14-8-18
 * Time: 下午6:09
 */

if ( ! function_exists('array_add_key'))
{
    function array_add_key($result,$key) {
        if(empty($key)) {
            return $result;
        } else {
            $keyResult = array();
            foreach($result as $v) {
                $keyResult[$v[$key]] = $v;
            }
            return $keyResult;
        }
    }
}

if ( ! function_exists('array_add_rank'))
{
    function array_add_rank($data) {
        $rank = 1;
        foreach($data as &$v) {
            $v['rank'] = $rank++;
        }
        return $data;
    }
}

if ( ! function_exists('array_combine_k_v'))
{
    function array_combine_k_v($key,$value,$default=array()) {
        $result = array();
        foreach($value as $lineData){
            $lineResult = [];
            foreach($lineData as $k => $v) {
                if(isset($key[$k])) {
                    $lineResult[$key[$k]] = $v;
                }
            }
            $result[] = $lineResult + $default;
        }
        return $result;
    }
}