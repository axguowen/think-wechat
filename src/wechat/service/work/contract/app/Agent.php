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

namespace think\wechat\service\work\contract\app;

use think\wechat\Service;

/**
 * 授权应用服务基础类
 */
abstract class Agent extends Service
{
    // +=======================
    // | 应用授权
    // +=======================
    /**
     * 获取应用权限详情
     * @access public
     * @return array
     */
    public function getPermissions()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/get_permissions?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url);
    }

    /**
     * 获取应用管理员列表
     * @access public
     * @return array
     */
    public function getAdminList()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/get_admin_list?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url);
    }
}