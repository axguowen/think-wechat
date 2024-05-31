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

/**
 * 发布能力
 */
class FreePublish extends Base
{
    /**
     * 发布接口
     * 开发者需要先将图文素材以草稿的形式保存（见“草稿箱/新建草稿”，如需从已保存的草稿中选择，见“草稿箱/获取草稿列表”）
     * @access public
     * @param mixed $mediaId 选择要发布的草稿的media_id
     * @return array
     */
    public function submit($mediaId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/submit?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['media_id' => $mediaId]);
    }

    /**
     * 发布状态轮询接口
     * @access public
     * @param mixed $publishId
     * @return array
     */
    public function get($publishId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['publish_id' => $publishId]);
    }

    /**
     * 删除发布
     * 发布成功之后，随时可以通过该接口删除。此操作不可逆，请谨慎操作。
     * @access public
     * @param mixed $articleId 成功发布时返回的 article_id
     * @param int $index 要删除的文章在图文消息中的位置，第一篇编号为1，该字段不填或填0会删除全部文章
     * @return array
     */
    public function delete($articleId, $index = 0)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/delete?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['article_id' => $articleId, 'index' => $index]);
    }

    /**
     * 通过 article_id 获取已发布文章
     * @access public
     * @param mixed $articleId 要获取的草稿的article_id
     * @return array
     */
    public function getArticle($articleId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/getarticle?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['article_id' => $articleId]);
    }

    /**
     * 获取成功发布列表
     * @access public
     * @param int $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材返回
     * @param int $count 返回素材的数量，取值在1到20之间
     * @param int $noContent 1 表示不返回 content 字段，0 表示正常返回，默认为 0
     * @return array
     */
    public function batchGet($offset = 0, $count = 20, $noContent = 0)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/freepublish/batchget?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['no_content' => $noContent, 'offset' => $offset, 'count' => $count]);
    }
}