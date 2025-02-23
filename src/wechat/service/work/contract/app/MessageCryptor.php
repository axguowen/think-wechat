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
use think\wechat\cryptor\MsgCryptor;
use think\wechat\cryptor\ErrorCode;
use think\wechat\utils\Tools;

/**
 * 消息加解密服务基础类
 */
abstract class MessageCryptor extends Service
{
    /**
     * 解密事件消息内容
     * @access public
     * @param string $encrypted 加密的字符串
     * @param string $msgSignature 消息签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $returnRaw 是否返回原始数据
     * @return array
     */
    public function decrypt($encrypted, $msgSignature, $timestamp, $nonce, $returnRaw = false)
    {
        // 获取token
        $token = $this->handler->getConfig('token');
        // 加密密钥
        $encodingAesKey = $this->handler->getConfig('encoding_aes_key');

        // 构造安全签名数组
        $signatureArray = array($encrypted, $token, $timestamp, $nonce);
        // 按字典排序
		sort($signatureArray, SORT_STRING);
        // 生成本地签名
        $localSignature = sha1(implode($signatureArray));
        // 签名错误
		if ($localSignature != $msgSignature) {
			return [null, new \Exception(ErrorCode::getErrText(ErrorCode::$ValidateSignatureError))];
		}

        // 解密
        $result = MsgCryptor::decrypt($encrypted, $encodingAesKey);
        // 解密失败
        if ($result[0] != ErrorCode::$OK) {
			return [null, new \Exception(ErrorCode::getErrText($result[0]))];
		}

        // 如果是返回原始数据
        if($returnRaw){
            return [$result[1], null];
        }

        try{
            // 解密数据转数组
            $decryptData = Tools::xml2arr($result[1]);
        } catch (\Exception $e) {
            return [null, $e];
        }

        // 转换失败
        if(!is_array($decryptData)){
            return [null, new \Exception(ErrorCode::getErrText(ErrorCode::$ParseXmlError))];
        }
        // 返回
        return [$decryptData, null];
    }

    /**
     * 加密消息内容
     * @access public
     * @param array $data 消息内容
     * @return array
     */
    public function encrypt(array $data)
    {
        // 企业corpid
		$corpid = $this->handler->getConfig('corpid');
        // 获取token
        $token = $this->handler->getConfig('token');
        // 加密密钥
        $encodingAesKey = $this->handler->getConfig('encoding_aes_key');
        // 数组转XML
        $xml = Tools::arr2xml($data);
        // 获取加密结果
        $result = MsgCryptor::encrypt($xml, $corpid, $encodingAesKey);
        // 解密失败
        if ($result[0] != ErrorCode::$OK) {
			return [null, new \Exception(ErrorCode::getErrText($result[0]))];
		}
        // 获取加密内容
        $encrypted = $result[1];
        // 时间戳
        $timestamp = time();
        // 随机字符串
        $nonce = rand(77, 999) * rand(605, 888) * rand(11, 99);
        // 构造安全签名数组
        $signatureArray = array($encrypted, $token, $timestamp, $nonce);
        // 按字典排序
		sort($signatureArray, SORT_STRING);
        // 生成本地签名
        $localSignature = sha1(implode($signatureArray));
        // 加密数据格式
        $format = '<xml><Encrypt><![CDATA[%s]]></Encrypt><MsgSignature><![CDATA[%s]]></MsgSignature><TimeStamp>%s</TimeStamp><Nonce><![CDATA[%s]]></Nonce></xml>';
        // 返回
        return [sprintf($format, $encrypted, $localSignature, $timestamp, $nonce), null];
    }

    /**
     * 解密分享私密消息内容
     * @access public
     * @param string $encryptedData 加密的字符串
     * @param string $iv 加密向量
     * @param string $ticket agentConfig使用的ticket
     * @return array
     */
    public function decryptShareInfo($encryptedData, $iv, $ticket)
    {
        // 解密
        $result = MsgCryptor::decryptShareInfo($encryptedData, $iv, $ticket);
        // 解密失败
        if ($result[0] != ErrorCode::$OK) {
			return [null, new \Exception(ErrorCode::getErrText($result[0]))];
		}

        try{
            // 解密数据转数组
            $decryptData = Tools::json2arr($result[1]);
        } catch (\Exception $e) {
            return [null, $e];
        }

        // 转换失败
        if(!is_array($decryptData)){
            return [null, new \Exception('解析JSON失败')];
        }
        // 返回
        return [$decryptData, null];
    }
}