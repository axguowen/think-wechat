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

namespace think\wechat\service\work\contract\app;

use think\wechat\Service;
use think\wechat\utils\Tools;
use think\wechat\exception\InvalidResponseException;

/**
 * 素材管理服务基础类
 */
abstract class Media extends Service
{
    /**
     * 上传临时素材
     * @access public
     * @param string $filename 文件名称
     * @param string $type 媒体文件类型, image图片、voice语音、video视频, file普通文件
     * @return array
     */
    public function upload($filename, $type = 'file')
    {
        if (!in_array($type, ['image', 'voice', 'video', 'file'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        // 请求地址
        $url = "https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type={$type}";
        return $this->platform->callPostApi($url, ['media' => Tools::createCurlFile($filename)], [], [], false);
    }

    /**
     * 上传图片
     * @access public
     * @param string $filename 文件名称
     * @param string $type 媒体文件类型, image图片、voice语音、video视频, file普通文件
     * @return array
     */
    public function uploadimg($filename)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['media' => Tools::createCurlFile($filename)], [], [], false);
    }

    /**
     * 获取临时素材
     * @access public
     * @param string $mediaId 媒体文件id
     * @return array
     */
    public function get($mediaId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id={$mediaId}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取高清语音素材
     * @access public
     * @param string $mediaId 媒体文件id
     * @return array
     */
    public function getJssdk($mediaId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id={$mediaId}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 异步上传临时素材
     * @access public
     * @param string $filename 文件名
     * @param string $type 媒体文件类型, video视频, file普通文件
     * @param string $url 文件cdn url
     * @param string $md5 文件md5
     * @param int $scene 场景值
     * @return array
     */
    public function uploadByUrl($filename, $url, $md5, $type = 'file', $scene = 1)
    {
        if (!in_array($type, ['video', 'file'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/media/upload_by_url?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'filename' => $filename,
            'url' => $url,
            'md5' => $md5,
            'type' => $type,
            'scene' => $scene,
        ]);
    }
}