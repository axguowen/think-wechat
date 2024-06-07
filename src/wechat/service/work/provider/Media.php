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

namespace think\wechat\service\work\provider;

use think\wechat\Service;
use think\wechat\utils\Tools;
use think\wechat\exception\InvalidResponseException;
/**
 * 企业微信服务商素材管理服务
 */
class Media extends Service
{
    /**
     * 服务商上传临时素材
     * @access public
     * @param string $filename 文件名称
     * @param string $type 媒体文件类型, image图片、voice语音、video视频, file普通文件
     * @param int $attachmentType 附件类型, 不同的附件类型用于不同的场景, 3收银台
     * @return array
     */
    public function upload($filename, $type = 'file', $attachmentType = 0)
    {
        if (!in_array($type, ['image', 'voice', 'video', 'file'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        // 请求地址
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/media/upload?provider_access_token=ACCESS_TOKEN&type={$type}";
        // 指定附件类型
        if($attachmentType > 0){
            $url .= "&attachment_type={$attachmentType}";
        }
        return $this->platform->callPostApi($url, ['media' => Tools::createCurlFile($filename)], [], [], false);
    }
}