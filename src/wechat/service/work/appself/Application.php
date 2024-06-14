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

namespace think\wechat\service\work\appself;

use think\wechat\service\work\contract\app\Application as Service;

/**
 * 应用管理服务
 */
class Application extends Service
{
    // +=======================
    // | 自定义菜单
    // +=======================
    /**
     * 创建菜单
     * @access public
     * @param array $button 一级菜单数组, 个数应为1~3个
     * @return array
     */
    public function menuCreate(array $button)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN&agentid=AGENTID';
        return $this->platform->callPostApi($url, ['button' => $button]);
    }
    
    /**
     * 获取指定的应用菜单
     * @access public
     * @param int $agentid 应用id
     * @return array
     */
    public function menuGet($agentid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN&agentid={$agentid}";
        return $this->platform->callGetApi($url);
    }
    
    /**
     * 删除指定的应用菜单
     * @access public
     * @param int $agentid 应用id
     * @return array
     */
    public function menuDelete($agentid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN&agentid={$agentid}";
        return $this->platform->callGetApi($url);
    }
}