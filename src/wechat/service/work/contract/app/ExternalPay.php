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

/**
 * 企业支付服务基础类
 */
abstract class ExternalPay extends Service
{
    // +=======================
    // | 对外收款
    // +=======================
    /**
     * 获取企业全部的发表列表
     * @access public
     * @param int $beginTime 起始时间
     * @param int $endTime 结束时间
     * @param string $payeeUserid 朋友圈创建人的userid
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getBillList($beginTime, $endTime, $payeeUserid = '', $limit = 20, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalpay/get_bill_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'limit' => $limit,
        ];
        if (!empty($payeeUserid)) {
            $data['payee_userid'] = $payeeUserid;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取收款项目的商户单号
     * @access public
     * @param string $paymentId 收款项目单号
     * @return array
     */
    public function getPaymentInfo($paymentId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalpay/get_payment_info?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['payment_id' => $paymentId]);
    }
}