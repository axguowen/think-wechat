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

namespace think\wechat\service\official;

use think\wechat\Service;

/**
 * 微信粉丝管理
 */
class User extends Service
{

    /**
     * 设置用户备注名
     * @access public
     * @param string $openid
     * @param string $remark
     * @return array
     */
    public function updateMark($openid, $remark)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid' => $openid, 'remark' => $remark]);
    }

    /**
     * 获取用户基本信息（包括UnionID机制）
     * @access public
     * @param string $openid
     * @param string $lang
     * @return array
     */
    public function getUserInfo($openid, $lang = 'zh_CN')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid={$openid}&lang={$lang}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 批量获取用户基本信息
     * @access public
     * @param array $openids
     * @param string $lang
     * @return array
     */
    public function getBatchUserInfo(array $openids, $lang = 'zh_CN')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=ACCESS_TOKEN';
        $data = ['user_list' => []];
        foreach ($openids as $openid) {
            $data['user_list'][] = ['openid' => $openid, 'lang' => $lang];
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取用户列表
     * @access public
     * @param string $nextOpenid
     * @return array
     */
    public function getUserList($nextOpenid = '')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid={$nextOpenid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取标签下粉丝列表
     * @access public
     * @param integer $tagid 标签ID
     * @param string $nextOpenid 第一个拉取的OPENID
     * @return array
     */
    public function getUserListByTag($tagid, $nextOpenid = '')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['tagid' => $tagid, 'next_openid' => $nextOpenid]);
    }

    /**
     * 获取公众号的黑名单列表
     * @access public
     * @param string $beginOpenid
     * @return array
     */
    public function getBlackList($beginOpenid = '')
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=ACCESS_TOKEN";
        return $this->platform->callPostApi($url, ['begin_openid' => $beginOpenid]);
    }

    /**
     * 批量拉黑用户
     * @access public
     * @param array $openids
     * @return array
     */
    public function batchBlackList(array $openids)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=ACCESS_TOKEN";
        return $this->platform->callPostApi($url, ['openid_list' => $openids]);
    }

    /**
     * 批量取消拉黑用户
     * @access public
     * @param array $openids
     * @return array
     */
    public function batchUnblackList(array $openids)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=ACCESS_TOKEN";
        return $this->platform->callPostApi($url, ['openid_list' => $openids]);
    }
}