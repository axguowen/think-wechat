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

use think\wechat\Service;

/**
 * 会话内容存档服务
 */
class Chatdata extends Service
{
    /**
     * 获取会话内容存档开启成员列表
     * @access public
     * @param int $type 拉取对应版本的开启成员列表, 1表示办公版, 2表示服务版, 3表示企业版
     * @return array
     */
    public function getPermitUserList($type = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/msgaudit/get_permit_user_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        if($type > 0){
            $data['type'] = $type;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取会话同意情况
     * @access public
     * @param array $info 待查询的会话信息
     * @return array
     */
    public function checkSingleAgree(array $info)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/msgaudit/check_single_agree?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['info' => $info]);
    }

    /**
     * 获取内部群信息
     * @access public
     * @param string $roomid 待查询的群id
     * @return array
     */
    public function groupchatGet($roomid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/msgaudit/groupchat/get?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['roomid' => $roomid]);
    }
}