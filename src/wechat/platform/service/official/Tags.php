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

namespace think\wechat\platform\service\official;

use think\wechat\platform\service\Service;

/**
 * 用户标签管理
 */
class Tags extends Service
{
    /**
     * 获取粉丝标签列表
     * @access public
     * @return array
     */
    public function getTags()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 创建粉丝标签
     * @access public
     * @param string $name
     * @return array
     */
    public function createTags($name)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['tag' => ['name' => $name]]);
    }

    /**
     * 更新粉丝标签
     * @access public
     * @param integer $id 标签ID
     * @param string $name 标签名称
     * @return array
     */
    public function updateTags($id, $name)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['tag' => ['name' => $name, 'id' => $id]]);
    }

    /**
     * 删除粉丝标签
     * @access public
     * @param int $tagId
     * @return array
     */
    public function deleteTags($tagId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['tag' => ['id' => $tagId]]);
    }

    /**
     * 批量为用户打标签
     * @access public
     * @param array $openids
     * @param integer $tagId
     * @return array
     */
    public function batchTagging(array $openids, $tagId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid_list' => $openids, 'tagid' => $tagId]);
    }

    /**
     * 批量为用户取消标签
     * @access public
     * @param array $openids
     * @param integer $tagId
     * @return array
     */
    public function batchUntagging(array $openids, $tagId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid_list' => $openids, 'tagid' => $tagId]);
    }

    /**
     * 获取用户身上的标签列表
     * @access public
     * @param string $openid
     * @return array
     */
    public function getUserTagId($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid' => $openid]);
    }
}