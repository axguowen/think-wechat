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

use think\wechat\service\work\contract\app\Message as Service;

/**
 * 消息服务
 */
class Message extends Service
{
    // +=======================
    // | 应用发送消息到群聊会话
    // +=======================
    /**
     * 创建群聊会话
     * @access public
     * @param string[] $userlist 群成员id列表
     * @param string $name 群聊名
     * @param string $owner 指定群主的id
     * @param string $chatid 群聊的唯一标志，不能与已有的群重复
     * @return array
     */
    public function appchatCreate(array $userlist, $name = '', $owner = '', $chatid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/appchat/create?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'userlist' => $userlist,
        ];
        if(!empty($name)){
            $data['name'] = $name;
        }
        if(!empty($owner)){
            $data['owner'] = $owner;
        }
        if(!empty($chatid)){
            $data['chatid'] = $chatid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 修改群聊会话
     * @access public
     * @param string $chatid 群聊的唯一标志
     * @param string $name 群聊名
     * @param string $owner 指定群主的id
     * @param string[] $addUserList 添加成员的id列表
     * @param string[] $delUserList 踢出成员的id列表
     * @return array
     */
    public function appchatUpdate($chatid, $name = '', $owner = '', array $addUserList = [], array $delUserList = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/appchat/update?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chatid' => $chatid,
        ];
        if(!empty($name)){
            $data['name'] = $name;
        }
        if(!empty($owner)){
            $data['owner'] = $owner;
        }
        if(!empty($addUserList)){
            $data['add_user_list'] = $addUserList;
        }
        if(!empty($delUserList)){
            $data['del_user_list'] = $delUserList;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取群聊会话
     * @access public
     * @param string $chatid 群聊的唯一标志
     * @return array
     */
    public function appchatGet($chatid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/appchat/get?access_token=ACCESS_TOKEN&chatid={$chatid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 应用推送消息
     * @access public
     * @param string $chatid 群聊的唯一标志
     * @param array $msgdata 消息内容
     * @param array $options 其它参数
     * @return array
     */
    public function appchatSend($chatid, array $msgdata, $msgtype = 'text', array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/appchat/send?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, [
            'chatid' => $chatid,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ]);
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 互联企业消息推送
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
    public function linkedcorpMessageSend($agentid, array $msgdata, array $todata, $msgtype = 'text', array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/message/send?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, $todata, [
            'agentid' => $agentid,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ]);
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 家校消息推送
    // +=======================
    /**
     * 发送「学校通知」
     * @access public
     * @param int $agentid 企业应用的id
     * @param array $msgdata 消息内容
     * @param array $todata 指定接收消息的用户或部门数据
     * @param string $msgtype 消息类型
     * @param array $options 其它参数
     * @return array
     */
    public function externalcontactMessageSend($agentid, array $msgdata, array $todata, $msgtype = 'text', array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/message/send?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, $todata, [
            'agentid' => $agentid,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ]);
        return $this->platform->callPostApi($url, $data);
    }
}