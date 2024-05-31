<?php
// +----------------------------------------------------------------------
// | WeChat SDK [WeChat SDK for PHP]
// +----------------------------------------------------------------------
// | WeChat SDK
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

namespace axguowen\wechat\services\mini;

use axguowen\WeChat;
use axguowen\wechat\utils\Tools;

/**
 * 微信小程序二维码
 */
class Qrcode extends WeChat
{
    /**
     * 默认线条颜色
     * @var string[]
     */
    private $lineColor = ['r' => '0', 'g' => '0', 'b' => '0'];

    /**
     * 获取小程序码（永久有效）
     * 接口A: 适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @param bool $autoColor 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @param array|null $lineColor autoColor 为 false 时生效
     * @param boolean $isHyaline 透明底色
     * @param string|null $outType 输出类型
     * @param array $extra 其他参数
     * @return string|array
     */
    public function createMiniPath($path, $width = 430, $autoColor = false, $lineColor = null, $isHyaline = true, $outType = null, array $extra = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $lineColor = empty($lineColor) ? $this->lineColor : $lineColor;
        $data = ['path' => $path, 'width' => $width, 'auto_color' => $autoColor, 'line_color' => $lineColor, 'is_hyaline' => $isHyaline];
        return $this->parseResult(Tools::post($url, Tools::arr2json(array_merge($data, $extra))), $outType);
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
     * @param null|string $outType 输出类型
     * @param array $extra 其他参数
     * @return array|string
     */
    public function createMiniScene($scene, $page = '', $width = 430, $autoColor = false, $lineColor = null, $isHyaline = true, $outType = null, array $extra = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $lineColor = empty($lineColor) ? $this->lineColor : $lineColor;
        $data = ['scene' => $scene, 'width' => $width, 'page' => $page, 'auto_color' => $autoColor, 'line_color' => $lineColor, 'is_hyaline' => $isHyaline, 'check_path' => false];
        if (empty($page)) unset($data['page']);
        return $this->parseResult(Tools::post($url, Tools::arr2json(array_merge($data, $extra))), $outType);
    }

    /**
     * 获取小程序二维码（永久有效）
     * 接口C：适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @param string|null $outType 输出类型
     * @return array|string
     */
    public function createDefault($path, $width = 430, $outType = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->parseResult(Tools::post($url, Tools::arr2json(['path' => $path, 'width' => $width])), $outType);
    }

    /**
     * 解释接口数据
     * @access protected
     * @param bool|string $result
     * @param null|string $outType
     * @return array|mixed
     */
    protected function parseResult($result, $outType)
    {
        if (is_array($json = json_decode($result, true))) {
            if (!$this->isTry && isset($json['errcode']) && in_array($json['errcode'], ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            return Tools::json2arr($result);
        } else {
            return is_null($outType) ? $result : $outType($result);
        }
    }
}