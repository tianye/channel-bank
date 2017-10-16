<?php

namespace ChannelBank\Support;

class FromMatching
{
    // 获取页面中的 form 表单中的所有 input、textarea 元素中 name、value、type 等属性值
    static public function get_page_form_data($content)
    {
        $arr_form = [];
        $form     = self::regular_form_tags($content);
        for ($i = 0; $i < count($form[0]); $i++) {
            $arr_form[$i]['action'] = self::regular_form_action($form[1][$i]);
            $arr_form[$i]['method'] = self::regular_form_method($form[1][$i]);
            $input                  = self::regular_input_tags($form[2][$i]);
            for ($j = 0; $j < count($input[0]); $j++) {
                $arr_form[$i]['inputs'][$j]['name']  = self::regular_input_name($input[0][$j]);
                $arr_form[$i]['inputs'][$j]['type']  = self::regular_input_type($input[0][$j]);
                $arr_form[$i]['inputs'][$j]['value'] = self::regular_input_value($input[0][$j]);
            }
            $textarea = self::regular_textarea_tags($form[2][$i]);
            for ($k = 0; $k < count($textarea); $k++) {
                $arr_form[$i]['textarea'][$k]['name']  = self::regular_textarea_name($textarea[$k]);
                $arr_form[$i]['textarea'][$k]['value'] = self::regular_textarea_value($textarea[$k]);
            }
            $select = self::regular_select_tags($form[2][$i]);
            for ($l = 0; $l < count($select[0]); $l++) {
                $arr_form[$i]['select'][$l]['name'] = self::regular_select_name($select[1][$l]);
                $option                             = self::regular_option_tags($select[2][$l]);
                for ($n = 0; $n < count($option[$l]); $n++) {
                    $arr_form[$i]['select'][$l]['option'][$n] = self::regular_option_value($option[$l][$n]);
                }
            }
        }

        return $arr_form;
    }

    // 正则匹配 form 标签
    static public function regular_form_tags($string)
    {
        $pattern = '/<form(.*?)>(.*?)<\/form>/si';
        preg_match_all($pattern, $string, $result);

        return $result;
    }

    // 正则匹配 form 标签的 action 属性值
    static public function regular_form_action($string)
    {
        $pattern = '/action[\s]*?=[\s]*?([\'\"])(.*?)\1/';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 form 标签的 method 属性值
    static public function regular_form_method($string)
    {
        $pattern = '/method[\s]*?=[\s]*?([\'\"])(.*?)\1/';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 input 标签
    static public function regular_input_tags($string)
    {
        $pattern = '/<input.*?\/?>/si';
        if (preg_match_all($pattern, $string, $result)) {
            return $result;
        }

        return null;
    }

    // 正则匹配 input 标签的 name 属性值
    static public function regular_input_name($string)
    {
        $pattern = '/name[\s]*?=[\s]*?([\'\"])(.*?)\1/';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 input 标签的 type 属性值
    static public function regular_input_type($string)
    {
        $pattern = '/type[\s]*?=[\s]*?([\'\"])(.*?)\1/';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 input 标签的 value 属性值
    static public function regular_input_value($string)
    {
        $pattern = '/value[\s]*?=[\s]*?([\'\"])(.*?)\1/';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 textarea 标签
    static public function regular_textarea_tags($string)
    {
        $pattern = '/(<textarea.*?>.*?<\/textarea[\s]*?>)/si';
        if (preg_match_all($pattern, $string, $result)) {
            return $result[1];
        }

        return null;
    }

    // 正则匹配 textarea 标签的 name 属性值
    static public function regular_textarea_name($string)
    {
        $pattern = '/name[\s]*?=[\s]*?([\'\"])(.*?)\1/si';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 textarea 标签的 name 属性值
    static public function regular_textarea_value($string)
    {
        $pattern = '/<textarea.*?>(.*?)<\/textarea>/si';
        if (preg_match($pattern, $string, $result)) {
            return $result[1];
        }

        return null;
    }

    // 正则匹配 select 标签
    static public function regular_select_tags($string)
    {
        $pattern = '/<select(.*?)>(.*?)<\/select[\s]*?>/si';
        preg_match_all($pattern, $string, $result);

        return $result;
    }

    // 正则匹配 select 标签的 option 子标签
    static public function regular_option_tags($string)
    {
        $pattern = '/<option(.*?)>.*?<\/option[\s]*?>/si';
        preg_match_all($pattern, $string, $result);

        return $result;
    }

    // 正则匹配 select 标签的 name 属性值
    static public function regular_select_name($string)
    {
        $pattern = '/name[\s]*?=[\s]*?([\'\"])(.*?)\1/si';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }

    // 正则匹配 select 的子标签 option 的 value 属性值
    static public function regular_option_value($string)
    {
        $pattern = '/value[\s]*?=[\s]*?([\'\"])(.*?)\1/si';
        if (preg_match($pattern, $string, $result)) {
            return $result[2];
        }

        return null;
    }
}