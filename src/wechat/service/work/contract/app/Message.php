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
 * 消息服务基础类
 */
abstract class Message extends Service
{
    // +=======================
    // | 发送消息
    // +=======================
    /**
     * 发送应用消息
     * @access public
     * @param int $agentid 企业应用的id
     * @param array $msgdata 消息内容
     * @param array $todata 指定接收消息的用户或部门数据
     * @param string $msgtype 消息类型
     * @param array $options 其它参数
     * @return array
     */
    public function send($agentid, array $msgdata, array $todata, $msgtype = 'text', array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, $todata, [
            'agentid' => $agentid,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ]);
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 更新模版卡片消息
     * @access public
     * @param array $data 请求体
     * @return array
     */
    public function updateTemplateCard(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/message/update_template_card?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 撤回应用消息
     * @access public
     * @param string $msgid 消息ID
     * @return array
     */
    public function recall(string $msgid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/message/recall?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['msgid' => $msgid]);
    }
}