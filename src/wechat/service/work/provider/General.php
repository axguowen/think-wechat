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

namespace think\wechat\service\work\provider;

use think\wechat\Service;

/**
 * 企业微信服务商通用服务
 */
class General extends Service
{
    /**
     * 明文corpid转换为加密corpid
     * @access public
     * @param string $corpid 授权方明文corpid
     * @return array
     */
    public function corpidToOpencorpid($corpid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/corpid_to_opencorpid?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['corpid' => $corpid]);
    }

    /**
     * ID迁移完成状态的设置
     * @access public
     * @param string $corpid 授权方明文corpid
     * @param array $openidType id类型 1-userid与corpid; 3-external_userid
     * @return array
     */
    public function finishOpenidMigration($corpid, array $openidType)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/finish_openid_migration?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['corpid' => $corpid, 'openid_type' => $openidType]);
    }

    /**
     * 获取代开发自建应用授权链接
     * @access public
     * @param string[] $templateidList 代开发自建应用模版ID列表, 数量不能超过9个
     * @param string $state state值
     * @return array
     */
    public function getCustomizedAuthUrl(array $templateidList, $state)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_customized_auth_url?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['templateid_list' => $templateidList, 'state' => $state]);
    }

    /**
     * 获取充值账户余额
     * @access public
     * @return array
     */
    public function getAccountBalance()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_account_balance?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }
}