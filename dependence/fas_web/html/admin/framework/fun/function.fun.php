<?php

use framework\libs\D;
use framework\conf\Config;

function stime()
{
    //返回系统时间
    return $_SERVER['REQUEST_TIME'];
}

function db($table)
{
    return new D($table);
}


function html_encode($content, $style = ENT_QUOTES)
{
    return htmlspecialchars($content, $style);
}

function html_decode($content, $style = ENT_QUOTES)
{
    return htmlspecialchars_decode($content, $style);
}

function str_length($str)
{
    if (empty($str)) {
        return 0;
    }
    if (function_exists('mb_strlen')) {
        return mb_strlen($str, 'utf-8');
    } else {
        preg_match_all("/./u", $str, $ar);
        return count($ar[0]);
    }
}

function checkStr($str)
{
    $output = '';
    $a = ereg('/[^' . chr(0xa1) . '-' . chr(0xff) . '0-9a-zA-Z_\.]/', $str);
    if (!$a) {
        return 8;
    }
}

/* * ************************************************************
 *  生成指定长度的随机码。
 *  @param int $length 随机码的长度。
 *  @access public
 * ************************************************************ */

function createRandomCode($length)
{
    $randomCode = "";
    $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $randomChars{mt_rand(0, 35)};
    }
    return $randomCode;
}

/* * ************************************************************
 *  将物理路径转为虚拟路径。
 *  @param string $physicalPpath 物理路径。
 *  @access public
 * ************************************************************ */

function toVirtualPath($physicalPpath)
{
    $virtualPath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $physicalPpath);
    $virtualPath = str_replace('\\', '/', $virtualPath);
    return $virtualPath;
}

function get_ip()
{
    if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    } elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) {
        $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
    } elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) {
        $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknown";
    }
    return $ip;
}

function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        $mobile_browser++;
    }
    if (isset($_SERVER['HTTP_PROFILE'])) {
        $mobile_browser++;
    }
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
        $mobile_browser++;
    }
    // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) {
        $mobile_browser = 0;
    }
    // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
        $mobile_browser++;
    }
    if ($mobile_browser > 0) {
        return true;
    } else {
        return false;
    }
}


function createUri($path = [], $parms = null, $query = null)
{
    $path[0] = empty($path[0]) ? strtolower(Route::$c) : strtolower($path[0]);
    $path[1] = empty($path[1]) ? strtolower(Route::$a) : strtolower($path[1]);
    $uri = implode("/", $path);
    if ($parms != null) {
        $uri .= "/" . implode("/", $parms);
    }
    $port = $_SERVER["SERVER_PORT"] == '80' ? '' : ':' . $_SERVER["SERVER_PORT"];
    $url_params = $query == null ? "" : "?" . http_build_query($query);
    if (\framework\conf\Config::$if_show_index) {
        $app = "/" . Application_home . "/";
    } else {
        $app = "/";
    }
    $url_path = $app . $uri . $url_params;
    return $url_path;
}

function url($path = [], $parms = null, $query = null)
{
    return createUri($path,$parms,$query);
}

function parseResponse($arr)
{
    die(json_encode($arr));
}

function _G($varname)
{
    return $_GET[$varname];
}

function _P($varname)
{
    return $_POST[$varname];
}

function header_location($url)
{
    header("location: " . $url);
    exit;
}

