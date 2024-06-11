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

use think\wechat\service\work\contract\app\Account as Service;

/**
 * 账号ID服务
 */
class Account extends Service
{
    /**
     * 申请群ID的升级
     * @access public
     * @param int $upgradeTime 完成升级的时间戳
     * @return array
     */
    public function applyToUpgradeChatid($upgradeTime)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/apply_to_upgrade_chatid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['upgrade_time' => $upgradeTime]);
    }
    
    /**
     * 群ID转换接口
     * @access public
     * @param string[] $chatIdList 需要转换的群ID列表
     * @return array
     */
    public function chatid(array $chatIdList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/chatid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['chat_id_list' => $chatIdList]);
    }
}
