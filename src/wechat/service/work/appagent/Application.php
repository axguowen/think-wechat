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

namespace think\wechat\service\work\appagent;

use think\wechat\service\work\contract\app\Application as Service;

/**
 * 应用管理服务
 */
class Application extends Service
{
    /**
     * 自建应用迁移成代开发应用
     * @access public
     * @param string $suiteAccessToken 代开发应用模版接口调用凭证
     * @return array
     */
    public function claimCustomizedApp($suiteAccessToken)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/claim_customized_app?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['suite_access_token' => $suiteAccessToken]);
    }
}