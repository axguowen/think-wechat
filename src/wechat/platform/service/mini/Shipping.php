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

namespace think\wechat\platform\service\mini;

/**
 * 小程序发货信息管理服务
 */
class Shipping extends Base
{
    /**
     * 发货信息录入接口
     * @param array $data
     * @return array
     */
    public function upload($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/upload_shipping_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 发货信息合单录入接口
     * @param array $data
     * @return array
     */
    public function combined($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/upload_combined_shipping_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询订单发货状态
     * @param array $data
     * @return array
     */
    public function query($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/get_order?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询订单列表
     * @param array $data
     * @return array
     */
    public function qlist($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/get_order_list?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 确认收货提醒接口
     * @param array $data
     * @return array
     */
    public function confirm($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/notify_confirm_receive?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 消息跳转路径设置接口
     * @param array $data
     * @return array
     */
    public function setJump($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/set_msg_jump_path?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询小程序是否已开通发货信息管理服务
     * @param array $data
     * @return array
     */
    public function isTrade($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/is_trade_managed?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询小程序是否已完成交易结算管理确认
     * @param array $data
     * @return array
     */
    public function isCompleted($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/sec/order/is_trade_management_confirmation_completed?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}