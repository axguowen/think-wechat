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
 * PKCS7算法加解密
 */
class PKCS7Encoder
{

    /**
     * 补位块大小
     * @var int
     */
    public static $blockSize = 32;

    /**
     * 对需要加密的明文进行填充补位
     * @param string $text 需要进行填充补位操作的明文
     * @return string 补齐明文字符串
     */
    function encode($text)
    {
        $amount_to_pad = PKCS7Encoder::$blockSize - (strlen($text) % PKCS7Encoder::$blockSize);
        if ($amount_to_pad == 0) {
            $amount_to_pad = PKCS7Encoder::$blockSize;
        }
        list($pad_chr, $tmp) = [chr($amount_to_pad), ''];
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * 对解密后的明文进行补位删除
     * @param string $text 解密后的明文
     * @return string 删除填充补位后的明文
     */
    function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > PKCS7Encoder::$blockSize) {
            $pad = 0;
        }
        return substr($text, 0, strlen($text) - $pad);
    }

}