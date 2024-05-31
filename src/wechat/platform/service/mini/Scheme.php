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

/**
 * 小程序 URL-Scheme
 */
class Scheme extends Base
{

    /**
     * 创建 URL-Scheme
     * @access public
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/generatescheme?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询 URL-Scheme
     * @access public
     * @param string $scheme
     * @return array
     */
    public function query($scheme)
    {
        $url = 'https://api.weixin.qq.com/wxa/queryscheme?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['scheme' => $scheme]);
    }

    /**
     * 创建 URL-Link
     * @access public
     * @param array $data
     * @return array
     */
    public function urlLink($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/generate_urllink?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询 URL-Link
     * @access public
     * @param string $urllink
     * @return array
     */
    public function urlQuery($urllink)
    {
        $url = 'https://api.weixin.qq.com/wxa/query_urllink?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['url_link' => $urllink]);
    }
}