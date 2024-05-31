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

namespace think\wechat\platform\contract;

use think\wechat\utils\DataArray;
use think\wechat\utils\Tools;
use think\wechat\cryptor\PrpCryptor;
use think\wechat\exception\InvalidArgumentException;
use think\wechat\exception\InvalidDecryptException;
use think\wechat\exception\InvalidResponseException;

/**
 * 微信通知处理基本类
 */
class BasicPushEvent
{
    /**
     * 公众号APPID
     * @var string
     */
    protected $appid;

    /**
     * 公众号推送XML内容
     * @var string
     */
    protected $postxml;

    /**
     * 公众号推送加密类型
     * @var string
     */
    protected $encryptType;

    /**
     * 公众号的推送请求参数
     * @var DataArray
     */
    protected $input;

    /**
     * 当前公众号配置对象
     * @var DataArray
     */
    protected $config;

    /**
     * 公众号推送内容对象
     * @var DataArray
     */
    protected $receive;

    /**
     * 准备回复的消息内容
     * @var array
     */
    protected $message;

    /**
     * BasicPushEvent constructor.
     * @access public
     * @param array $options 配置参数
     * @param boolean $showEchoStr 回显内容
     * @throws InvalidResponseException
     */
    public function __construct(array $options, $showEchoStr = true)
    {
        if (empty($options['appid'])) {
            throw new InvalidArgumentException("Missing Config -- [appid]");
        }
        if (empty($options['appsecret'])) {
            throw new InvalidArgumentException("Missing Config -- [appsecret]");
        }
        if (empty($options['token'])) {
            throw new InvalidArgumentException("Missing Config -- [token]");
        }
        // 参数初始化
        $this->config = new DataArray($options);
        $this->input = new DataArray($_REQUEST);
        $this->appid = $this->config->get('appid');
        // 推送消息处理
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->postxml = Tools::getRawInput();
            $this->encryptType = $this->input->get('encrypt_type');
            if ($this->isEncrypt()) {
                if (empty($options['encodingaeskey'])) {
                    throw new InvalidArgumentException("Missing Config -- [encodingaeskey]");
                }
                $prpcrypt = new PrpCryptor($this->config->get('encodingaeskey'));
                $result = Tools::xml2arr($this->postxml);
                $array = $prpcrypt->decrypt($result['Encrypt']);
                if (intval($array[0]) > 0) {
                    throw new InvalidResponseException($array[1], $array[0]);
                }
                list($this->postxml, $this->appid) = [$array[1], $array[2]];
            }
            $this->receive = new DataArray(Tools::xml2arr($this->postxml));
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET" && $this->checkSignature()) {
            $this->receive = new DataArray([]);
            if ($showEchoStr && ob_clean()) {
                echo($this->input->get('echostr'));
            }
        } else {
            throw new InvalidResponseException('Invalid interface request.', '0');
        }
    }

    /**
     * 获取回显字串
     * @return string
     */
    public function getEchoStr()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && $this->checkSignature()) {
            return $this->input->get('echostr');
        } else {
            return '';
        }
    }

    /**
     * 消息是否需要加密
     * @access public
     * @return boolean
     */
    public function isEncrypt()
    {
        return $this->encryptType === 'aes';
    }

    /**
     * 回复消息
     * @access public
     * @param array $data 消息内容
     * @param boolean $return 是否返回XML内容
     * @param boolean $isEncrypt 是否加密内容
     * @return string|void
     * @throws InvalidDecryptException
     */
    public function reply(array $data = [], $return = false, $isEncrypt = false)
    {
        $xml = Tools::arr2xml(empty($data) ? $this->message : $data);
        if ($this->isEncrypt() || $isEncrypt) {
            $prpcrypt = new PrpCryptor($this->config->get('encodingaeskey'));
            // 如果是第三方平台，加密得使用 component_appid
            $component_appid = $this->config->get('component_appid');
            $appid = empty($component_appid) ? $this->appid : $component_appid;
            $array = $prpcrypt->encrypt($xml, $appid);
            if ($array[0] > 0) throw new InvalidDecryptException('Encrypt Error.', '0');
            list($timestamp, $encrypt) = [time(), $array[1]];
            $nonce = rand(77, 999) * rand(605, 888) * rand(11, 99);
            $tmpArr = [$this->config->get('token'), $timestamp, $nonce, $encrypt];
            sort($tmpArr, SORT_STRING);
            $signature = sha1(implode($tmpArr));
            $format = "<xml><Encrypt><![CDATA[%s]]></Encrypt><MsgSignature><![CDATA[%s]]></MsgSignature><TimeStamp>%s</TimeStamp><Nonce><![CDATA[%s]]></Nonce></xml>";
            $xml = sprintf($format, $encrypt, $signature, $timestamp, $nonce);
        }
        if ($return) return $xml;
        @ob_clean();
        echo $xml;
    }

    /**
     * 验证来自微信服务器
     * @access protected
     * @return bool
     */
    protected function checkSignature()
    {
        $nonce = $this->input->get('nonce');
        $timestamp = $this->input->get('timestamp');
        $msg_signature = $this->input->get('msg_signature');
        $signature = empty($msg_signature) ? $this->input->get('signature') : $msg_signature;
        $tmpArr = [$this->config->get('token'), $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        return sha1(implode($tmpArr)) === $signature;
    }

    /**
     * 获取公众号推送对象
     * @access public
     * @param null|string $field 指定获取字段
     * @return array
     */
    public function getReceive($field = null)
    {
        return $this->receive->get($field);
    }

    /**
     * 获取当前微信OPENID
     * @access public
     * @return string
     */
    public function getOpenid()
    {
        return $this->receive->get('FromUserName');
    }

    /**
     * 获取当前推送消息类型
     * @access public
     * @return string
     */
    public function getMsgType()
    {
        return $this->receive->get('MsgType');
    }

    /**
     * 获取当前推送消息ID
     * @access public
     * @return string
     */
    public function getMsgId()
    {
        return $this->receive->get('MsgId');
    }

    /**
     * 获取当前推送时间
     * @access public
     * @return integer
     */
    public function getMsgTime()
    {
        return $this->receive->get('CreateTime');
    }

    /**
     * 获取当前推送公众号
     * @access public
     * @return string
     */
    public function getToOpenid()
    {
        return $this->receive->get('ToUserName');
    }
}