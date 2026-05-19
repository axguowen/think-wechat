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
 * 数据与智能专区文档存档服务基础类
 */
abstract class Docdata extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
    /**
     * 获取数据与智能专区文档存档授权信息
     * @access public
     * @return array
     */
    public function getAuthInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/docdata/get_auth_info?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url);
    }
}