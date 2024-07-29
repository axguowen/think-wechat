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

namespace think\wechat\service\work\contract\suite;

use think\wechat\Service;

/**
 * 应用授权服务基础类
 */
class AppAuth extends Service
{
    /**
     * 获取企业永久授权码
     * @access public
     * @param string $authCode 临时授权码
     * @return array
     */
    public function getPermanentCode($authCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_permanent_code?suite_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['auth_code' => $authCode,]);
    }

    /**
     * 获取企业授权信息
     * @access public
     * @param string $authCorpid 授权方corpid
     * @param string $permanentCode 企业永久授权码
     * @return array
     */
    public function getAuthInfo($authCorpid, $permanentCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_auth_info?suite_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['auth_corpid' => $authCorpid, 'permanent_code' => $permanentCode]);
    }
}
