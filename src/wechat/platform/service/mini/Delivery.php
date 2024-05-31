<?php
// +----------------------------------------------------------------------
// | WeChat SDK [WeChat SDK for PHP]
// +----------------------------------------------------------------------
// | WeChat SDK
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

namespace axguowen\wechat\services\mini;

use axguowen\WeChat;

/**
 * 小程序即时配送
 */
class Delivery extends WeChat
{

    /**
     * 异常件退回商家商家确认收货接口
     * @access public
     * @param array $data
     * @return array
     */
    public function abnormalConfirm($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/confirm_return?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 下配送单接口
     * @access public
     * @param array $data
     * @return array
     */
    public function addOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/add?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 可以对待接单状态的订单增加小费
     * @access public
     * @param array $data
     * @return array
     */
    public function addTip($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/addtips?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 取消配送单接口
     * @access public
     * @param array $data
     * @return array
     */
    public function cancelOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/cancel?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 获取已支持的配送公司列表接口
     * @access public
     * @param array $data
     * @return array
     */
    public function getAllImmeDelivery($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/delivery/getall?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 拉取已绑定账号
     * @access public
     * @param array $data
     * @return array
     */
    public function getBindAccount($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/shop/get?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 拉取配送单信息
     * @access public
     * @param array $data
     * @return array
     */
    public function getOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/get?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 模拟配送公司更新配送单状态
     * @access public
     * @param array $data
     * @return array
     */
    public function mockUpdateOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/test_update_order?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 预下配送单接口
     * @access public
     * @param array $data
     * @return array
     */
    public function preAddOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/pre_add?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 预取消配送单接口
     * @access public
     * @param array $data
     * @return array
     */
    public function preCancelOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/precancel?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

    /**
     * 重新下单
     * @access public
     * @param array $data
     * @return array
     */
    public function reOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/local/business/order/readd?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data);
    }

}