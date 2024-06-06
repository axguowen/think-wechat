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

namespace think\wechat\service\mini;

use think\wechat\Service;

/**
 * 小程序生物认证
 */
class Soter extends Service
{
    /**
     * SOTER 生物认证秘钥签名验证
     * @access public
     * @param array $data
     * @return array
     */
    public function verifySignature($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/soter/verify_signature?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}