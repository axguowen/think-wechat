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

namespace think\wechat\service\work\provider;

use think\wechat\Service;

/**
 * 企业微信服务商数据与智能专区高级接口订单管理服务
 */
class AdvancedApi extends Service
{
    // +=======================
    // | 订单管理
    // +=======================
    /**
     * 下单购买
     * @access public
     * @param string $customCorpid 客户企业id
     * @param string $buyerUserid 下单人, 服务商企业内成员的明文userid
     * @param int $advancedApiType 购买的高级接口类型: 1-会话内容数据接口
     * @param int $orderType 订单类型: 0-新购、1-增购、2-续期、3-升级
     * @param array $options 其他参数
     * @return array
     */
    public function createOrder($customCorpid, $buyerUserid, $advancedApiType = 1, $orderType = 0, $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/advanced_api/create_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'custom_corpid' => $customCorpid,
            'buyer_userid' => $buyerUserid,
            'order_type' => $orderType,
            'advanced_api_type' => $advancedApiType,
        ];
        // 如果是会话内容数据接口
        if($advancedApiType == 1){
            $data['chat_archive_api'] = $options;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 取消订单
     * @access public
     * @param string $orderId 订单id
     * @return array
     */
    public function cancelOrder($orderId)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/cancel_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 使用余额支付订单
     * @access public
     * @param string $orderId 订单ID
     * @param string $payerUserid 支付人, 服务商企业内成员的明文userid
     * @return array
     */
    public function submitPay($orderId, $payerUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/advanced_api/submit_pay?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'payer_userid' => $payerUserid,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取订单列表
     * @access public
     * @param string $customCorpid 客户企业id
     * @param int $startTime 起始时间, 按下单时间排序
     * @param int $endTime 结束时间, 起始时间跟结束时间不能超过31天
     * @param string $cursor 用于分页查询的游标
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @return array
     */
    public function listOrder($customCorpid = '', $startTime = 0, $endTime = 0, $cursor = '', $limit = 50, $advancedApiType = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/advanced_api/list_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
            'advanced_api_type' => $advancedApiType,
        ];
        // 指定了客户企业id
        if(!empty($customCorpid)){
            $data['custom_corpid'] = $customCorpid;
        }
        // 指定了时间
        if($startTime > 0 || $endTime > 0){
            $data['start_time'] = $startTime;
            $data['end_time'] = $endTime;
        }
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取订单详情
     * @access public
     * @param string $orderId 订单ID
     * @return array
     */
    public function getOrder($orderId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/advanced_api/get_order?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['order_id' => $orderId]);
    }

    /**
     * 获取企业已购信息
     * @access public
     * @param string $customCorpid 客户企业id
     * @param int $advancedApiType 购买的高级接口类型: 1-会话内容数据接口
     * @return array
     */
    public function getCorpBuyInfo($customCorpid, $advancedApiType = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/advanced_api/get_corp_buy_info?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'custom_corpid' => $customCorpid,
            'advanced_api_type' => $advancedApiType,
        ];
        return $this->handler->callPostApi($url, $data);
    }
}