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
use think\wechat\cryptor\MsgCryptor;
use think\wechat\cryptor\ErrorCode;
use think\wechat\exception\InvalidArgumentException;

/**
 * 事件消息接收服务
 */
class EventMessage extends Service
{
    /**
     * 解密事件消息内容
     * @access public
     * @param string $encrypted 加密的字符串
     * @param string $msgSignature 消息签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $verification 是否是验证模式
     * @return array
     */
    public function decrypt($encrypted, $msgSignature, $timestamp, $nonce, $verification = false)
    {
		// 企业ID
		$corpid = $this->platform->getConfig('corpid');
        // 获取token
        $token = $this->platform->getConfig('token');
        // 加密密钥
        $encodingAesKey = $this->platform->getConfig('encoding_aes_key');

        // 构造安全签名数组
        $signatureArray = array($encrypted, $token, $timestamp, $nonce);
        // 按字典排序
		sort($signatureArray, SORT_STRING);
        // 生成本地签名
        $localSignature = sha1(implode($signatureArray));
        // 签名错误
		if ($localSignature != $msgSignature) {
			return [null, new InvalidArgumentException(ErrorCode::getErrText(ErrorCode::$ValidateSignatureError))];
		}

        // 解密
        $result = MsgCryptor::decrypt($encrypted, $encodingAesKey);
        // 解密失败
        if ($result[0] != ErrorCode::$OK) {
			return [null, new InvalidArgumentException(ErrorCode::getErrText($result[0]))];
		}

        // receiveId不正确
        if ($result[2] != $corpid) {
            return [null, new InvalidArgumentException(ErrorCode::getErrText(ErrorCode::$ValidateReceiveIdError))];
        }
        // 返回
        return [$result[1], null];
    }
}