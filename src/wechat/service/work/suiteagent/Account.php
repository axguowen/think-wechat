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

namespace think\wechat\service\work\suiteagent;

use think\wechat\Service;

/**
 * 账号ID服务
 */
class Account extends Service
{
    /**
     * 对所有新授权企业升级群ID
     * @access public
     * @return array
     */
    public function upgradeChatidForNewCorp()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/upgrade_chatid_for_new_corp?suite_access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }
}
