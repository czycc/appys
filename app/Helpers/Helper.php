<?php
/**
 * Created by PhpStorm.
 * User: chenzhaoyang
 * Date: 2019-07-19
 * Time: 14:50
 */

/**
 * @param $value
 * @param int $length
 * @return string
 *
 * 摘录的方法实现
 */
function make_excerpt($value, $length = 50)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}

/**
 * @param $num
 * @param int $scale
 * @return \Moontoast\Math\BigNumber
 *
 * 计算decimal数字
 */
function big_num($num, $scale = 2) {
    return new \Moontoast\Math\BigNumber($num, $scale);
}

/**
 * @param $text
 * @return string
 *
 * 去除表情
 */
function emoji_reject($text)
{
    $len = mb_strlen($text);
    $new_text = '';
    for ($i = 0; $i < $len; $i++) {
        $word = mb_substr($text, $i, 1);
        if (strlen($word) <= 3) {
            $new_text .= $word;
        }
    }
    return $new_text;
}
