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

namespace axguowen\wechat\services\mini;

use think\wechat\Service;
use axguowen\wechat\utils\Tools;

/**
 * 微信小程序二维码
 */
class Qrcode extends Service
{
    /**
     * 默认线条颜色
     * @var string[]
     */
    protected $lineColor = ['r' => '0', 'g' => '0', 'b' => '0'];

    /**
     * 获取小程序码（永久有效）
     * 接口A: 适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @param bool $autoColor 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @param array|null $lineColor autoColor 为 false 时生效
     * @param boolean $isHyaline 透明底色
     * @param array $extra 其他参数
     * @return string|array
     */
    public function createMiniPath($path, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = true, array $extra = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN';
        $lineColor = empty($lineColor) ? $this->lineColor : $lineColor;
        $data = [
            'path' => $path,
            'width' => $width,
            'auto_color' => $autoColor,
            'line_color' => $lineColor,
            'is_hyaline' => $isHyaline,
        ];
        return $this->platform->callPostApi($url, array_merge($data, $extra));
    }

    /**
     * 获取小程序码（永久有效）
     * 接口B：适用于需要的码数量极多的业务场景
     * @access public
     * @param string $scene 最大32个可见字符，只支持数字
     * @param string $page 必须是已经发布的小程序存在的页面
     * @param integer $width 二维码的宽度
     * @param bool $autoColor 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @param array|null $lineColor autoColor 为 false 时生效
     * @param bool $isHyaline 是否需要透明底色
     * @param array $extra 其他参数
     * @return array|string
     */
    public function createMiniScene($scene, $page = '', $width = 430, $autoColor = false, $lineColor = null, $isHyaline = true, array $extra = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN';
        $lineColor = empty($lineColor) ? $this->lineColor : $lineColor;
        $data = [
            'scene' => $scene,
            'width' => $width,
            'page' => $page,
            'auto_color' => $autoColor,
            'line_color' => $lineColor,
            'is_hyaline' => $isHyaline,
            'check_path' => false
        ];
        if (empty($page)){
            unset($data['page']);
        }
        return $this->platform->callPostApi($url, array_merge($data, $extra));
    }

    /**
     * 获取小程序二维码（永久有效）
     * 接口C：适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @return array|string
     */
    public function createDefault($path, $width = 430)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['path' => $path, 'width' => $width]);
    }
}