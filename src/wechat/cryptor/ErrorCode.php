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

namespace think\wechat\cryptor;

/**
 * 仅用作类内部使用
 * 不用于官方API接口的错误码
 */
class ErrorCode
{

    public static $OK                       = 0;
    public static $ValidateSignatureError   = 40001;
    public static $ParseXmlError            = 40002;
    public static $ComputeSignatureError    = 40003;
    public static $IllegalAesKey            = 40004;
    public static $ValidateAppidError       = 40005;
    public static $EncryptAESError          = 40006;
    public static $DecryptAESError          = 40007;
    public static $IllegalBuffer            = 40008;
    public static $EncodeBase64Error        = 40009;
    public static $DecodeBase64Error        = 40010;
    public static $GenReturnXmlError        = 40011;
    public static $IllegalIv                = 40012;
    public static $errCode = [
        '0'     => '处理成功',
        '40001' => '校验签名失败',
        '40002' => '解析xml失败',
        '40003' => '计算签名失败',
        '40004' => '不合法的AESKey',
        '40005' => '校验AppID失败',
        '40006' => 'AES加密失败',
        '40007' => 'AES解密失败',
        '40008' => '接收的xml不合法',
        '40009' => 'Base64编码失败',
        '40010' => 'Base64解码失败',
        '40011' => '生成回包xml失败',
        '41012' => '不合法的向量',
    ];

    /**
     * 获取错误消息内容
     * @access public
     * @param string $code 错误代码
     * @return bool
     */
    public static function getErrText($code)
    {
        if (isset(static::$errCode[$code])) {
            return static::$errCode[$code];
        }
        return '未知';
    }

}