<?php
// +----------------------------------------------------------------------
// | ThinkPHP Wechat [Simple Wechat Development Kit For ThinkPHP]
// +----------------------------------------------------------------------
// | ThinkPHP 微信开发工具包
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

namespace think\wechat\utils;

use think\facade\Cache;
use think\wechat\exception\InvalidArgumentException;

/**
 * HTTP请求工具类
 */
class HttpClient
{
    /**
     * 网络缓存
     * @var array
     */
    protected static $cache_curl = [];

    /**
     * 发送GET请求
     * @access public
     * @param string $url 访问URL
     * @param array $query GET参数
     * @param array $headers 请求头
     * @param array $options 其它参数
     * @return boolean|string
     */
    public static function get($url, $query = [], $headers = [], $options = [])
    {
        // 设置GET参数
        $options['query'] = $query;
        // 设置请求头
        $options['headers'] = $headers;
        // 返回请求结果
        return static::doRequest('get', $url, $options);
    }

    /**
     * 以post访问模拟访问
     * @access public
     * @param string $url 访问URL
     * @param array|string $data POST数据
     * @param array $headers 请求头
     * @param array $options
     * @return boolean|string
     */
    public static function post($url, $data = [], $headers = [], $options = [])
    {
        // 设置POST参数
        $options['data'] = $data;
        // 设置请求头
        $options['headers'] = $headers;
        // 返回请求结果
        return static::doRequest('post', $url, $options);
    }

    /**
     * CURL模拟网络请求
     * @access public
     * @param string $method 请求方法
     * @param string $url 请求方法
     * @param array $options 请求参数[headers,data,ssl_cer,ssl_key]
     * @return boolean|string
     * @throws InvalidArgumentException
     */
    public static function doRequest($method, $url, $options = [])
    {
        $curl = curl_init();
        // GET参数设置
        if (!empty($options['query'])) {
            $url .= (stripos($url, '?') !== false ? '&' : '?') . http_build_query($options['query']);
        }
        // CURL头信息设置
        if (!empty($options['headers'])) {
            $headers = [];
            foreach ($options['headers'] as $key => $val) {
                array_push($headers, "$key: $val");
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        // POST数据设置
        if (strtolower($method) === 'post') {
            $postData = '';
            if (!empty($options['data'])) {
                $postData = $options['data'];
            }
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, static::buildHttpData($postData));
        }
        // 证书文件设置
        if (isset($options['ssl_cer']) && !empty($options['ssl_cer'])){
            // 证书不存在
            if (!file_exists($options['ssl_cer'])) {
                throw new InvalidArgumentException('Certificate files that do not exist. --- [ssl_cer]');
            }
            curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($curl, CURLOPT_SSLCERT, $options['ssl_cer']);
        }
        // 证书私钥设置
        if (isset($options['ssl_key']) && !empty($options['ssl_key'])){
            // 私钥不存在
            if (!file_exists($options['ssl_key'])) {
                throw new InvalidArgumentException('Certificate files that do not exist. --- [ssl_key]');
            }
            curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($curl, CURLOPT_SSLKEY, $options['ssl_key']);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        list($content) = [curl_exec($curl), curl_close($curl)];
        // 清理 CURL 缓存文件
        if (!empty(static::$cache_curl)){
            foreach (static::$cache_curl as $key => $file) {
                Cache::delete($file);
                unset(static::$cache_curl[$key]);
            }
        }
        return $content;
    }

    /**
     * POST数据过滤处理
     * @access protected
     * @param array $data 需要处理的数据
     * @param boolean $build 是否编译数据
     * @return array|string
     */
    protected static function buildHttpData($data, $build = true)
    {
        // 不是数组
        if (!is_array($data)){
            return $data;
        }
        // 遍历
        foreach ($data as $key => $value){
            // 是CURLFile对象
            if ($value instanceof \CURLFile) {
                $build = false;
                continue;
            }
            // 普通对象
            if (is_object($value) && isset($value->datatype) && $value->datatype === 'MY_CURL_FILE') {
                $build = false;
                $mycurl = new MyCurlFile((array)$value);
                $data[$key] = $mycurl->get();
                static::$cache_curl[] = $mycurl->tempname;
                continue;
            }
            // 数组
            if (is_array($value) && isset($value['datatype']) && $value['datatype'] === 'MY_CURL_FILE') {
                $build = false;
                $mycurl = new MyCurlFile($value);
                $data[$key] = $mycurl->get();
                static::$cache_curl[] = $mycurl->tempname;
                continue;
            }
            if (is_string($value) && class_exists('CURLFile', false) && stripos($value, '@') === 0) {
                if (($filename = realpath(trim($value, '@'))) && file_exists($filename)) {
                    $build = false;
                    $data[$key] = Tools::createCurlFile($filename);
                    continue;
                }
            }
        }
        // 返回
        return $build ? http_build_query($data) : $data;
    }
}
