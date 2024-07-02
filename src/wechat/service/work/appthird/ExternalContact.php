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

namespace think\wechat\service\work\appthird;

use think\wechat\service\work\contract\app\ExternalContact as Service;

/**
 * 客户联系服务
 */
class ExternalContact extends Service
{
    // +=======================
    // | 客户管理
    // +=======================
    /**
     * 企业主体unionid转换为第三方external_userid
     * @access public
     * @param string $unionid 微信用户的unionid
     * @param string $openid 微信用户的openid
     * @return array
     */
    public function unionidToExternalUserid($unionid, $openid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/unionid_to_external_userid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'unionid' => $unionid,
            'openid' => $openid,
        ]);
    }

    /**
     * 代开发应用external_userid转换
     * @access public
     * @param string $externalUserid 代开发自建应用获取到的外部联系人ID
     * @return array
     */
    public function toServiceExternalUserid($unionid, $openid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/to_service_external_userid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['external_userid' => $externalUserid]);
    }

    // +=======================
    // | 获客助手组件
    // +=======================
    /**
     * 获取组件授权信息
     * @access public
     * @return array
     */
    public function customerAcquisitionGetCompAuthInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/get_comp_auth_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }
}