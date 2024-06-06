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

namespace think\wechat\platform\service\official;

use think\wechat\platform\service\Service;

/**
 * 微信菜单管理
 */
class Menu extends Service
{
    /**
     * 自定义菜单查询接口
     * @access public
     * @return array
     */
    public function get()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 自定义菜单删除接口
     * @access public
     * @return array
     */
    public function delete()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 自定义菜单创建
     * @access public
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建个性化菜单
     * @access public
     * @param array $data
     * @return array
     */
    public function addConditional(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除个性化菜单
     * @access public
     * @param string $menuid
     * @return array
     */
    public function delConditional($menuid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['menuid' => $menuid]);
    }

    /**
     * 测试个性化菜单匹配结果
     * @access public
     * @param string $openid
     * @return array
     */
    public function tryConditional($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['user_id' => $openid]);
    }
}