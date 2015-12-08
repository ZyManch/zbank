<?php
/**
 * Created by PhpStorm.
 * User: ZyManch
 * Date: 25.04.14
 * Time: 16:19
 */
function array_merge_config() {
    $result = array();
    foreach (func_get_args() as $config) {
        foreach ($config as $key => $value) {
            if (is_numeric($key)) {
                $result[] = $value;
            } else if (isset($result[$key]) && is_array($result[$key])) {
                $result[$key] = array_merge_config($result[$key], $value);
            } else {
                $result[$key] = $value;
            }
        }
    }
    return $result;
}

function pr() {
    print '<pre>';
    foreach (func_get_args() as $arg) {
        var_export($arg);
        print '<hr>';
    }
    print '</pre>';
    die();
}