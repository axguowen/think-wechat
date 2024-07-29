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
 * 企业微信服务商推广二维码服务
 */
class PublicizeQrcode extends Service
{
    /**
     * 获取注册码
     * @access public
     * @param string $templateId 推广包ID
     * @param string $corpName 企业名称
     * @param string $adminName 管理员姓名
     * @param string $adminMobile 管理员手机号
     * @param string $state 用户自定义的状态值
     * @param string $followUser 跟进人的userid
     * @return array
     */
    public function getRegisterCode($templateId, $corpName = '', $adminName = '', $adminMobile = '', $state = '', $followUser = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_register_code?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'template_id' => $templateId,
            'corp_name' => $corpName,
            'admin_name' => $adminName,
            'admin_mobile' => $adminMobile,
            'state' => $state,
            'follow_user' => $followUser,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询注册状态
     * @access public
     * @param string $registerCode 查询的注册码
     * @return array
     */
    public function getRegisterInfo($registerCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_register_info?provider_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['register_code' => $registerCode]);
    }
}