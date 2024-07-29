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

use think\wechat\service\work\contract\app\ExternalContact as Service;

/**
 * 客户联系服务
 */
class ExternalContact extends Service
{
    /**
     * 获取已服务的外部联系人
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function contactList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/contact_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }
}