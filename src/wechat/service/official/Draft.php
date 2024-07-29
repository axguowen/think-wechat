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
 * 微信草稿箱管理
 */
class Draft extends Service
{
    /**
     * 新建草稿
     * @access public
     * @param $articles
     * @return array
     */
    public function add($articles)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/add?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['articles' => $articles]);
    }

    /**
     * 获取草稿
     * @access public
     * @param string $mediaId
     * @param string $outType 返回处理函数
     * @return array
     */
    public function get($mediaId, $outType = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/get?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['media_id' => $mediaId]);
    }


    /**
     * 删除草稿
     * @access public
     * @param string $mediaId
     * @return array
     */
    public function delete($mediaId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/delete?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['media_id' => $mediaId]);
    }

    /**
     * 新增图文素材
     * @access public
     * @param array $data 文件名称
     * @return array
     */
    public function addNews($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 修改草稿
     * @access public
     * @param string $mediaId 要修改的图文消息的id
     * @param int $index 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * @param $articles
     * @return array
     */
    public function update($mediaId, $index, $articles)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/update?access_token=ACCESS_TOKEN';
        $data = ['media_id' => $mediaId, 'index' => $index, 'articles' => $articles];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取草稿总数
     * @access public
     * @return array
     */
    public function getCount()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/count?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取草稿列表
     * @access public
     * @param int $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材返回
     * @param int $count 返回素材的数量，取值在1到20之间
     * @param int $noContent 1 表示不返回 content 字段，0 表示正常返回，默认为 0
     * @return array
     */
    public function batchGet($offset = 0, $count = 20, $noContent = 0)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/draft/batchget?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['no_content' => $noContent, 'offset' => $offset, 'count' => $count]);
    }
}
