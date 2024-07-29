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

use think\wechat\Service;

/**
 * 小程序接入对外收款服务
 */
class MiniappPay extends Service
{
    // +=======================
    // | 创建对外收款账户
    // +=======================
    /**
     * 提交创建对外收款账户的申请单 
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function applyMch(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/apply_mch?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询申请单状态
     * @access public
     * @param string $outRequestNo 业务申请编号
     * @return array
     */
    public function getApplymentStatus($outRequestNo)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/get_applyment_status?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['out_request_no' => $outRequestNo]);
    }

    // +=======================
    // | 普通支付
    // +=======================
    /**
     * 提交创建对外收款账户的申请单
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function createOrder(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/create_order?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询订单
     * @access public
     * @param string $mchid 商户号
     * @param string $outTradeNo 商户订单号
     * @return array
     */
    public function getOrder($mchid, $outTradeNo)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/get_order?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['mchid' => $mchid, 'out_trade_no' => $outTradeNo]);
    }

    /**
     * 关闭订单
     * @access public
     * @param string $mchid 商户号
     * @param string $outTradeNo 商户订单号
     * @return array
     */
    public function closeOrder($mchid, $outTradeNo)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/close_order?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['mchid' => $mchid, 'out_trade_no' => $outTradeNo]);
    }

    /**
     * 获取支付签名
     * @access public
     * @param string $appid 商户号
     * @param string $prepayId 预支付交易会话标识
     * @param string $nonce 随机字符串
     * @param int $timestamp 时间戳
     * @param string $signType 签名方式
     * @return array
     */
    public function getSign($appid, $prepayId, $nonce, $timestamp, $signType = 'RSA')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/get_sign?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'appid' => $appid,
            'prepayid' => $prepayId,
            'noncestr' => $nonce,
            'timestamp' => $timestamp,
            'signtype' => $signType,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 退款
    // +=======================
    /**
     * 申请退款
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function refund(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/refund?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询退款
     * @access public
     * @param string $mchid 商户号
     * @param string $outRefundNo 商户订单号
     * @return array
     */
    public function getRefundDetail($mchid, $outRefundNo)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/get_refund_detail?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['mchid' => $mchid, 'out_refund_no' => $outRefundNo]);
    }

    /**
     * 交易账单申请
     * @access public
     * @param string $billDate 账单日期
     * @param string $mchid 商户号
     * @param string $billType 账单类型
     * @param string $tarType 压缩类型
     * @return array
     */
    public function getBill($billDate, $mchid, $billType = 'ALL', $tarType = 'GZIP')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniapppay/get_bill';
        // 请求参数
        $data = [
            'bill_date' => $billDate,
            'mchid' => $mchid,
            'bill_type' => $billType,
            'tar_type' => $tarType,
        ];
        return $this->handler->callPostApi($url, $data);
    }
}