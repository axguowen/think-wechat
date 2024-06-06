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

namespace think\wechat\platform\service\mini;

use think\wechat\platform\service\Service;

/**
 * 公众号小程序模板消息支持
 */
class Template extends Service
{
    /**
     * 获取小程序模板库标题列表
     * @access public
     * @return array
     */
    public function getTemplateLibraryList()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/list?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['offset' => '0', 'count' => '20']);
    }

    /**
     * 获取模板库某个模板标题下关键词库
     * @access public
     * @param string $template_id 模板标题id，可通过接口获取，也可登录小程序后台查看获取
     * @return array
     */
    public function getTemplateLibrary($template_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['id' => $template_id]);
    }

    /**
     * 组合模板并添加至帐号下的个人模板库
     * @access public
     * @param string $template_id 模板标题id，可通过接口获取，也可登录小程序后台查看获取
     * @param array $keyword_id_list 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如[3,5,4]或[4,5,3]），最多支持10个关键词组合
     * @return array
     */
    public function addTemplate($template_id, array $keyword_id_list)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['id' => $template_id, 'keyword_id_list' => $keyword_id_list]);
    }

    /**
     * 获取帐号下已存在的模板列表
     * @access public
     * @return array
     */
    public function getTemplateList()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['offset' => '0', 'count' => '20']);
    }

    /**
     * 删除模板消息
     * @access public
     * @param string $template_id 要删除的模板id
     * @return array
     */
    public function delTemplate($template_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['template_id' => $template_id]);
    }

    /**
     * 发送模板消息
     * @access public
     * @param array $data 发送的消息对象数组
     * @return array
     */
    public function send(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}