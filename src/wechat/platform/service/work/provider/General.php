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

namespace think\wechat\platform\service\work\provider;

/**
 * 企业微信服务商通用服务
 */
class General extends Base
{
    /**
     * 明文corpid转换为加密corpid
     * @access public
     * @param string $corpid 授权方明文corpid
     * @return array
     */
    public function getAdminList($corpid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/corpid_to_opencorpid?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid]);
    }
}