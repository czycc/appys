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