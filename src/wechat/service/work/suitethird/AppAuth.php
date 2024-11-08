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

namespace think\wechat\service\work\suitethird;

use think\wechat\service\work\contract\suite\AppAuth as Service;

/**
 * 应用授权服务
 */
class AppAuth extends Service
{
    // +=======================
    // | 接口调用
    // +=======================
    /**
     * 获取预授权码
     * @access public
     * @return array
     */
    public function getPreAuthCode()
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=ACCESS_TOKEN';
        // 返回结果
        return $this->handler->callGetApi($url);
    }

    /**
     * 设置授权配置
     * @access public
     * @param string $preAuthCode 预授权码
     * @param int $authType 授权类型: 0正式授权,1测试授权,默认值为0; 注意: 请确保应用在正式发布后的授权类型为正式授权
     * @return array
     */
    public function setSessionInfo($preAuthCode, $authType = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/set_session_info?suite_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'pre_auth_code' => $preAuthCode,
            'session_info' => [
                'auth_type' => $authType,
            ],
        ];
        // 返回结果
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取授权链接
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $preAuthCode 预授权码
     * @param array $options 其它参数
     * @return string
     */
    public function getAuthUrl($redirectUri, $state = '', $preAuthCode = '', $options = [])
    {
        $suiteId = $this->handler->getConfig('suite_id');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        // 如果未设置预授权码
        if(empty($preAuthCode)){
            // 获取预授权码
            $getPreAuthCodeResult = $this->getPreAuthCode();
            // 失败
            if(is_null($getPreAuthCodeResult[0])){
                return $getPreAuthCodeResult[1]->getMessage();
            }
            // 获取结果
            $preAuthCode = $getPreAuthCodeResult[0]['pre_auth_code'];
        }
        // 如果设置了授权类型
        if(isset($options['auth_type'])){
            // 设置授权配置
            $setSessionInfoResult = $this->setSessionInfo($preAuthCode, $options['auth_type']);
            // 失败
            if(is_null($setSessionInfoResult[0])){
                return $setSessionInfoResult[1]->getMessage();
            }
        }
        // 返回授权链接
        return "https://open.work.weixin.qq.com/3rdapp/install?suite_id={$suiteId}&pre_auth_code={$preAuthCode}&redirect_uri={$redirectUri}&state={$state}";
    }

    /**
     * 获取企业凭证
     * @access public
     * @param string $authCorpid 授权方corpid
     * @param string $permanentCode 企业永久授权码
     * @return array
     */
    public function getCorpToken($authCorpid, $permanentCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['auth_corpid' => $authCorpid, 'permanent_code' => $permanentCode]);
    }

    /**
     * 获取应用二维码
     * @access public
     * @param string $state 用于区分不同的安装渠道, 可以填写a-zA-Z0-9, 长度不可超过32个字节
     * @param int $style 二维码样式选项, 默认为不带说明外框小尺寸
     *                          0带说明外框的二维码, 适合于实体物料
     *                          1带说明外框的二维码, 适合于屏幕类
     *                          2不带说明外框（小尺寸）
     *                          3不带说明外框（中尺寸）
     *                          4不带说明外框（大尺寸） 
     * @param int $resultType 结果返回方式, 1二维码图片buffer(默认), 2二维码图片url
     * @return array
     */
    public function getAppQrcode($state = '', $style = 2, $resultType = 2)
    {
        $suiteId = $this->handler->getConfig('suite_id');
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_app_qrcode?suite_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'suite_id' => $suiteId,
            'state' => $state,
            'style' => $style,
            'result_type' => $resultType
        ];
        return $this->handler->callPostApi($url, $data);
    }
}
