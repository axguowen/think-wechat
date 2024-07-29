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

namespace think\wechat\service\work\appself;

use think\wechat\service\work\contract\app\ExternalPay as Service;

/**
 * 企业支付服务
 */
class ExternalPay extends Service
{
    // +=======================
    // | 对外收款
    // +=======================
    /**
     * 查询商户号详情
     * @access public
     * @param string $mchId 微信支付商户号
     * @return array
     */
    public function getmerchant($mchId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalpay/getmerchant?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['mch_id' => $mchId]);
    }

    /**
     * 设置商户号使用范围
     * @access public
     * @param string $mchId 微信支付商户号
     * @param array $allowUseScope 该商户号使用范围
     * @return array
     */
    public function setMchUseScope($mchId, array $allowUseScope)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalpay/set_mch_use_scope?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['mch_id' => $mchId, 'allow_use_scope' => $allowUseScope]);
    }

    /**
     * 获取资金流水
     * @access public
     * @param int $beginTime 起始时间
     * @param int $endTime 结束时间
     * @param string $mchId 微信支付商户号
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getFundFlow($beginTime, $endTime, $mchId = '', $limit = 20, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalpay/get_fund_flow?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'limit' => $limit,
        ];
        if (!empty($mchId)) {
            $data['mch_id'] = $mchId;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }
}