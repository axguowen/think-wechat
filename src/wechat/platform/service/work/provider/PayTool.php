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

namespace think\wechat\platform\service\work\provider;

/**
 * 企业微信服务商收银台服务
 */
class PayTool extends Base
{
    // +=======================
    // | 收款工具
    // +=======================
    /**
     * 创建收款订单
     * @access public
     * @param array $options 订单参数
     * @return array
     */
    public function openOrder(array $options)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/open_order?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $options);
    }

    /**
     * 取消收款订单
     * @access public
     * @param string $orderId 收款订单号
     * @param string $nonceStr 随机字符串
     * @param int $time unix时间戳
     * @param string $signature 数字签名
     * @return array
     */
    public function closeOrder($orderId, $nonceStr, $time, $signature)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/close_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'nonce_str' => $nonceStr,
            'ts' => $time,
            'sig' => $signature
        ];
        return $this->platform->callPostApi($url, $options);
    }

    /**
     * 获取收款订单列表
     * @access public
     * @param array $options 查询参数
     * @return array
     */
    public function getOrderList(array $options)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/get_order_list?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $options);
    }

    /**
     * 获取收款订单详情
     * @access public
     * @param string $orderId 收款订单号
     * @param string $nonceStr 随机字符串
     * @param int $time unix时间戳
     * @param string $signature 数字签名
     * @return array
     */
    public function getOrderDetail($orderId, $nonceStr, $time, $signature)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/get_order_detail?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'nonce_str' => $nonceStr,
            'ts' => $time,
            'sig' => $signature
        ];
        return $this->platform->callPostApi($url, $options);
    }

    // +=======================
    // | 发票管理
    // +=======================
    /**
     * 获取发票列表
     * @access public
     * @param int $startTime 起始时间,
     * @param int $endTime 结束时间
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function getInvoiceList($startTime = 0, $endTime = 0, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/get_invoice_list?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了时间
        if($startTime > 0 || $endTime > 0){
            $data['start_time'] = $startTime;
            $data['end_time'] = $endTime;
        }
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 标记开票状态 
     * @access public
     * @param string $orderId 收款订单号
     * @param string $operUserid 标记开票状态的操作人
     * @param int $invoiceStatus 要标记的开票状态。
                                    1-已开具纸质发票，并邮寄给客户
                                    2-已开具电子发票，并发送至客户邮箱
                                    3-取消开具发票，取消后企业可再次申请
                                    若订单对应开票状态为已开票，此次标记将不生效
     * @param string $invoiceNote 用于分页查询的游标
     * @return array
     */
    public function markInvoiceStatus($orderId, $operUserid, $invoiceStatus, $invoiceNote = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/paytool/mark_invoice_status?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'oper_userid' => $operUserid,
            'invoice_status' => $invoiceStatus,
            'invoice_note' => $invoiceNote,
        ];
        return $this->platform->callPostApi($url, $data);
    }
}