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

namespace think\wechat\service\work\suitethird;

use think\wechat\Service;

/**
 * 企业微信服务商第三方应用套件收银台服务
 */
class Counter extends Service
{

    // +=======================
    // | 收银台/应用版本付费
    // +=======================
    /**
     * 获取订单列表
     * @access public
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @param int $testMode 指定拉取正式或测试授权的订单, 0正式授权, 1测试授权。
     * @return array
     */
    public function getOrderList($startTime, $endTime, $testMode = 0)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_order_list?suite_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['start_time' => $startTime, 'end_time' => $endTime, 'test_mode' => $testMode]);
    }

    /**
     * 获取订单详情
     * @access public
     * @param string $orderId 订单号
     * @return array
     */
    public function getOrder($orderId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_order?suite_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['orderid' => $orderId]);
    }

    /**
     * 获取企业永久授权码
     * @access public
     * @param string $authCode 临时授权码
     * @return array
     */
    public function getPermanentCode($authCode)
    {
        return $this->platform->service('app_auth')->getPermanentCode($authCode);
    }

    /**
     * 获取企业授权信息
     * @access public
     * @param string $authCorpid 授权方corpid
     * @param string $permanentCode 企业永久授权码
     * @return array
     */
    public function getAuthInfo($authCorpid, $permanentCode)
    {
        return $this->platform->service('app_auth')->getAuthInfo($authCorpid, $permanentCode);
    }

    /**
     * 延长试用期
     * @access public
     * @param string $buyerCorpid 购买方corpid
     * @param int $prolongDays 延长天数
     * @return array
     */
    public function prolongTry($buyerCorpid, $prolongDays)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/prolong_try?suite_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['buyer_corpid' => $buyerCorpid, 'prolong_days' => $prolongDays,]);
    }
}