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
 * 消息加解密器
 */
class MsgCryptor
{
    /**
     * 对明文进行加密
     * @access public
     * @param string $text 需要加密的明文
     * @param string $receiveId ReceiveId
     * @param string $encodingAESKey EncodingAESKey
     * @return array
     */
    public static function encrypt($text, $receiveId, $encodingAESKey)
    {
        try {
            // 解码
            $aesKey = base64_decode($encodingAESKey . '=');
            // 生成16位随机字符串，填充到明文之前
            $random = static::getRandomStr();
            // 获取加密向量
            $iv = substr($aesKey, 0, 16);
            // 补位块填充
            $text = PKCS7Encoder::encode($random . pack('N', strlen($text)) . $text . $receiveId);
            // 加密
            $encrypted = openssl_encrypt($text, 'AES-256-CBC', substr($aesKey, 0, 32), OPENSSL_ZERO_PADDING, $iv);
            // 返回
            return [ErrorCode::$OK, $encrypted];
        } catch (\Exception $e) {
            return [ErrorCode::$EncryptAESError, null];
        }
    }

    /**
     * 对密文进行解密
     * @access public
     * @param string $encrypted 需要解密的密文
     * @param string $encodingAESKey EncodingAESKey
     * @return array
     */
    public static function decrypt($encrypted, $encodingAESKey)
    {
        try {
            // 解码
            $aesKey = base64_decode($encodingAESKey . '=');
            // 获取加密向量
            $iv = substr($aesKey, 0, 16);
            // 解密
            $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', substr($aesKey, 0, 32), OPENSSL_ZERO_PADDING, $iv);
        } catch (\Exception $e) {
            return [ErrorCode::$DecryptAESError, null];
        }
        try {
            // 补位块删除
            $result = PKCS7Encoder::decode($decrypted);
            // 长度不够
            if (strlen($result) < 16) {
                return [ErrorCode::$DecryptAESError, null];
            }
            // 去掉前16位随机字符
            $content = substr($result, 16, strlen($result));
            // 解包内容长度
            $len_list = unpack('N', substr($content, 0, 4));
            // 获取内容长度
            $xml_len = $len_list[1];
            // 返回
            return [ErrorCode::$OK, substr($content, 4, $xml_len), substr($content, $xml_len + 4)];
        } catch (\Exception $e) {
            return [ErrorCode::$IllegalBuffer, null];
        }
    }

    /**
     * 随机生成16位字符串
     * @access protected
     * @param string $str
     * @return string 生成的字符串
     */
    protected static function getRandomStr($str = '')
    {
        $str_pol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}
