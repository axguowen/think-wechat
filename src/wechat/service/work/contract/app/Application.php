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
 * 应用管理服务基础类
 */
abstract class Application extends Service
{
    // +=======================
    // | 获取应用
    // +=======================
    /**
     * 获取指定的应用详情
     * @access public
     * @param int $agentid 应用id
     * @return array
     */
    public function get($agentid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/agent/get?access_token=ACCESS_TOKEN&agentid={$agentid}";
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取access_token对应的应用列表
     * @access public
     * @return array
     */
    public function list()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    // +=======================
    // | 设置工作台自定义展示
    // +=======================
    /**
     * 设置应用在工作台展示的模版
     * @access public
     * @param int $agentid 企业应用的id
     * @param string $type 模版类型
     * @param array $defaultData 默认数据
     * @param bool $replaceUserData 是否覆盖用户工作台的数据
     * @return array
     */
    public function setWorkbenchTemplate($agentid, $type = 'keydata', array $defaultData = [], $replaceUserData = false)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/set_workbench_template?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, [
            'agentid' => $agentid,
            'type' => $type,
            'replace_user_data' => $replaceUserData,
        ]);
        if (!empty($defaultData)) {
            $data[$type] = $defaultData;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取应用在工作台展示的模版
     * @access public
     * @param int $agentid 企业应用的id
     * @return array
     */
    public function getWorkbenchTemplate($agentid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/get_workbench_template?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['agentid' => $agentid]);
    }

    /**
     * 设置应用在用户工作台展示的数据
     * @access public
     * @param int $agentid 企业应用的id
     * @param string $userid 需要设置的用户的userid
     * @param string $type 模版类型
     * @param array $typeData 模版数据
     * @return array
     */
    public function setWorkbenchData($agentid, $userid, $type = 'keydata', array $typeData = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/set_workbench_data?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, [
            'agentid' => $agentid,
            'userid' => $userid,
            'type' => $type,
        ]);
        if (!empty($typeData)) {
            $data[$type] = $typeData;
        }
        return $this->handler->callPostApi($url, $data);
    }
}