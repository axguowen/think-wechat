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
 * 小程序动态消息
 */
class Message extends Base
{
    /**
     * 动态消息，创建被分享动态消息的 activity_id
     * @access public
     * @param array $data
     * @return array
     */
    public function createActivityId($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/activityid/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 动态消息，修改被分享的动态消息
     * @access public
     * @param array $data
     * @return array
     */
    public function setUpdatableMsg($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/updatablemsg/send?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 下发小程序和公众号统一的服务消息
     * @access public
     * @param array $data
     * @return array
     */
    public function uniformSend($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}