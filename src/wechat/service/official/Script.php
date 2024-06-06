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

namespace think\wechat\service\official;

use think\facade\Cache;
use think\wechat\Service;
use think\wechat\utils\Tools;
use think\wechat\exception\InvalidResponseException;
use think\wechat\exception\InvalidArgumentException;

/**
 * 微信前端支持
 */
class Script extends Service
{
    /**
     * 删除JSAPI授权TICKET
     * @access public
     * @param string $type TICKET类型(wx_card|jsapi)
     * @param string $appid 强制指定有效APPID
     * @return array
     */
    public function delTicket($type = 'jsapi', $appid = null)
    {
        is_null($appid) && $appid = $this->config->get('appid');
        $cacheKey = 'official_ticket_' . $type . '_' . $appid;
        Cache::delete($cacheKey);
        return ['操作成功', null];
    }

    /**
     * 获取JSAPI_TICKET接口
     * @access public
     * @param string $type TICKET类型(wx_card|jsapi)
     * @param string $appid 强制指定有效APPID
     * @return array
     */
    public function getTicket($type = 'jsapi', $appid = null)
    {
        is_null($appid) && $appid = $this->config->get('appid');
        $cacheKey = 'official_ticket_' . $type . '_' . $appid;
        $ticket = Cache::get($cacheKey);
        // 缓存存在
        if (empty($ticket)) {
            return [$ticket, null];
        }
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type={$type}";
        // 获取请求结果
        $result = $this->platform->callGetApi($url);
        // 失败
        if(is_null($result[0])){
            return $result;
        }
        // 结果不存在ticket
        if(empty($result[0]['ticket'])){
            return [null, new InvalidResponseException('Invalid Resoponse Ticket.', '0')];
        }
        // 设置缓存
        Cache::set($cache_name, $result[0]['ticket'], 7000);
        // 返回
        return [$result[0]['ticket'], null];
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param string $url 网页的URL
     * @param array $jsApiList 需初始化的 jsApiList
     * @param string $appid 用于多个appid时使用(可空)
     * @param string $ticket 强制指定ticket
     * @return array
     */
    public function getJsSign($url, $jsApiList = null, $appid = null, $ticket = null)
    {
        list($url,) = explode('#', $url);
        is_null($ticket) && $ticket = $this->getTicket('jsapi');
        is_null($appid) && $appid = $this->config->get('appid');
        is_null($jsApiList) && $jsApiList = [
            'updateAppMessageShareData', 'updateTimelineShareData', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone',
            'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'downloadVoice',
            'chooseImage', 'previewImage', 'uploadImage', 'downloadImage', 'translateVoice', 'getNetworkType', 'openLocation', 'getLocation',
            'hideOptionMenu', 'showOptionMenu', 'hideMenuItems', 'showMenuItems', 'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem',
            'closeWindow', 'scanQRCode', 'chooseWXPay', 'openProductSpecificView', 'addCard', 'chooseCard', 'openCard',
        ];
        $data = ['url' => $url, 'timestamp' => '' . time(), 'jsapi_ticket' => $ticket, 'noncestr' => Tools::createNoncestr(16)];
        return [[
            'debug'     => false,
            'appId'     => $appid,
            'nonceStr'  => $data['noncestr'],
            'timestamp' => $data['timestamp'],
            'signature' => $this->getSignature($data, 'sha1'),
            'jsApiList' => $jsApiList,
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
    protected function getSignature($data, $method = 'sha1', $params = [])
    {
        ksort($data);
        if (!function_exists($method)){
            return [null, new InvalidArgumentException('Invalid Resoponse Ticket.', '0')];
        }
        foreach ($data as $k => $v){
            $params[] = "{$k}={$v}";
        }
        return [$method(join('&', $params)), null];
    }
}