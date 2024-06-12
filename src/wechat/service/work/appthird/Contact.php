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

namespace think\wechat\service\work\appthird;

use think\wechat\service\work\contract\app\Contact as Service;

/**
 * 企业微信第三方应用通讯录管理服务
 */
class Contact extends Service
{
    // +=======================
    // | 成员管理
    // +=======================
    /**
     * 获取成员授权列表
     * @access public
     * @param int $limit 每次拉取的数据量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function userListMemberAuth($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_member_auth?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 返回
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询成员用户是否已授权
     * @access public
     * @param string $openUserid 企业成员的open_userid
     * @return array
     */
    public function userCheckMemberAuth($openUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/check_member_auth?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['open_userid' => $openUserid]);
    }

    /**
     * 获取选人ticket对应的用户
     * @access public
     * @param string $selectedTicket 选人jsapi返回的selectedTicket
     * @return array
     */
    public function userListSelectedTicketUser($selectedTicket)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_selected_ticket_user?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['selected_ticket' => $selectedTicket]);
    }
}