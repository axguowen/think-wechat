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

namespace think\wechat\service\mini;

use think\wechat\Service;

/**
 * 小程序ORC服务
 */
class Ocr extends Service
{
    /**
     * 本接口提供基于小程序的银行卡 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function bankcard($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/bankcard?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }

    /**
     * 本接口提供基于小程序的营业执照 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function businessLicense($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/bizlicense?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }

    /**
     * 本接口提供基于小程序的驾驶证 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function driverLicense($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/drivinglicense?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }

    /**
     * 本接口提供基于小程序的身份证 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function idcard($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/idcard?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }

    /**
     * 本接口提供基于小程序的通用印刷体 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function printedText($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/comm?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }

    /**
     * 本接口提供基于小程序的行驶证 OCR 识别
     * @access public
     * @param array $data
     * @return array
     */
    public function vehicleLicense($data)
    {
        $url = 'https://api.weixin.qq.com/cv/ocr/driving?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data,[] ,[] , false);
    }
}