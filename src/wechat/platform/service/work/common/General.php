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

namespace think\wechat\platform\service\work\common;

/**
 * 企业微信通用公共服务基础类
 */
abstract class General extends Base
{
    /**
     * 获取企业微信回调通知服务器的ip段
     * @access public
     * @return array
     */
    public function getCallbackIp()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN&debug=1';
        return $this->platform->callGetApi($url);
    }

    /**
     * 设置买单接口
     * @access public
     * @return array
     */
    public function getApiDomainIp($cardId, $isOpen = true)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/get_api_domain_ip?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }
}