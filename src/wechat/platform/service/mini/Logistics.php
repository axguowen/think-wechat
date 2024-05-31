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
 * 小程序物流助手
 */
class Logistics extends Base
{
    /**
     * 生成运单
     * @access public
     * @param array $data
     * @return array
     */
    public function addOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/order/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 取消运单
     * @access public
     * @param array $data
     * @return array
     */
    public function cancelOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/order/cancel?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取支持的快递公司列表
     * @access public
     * @return array
     */
    public function getAllDelivery()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/delivery/getall?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取运单数据
     * @access public
     * @param array $data
     * @return array
     */
    public function getOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/order/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询运单轨迹
     * @access public
     * @param array $data
     * @return array
     */
    public function getPath($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/path/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取打印员。若需要使用微信打单 PC 软件，才需要调用
     * @access public
     * @return array
     */
    public function getPrinter()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/printer/getall?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取电子面单余额。仅在使用加盟类快递公司时，才可以调用
     * @access public
     * @param array $data
     * @return array
     */
    public function getQuota($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/path/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 模拟快递公司更新订单状态, 该接口只能用户测试
     * @access public
     * @param array $data
     * @return array
     */
    public function testUpdateOrder($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/test_update_order?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 配置面单打印员，若需要使用微信打单 PC 软件，才需要调用
     * @access public
     * @param array $data
     * @return array
     */
    public function updatePrinter($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/business/printer/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取面单联系人信息
     * @access public
     * @param array $data
     * @return array
     */
    public function getContact($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/contact/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 预览面单模板。用于调试面单模板使用
     * @access public
     * @param array $data
     * @return array
     */
    public function previewTemplate($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/template/preview?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新商户审核结果
     * @access public
     * @param array $data
     * @return array
     */
    public function updateBusiness($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/service/business/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新运单轨迹
     * @access public
     * @param array $data
     * @return array
     */
    public function updatePath($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/path/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}