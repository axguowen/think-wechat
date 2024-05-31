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

use think\facade\App;
use think\facade\Cache;
use think\wechat\exception\InvalidArgumentException;
use think\wechat\exception\LocalCacheException;

/**
 * 工具类
 */
class Tools
{
    /**
     * 产生随机字符串
     * @access public
     * @param int $length 指定字符长度
     * @param string $str 字符串前缀
     * @return string
     */
    public static function createNoncestr($length = 32, $str = '')
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 获取输入对象
     * @access public
     * @return false|mixed|string
     */
    public static function getRawInput()
    {
        if (empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
            return file_get_contents('php://input');
        } else {
            return $GLOBALS['HTTP_RAW_POST_DATA'];
        }
    }
    
    /**
     * 根据文件后缀获取文件类型
     * @access public
     * @param string|array $ext 文件后缀
     * @param array $mine 文件后缀MINE信息
     * @return string
     */
    public static function getExtMine($ext, $mine = [])
    {
        $mines = static::getMines();
        foreach (is_string($ext) ? explode(',', $ext) : $ext as $e) {
            $mine[] = isset($mines[strtolower($e)]) ? $mines[strtolower($e)] : 'application/octet-stream';
        }
        return join(',', array_unique($mine));
    }

    /**
     * 获取所有文件扩展的类型
     * @access protected
     * @return array
     */
    protected static function getMines()
    {
        $mines = Cache::get('all_ext_mine');
        if (empty($mines)) {
            $content = file_get_contents('http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
            preg_match_all('#^([^\s]{2,}?)\s+(.+?)$#ism', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) foreach (explode(' ', $match[2]) as $ext) $mines[$ext] = $match[1];
            Cache::set('all_ext_mine', $mines, 86400);
        }
        return $mines;
    }

    /**
     * 创建CURL文件对象
     * @access public
     * @param mixed $filename
     * @param string $mimetype
     * @param string $postname
     * @return \CURLFile|string
     */
    public static function createCurlFile($filename, $mimetype = null, $postname = null)
    {
        if (is_string($filename) && file_exists($filename)) {
            if (is_null($postname)){
                $postname = basename($filename);
            }
            if (is_null($mimetype)){
                $mimetype = static::getExtMine(pathinfo($filename, 4));
            }
            if (class_exists('CURLFile')) {
                return new \CURLFile($filename, $mimetype, $postname);
            }
            return "@{$filename};filename={$postname};type={$mimetype}";
        }
        return $filename;
    }

    /**
     * 数组转XML内容
     * @access public
     * @param array $data
     * @return string
     */
    public static function arr2xml($data)
    {
        return '<xml>' . static::arr2xmlField($data) . '</xml>';
    }

    /**
     * XML内容生成
     * @access protected
     * @param array $data 数据
     * @param string $content
     * @return string
     */
    protected static function arr2xmlField($data, $content = '')
    {
        foreach ($data as $key => $val) {
            is_numeric($key) && $key = 'item';
            $content .= "<{$key}>";
            if (is_array($val) || is_object($val)) {
                $content .= static::arr2xmlField($val);
            } elseif (is_string($val)) {
                $content .= '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $val) . ']]>';
            } else {
                $content .= $val;
            }
            $content .= "</{$key}>";
        }
        return $content;
    }

    /**
     * 解析XML内容到数组
     * @access public
     * @param string $xml
     * @return array
     */
    public static function xml2arr($xml)
    {
        if (PHP_VERSION_ID < 80000) {
            $backup = libxml_disable_entity_loader(true);
            $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            libxml_disable_entity_loader($backup);
        } else {
            $data = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
        return json_decode(json_encode($data), true);
    }

    /**
     * 解析XML文本内容
     * @access public
     * @param string $xml
     * @return array|false
     */
    public static function xml3arr($xml)
    {
        $state = xml_parse($parser = xml_parser_create(), $xml, true);
        return xml_parser_free($parser) && $state ? static::xml2arr($xml) : false;
    }

    /**
     * 数组转xml内容
     * @access public
     * @param array $data
     * @return null|string
     */
    public static function arr2json($data)
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        return $json === '[]' ? '{}' : $json;
    }

    /**
     * 解析JSON内容到数组
     * @access public
     * @param string $json
     * @return array
     * @throws InvalidArgumentException
     */
    public static function json2arr($json)
    {
        // 转换成数组
        $result = json_decode($json, true);
        // 转换失败
        if (!is_array($result)) {
            throw new InvalidArgumentException('invalid json string.', '0', ['json' => $json]);
        }
        // 返回
        return $result;
    }

    /**
     * 数组对象Emoji编译处理
     * @access public
     * @param array $data
     * @return array
     */
    public static function buildEnEmojiData(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = static::buildEnEmojiData($value);
            } elseif (is_string($value)) {
                $data[$key] = static::emojiEncode($value);
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * 数组对象Emoji反解析处理
     * @access public
     * @param array $data
     * @return array
     */
    public static function buildDeEmojiData(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = static::buildDeEmojiData($value);
            } elseif (is_string($value)) {
                $data[$key] = static::emojiDecode($value);
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    /**
     * Emoji原形转换为String
     * @access public
     * @param string $content
     * @return string
     */
    public static function emojiEncode($content)
    {
        return json_decode(preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i", function ($string) {
            return addslashes($string[0]);
        }, json_encode($content)));
    }

    /**
     * Emoji字符串转换为原形
     * @access public
     * @param string $content
     * @return string
     */
    public static function emojiDecode($content)
    {
        return json_decode(preg_replace_callback('/\\\\\\\\/i', function () {
            return '\\';
        }, json_encode($content)));
    }

    /**
     * 写入文件
     * @access public
     * @param string $name 文件名称
     * @param string $content 文件内容
     * @return string
     * @throws LocalCacheException
     */
    public static function pushFile($name, $content)
    {
        // 构造文件名
        $file = static::getCacheFileName($name);
        // 写入失败
        if (!file_put_contents($file, $content)) {
            throw new LocalCacheException('local file write error.', '0');
        }
        // 返回文件名
        return $file;
    }

    /**
     * 应用缓存目录
     * @access protected
     * @param string $name
     * @return string
     */
    protected static function getCacheFileName($name)
    {
        // 构造缓存目录
        $cachePath = App::getRuntimePath() . 'cache' . DIRECTORY_SEPARATOR . 'think-wechat' . DIRECTORY_SEPARATOR;
        // 目录不存在
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }
        return $cachePath . $name;
    }
}
