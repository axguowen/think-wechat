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

namespace think\wechat\platform\service\official;

/**
 * 接口调用频次限制
 */
class Limit extends Base
{

    /**
     * 公众号调用或第三方平台帮公众号调用对公众号的所有api调用（包括第三方帮其调用）次数进行清零
     * @access public
     * @return array
     */
    public function clearQuota()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['appid' => $this->config->get('appid')]);
    }

    /**
     * 网络检测
     * @access public
     * @param string $action 执行的检测动作
     * @param string $operator 指定平台从某个运营商进行检测
     * @return array
     */
    public function ping($action = 'all', $operator = 'DEFAULT')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/callback/check?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['action' => $action, 'check_operator' => $operator]);
    }

    /**
     * 获取微信服务器IP地址
     * @access public
     * @return array
     */
    public function getCallbackIp()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }
}