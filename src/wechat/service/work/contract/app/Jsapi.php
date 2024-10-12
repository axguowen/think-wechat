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

namespace think\wechat\service\work\contract\app;

use think\wechat\Service;
use think\wechat\utils\Tools;

/**
 * 企业微信应用JSAPI服务基础类
 */
abstract class Jsapi extends Service
{
    /**
     * 获取企业的jsapi_ticket
     * @access public
     * @return array
     */
    public function getCorpTicket()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取应用的jsapi_ticket
     * @access public
     * @return array
     */
    public function getTicket()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/ticket/get?access_token=ACCESS_TOKEN&type=agent_config';
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取应用的jsapi签名
     * @access public
     * @param string $url
     * @param string $jsapiTicket
     * @return array
     */
    public function getSignature($url, $jsapiTicket)
    {
        // 构造随机数
        $nonceStr = Tools::createNoncestr(16);
        // 构造时间戳
        $timestamp = time();
        // 获取签名结果
        $signResult = static::signature([
            'jsapi_ticket' => $jsapiTicket,
            'noncestr' => $nonceStr,
            'timestamp' => $timestamp,
            'url' => $url,
        ]);
        // 失败
        if(is_null($signResult[0])){
            return $signResult;
        }
        // 成功
        return [[
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'signature' => $signResult[0],
        ], null];
    }

    /**
     * 数据生成签名
     * @access public
     * @param array $data 签名数组
     * @param string $method 签名方法
     * @param array $params 签名参数
     * @return bool|string 签名值
     */
    public static function signature($data, $method = 'sha1', $params = [])
    {
        ksort($data);
        if (!function_exists($method)){
            return [null, new \Exception('签名方法不存在')];
        }
        foreach ($data as $k => $v){
            $params[] = "{$k}={$v}";
        }
        return [$method(join('&', $params)), null];
    }
}