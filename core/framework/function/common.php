<?php
/**
 * 公共方法
 *
 *
 * @海吉壹佰提供技术支持 授权请申请
 * @license    http://www.ccynet.cn/
 * @link       http://www.ccynet.cn/
 */

// 浏览器友好的变量输出
function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

function isSsl()
{
    if ($_SERVER['HTTPS'] && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))) {
        return true;
    } elseif ('https' == $_SERVER['REQUEST_SCHEME']) {
        return true;
    } elseif ('443' == $_SERVER['SERVER_PORT']) {
        return true;
    } elseif ('https' == $_SERVER['HTTP_X_FORWARDED_PROTO']) {
        return true;
    }

    return false;
}

function scheme()
{
    return isSsl() ? 'https' : 'http';
}

function domain($port = false)
{
    return scheme() . '://' . host($port);
}

/**
 * 当前请求的host
 * @access public
 * @param bool $strict true 仅仅获取HOST
 * @return string
 */
function host($strict = false)
{
    return $_SERVER['HTTP_X_REAL_HOST'] ?: $_SERVER['HTTP_HOST'];
    return true === $strict && strpos($host, ':') ? strstr($host, ':', true) : $host;
}