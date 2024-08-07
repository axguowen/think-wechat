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
use think\wechat\utils\Tools;

/**
 * 微信素材管理
 */
class Media extends Service
{
    /**
     * 新增临时素材
     * @access public
     * @param string $fileName 文件名
     * @param string $fileContent 文件内容
     * @param string $mimeType 文件类型
     * @param string $type 媒体文件类型(image|voice|video|thumb)
     * @return array
     */
    public function add($fileName, $fileContent, $mimeType = null, $type = 'image')
    {
        if (!in_array($type, ['image', 'voice', 'video', 'thumb'])) {
            throw new \Exception('Invalid Media Type.', '0');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type={$type}";
        return $this->handler->callMultipartPostApi($url, [], 'media', $fileName, $fileContent, $mimeType);
    }

    /**
     * 获取临时素材
     * @access public
     * @param string $media_id
     * @param string $outType 返回处理函数
     * @return array|string
     */
    public function get($media_id, $outType = null)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id={$media_id}";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        if ($outType == 'url') return $url;
        return $this->handler->callGetApi($url);
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
     * 更新图文素材
     * @access public
     * @param string $media_id 要修改的图文消息的id
     * @param int $index 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * @param array $news 文章内容
     * @return array
     */
    public function updateNews($media_id, $index, $news)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['media_id' => $media_id, 'index' => $index, 'articles' => $news]);
    }

    /**
     * 上传图文消息内的图片获取URL
     * @access public
     * @param string $fileName 文件名
     * @param string $fileContent 文件内容
     * @param string $mimeType 文件类型
     * @return array
     */
    public function uploadImg($fileName, $fileContent, $mimeType = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN';
        return $this->handler->callMultipartPostApi($url, [], 'media', $fileName, $fileContent, $mimeType);
    }

    /**
     * 新增其他类型永久素材
     * @access public
     * @param string $fileName 文件名
     * @param string $fileContent 文件内容
     * @param string $mimeType 文件类型
     * @param string $type 媒体文件类型(image|voice|video|thumb)
     * @param array $description 包含素材的描述信息
     * @return array
     */
    public function addMaterial($fileName, $fileContent, $mimeType = null, $type = 'image', $description = [])
    {
        if (!in_array($type, ['image', 'voice', 'video', 'thumb'])) {
            throw new \Exception('Invalid Media Type.', '0');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=ACCESS_TOKEN&type={$type}";
        return $this->handler->callMultipartPostApi($url, ['description' => Tools::arr2json($description)], 'media', $fileName, $fileContent, $mimeType);
    }

    /**
     * 获取永久素材
     * @access public
     * @param string $media_id
     * @param null|string $outType 输出类型
     * @return array|string
     */
    public function getMaterial($media_id, $outType = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=ACCESS_TOKEN';
        if ($outType == 'url') return $url;
        return $this->handler->callPostApi($url, ['media_id' => $media_id]);
    }

    /**
     * 删除永久素材
     * @access public
     * @param string $mediaId
     * @return array
     */
    public function delMaterial($mediaId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['media_id' => $mediaId]);
    }

    /**
     * 获取素材总数
     * @access public
     * @return array
     */
    public function getMaterialCount()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取素材列表
     * @access public
     * @param string $type
     * @param int $offset
     * @param int $count
     * @return array
     */
    public function batchGetMaterial($type = 'image', $offset = 0, $count = 20)
    {
        if (!in_array($type, ['image', 'voice', 'video', 'news'])) {
            throw new \Exception('Invalid Media Type.', '0');
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['type' => $type, 'offset' => $offset, 'count' => $count]);
    }
}