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

use think\wechat\service\work\contract\app\Contact as Service;

/**
 * 企业微信自建应用通讯录管理服务
 */
class Contact extends Service
{
    // +=======================
    // | 成员管理
    // +=======================
    /**
     * 登录二次验证
     * @access public
     * @param string $userid 成员UserID
     * @return array
     */
    public function userAuthsucc($userid)
    {
        return $this->handler->service('oauth', true)->userAuthsucc($userid);
    }

    /**
     * 获取加入企业二维码
     * @access public
     * @param int $sizeType qrcode尺寸类型
     * @return array
     */
    public function corpGetJoinQrcode($sizeType = 1)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN&size_type={$sizeType}";
        return $this->handler->callGetApi($url);
    }
}