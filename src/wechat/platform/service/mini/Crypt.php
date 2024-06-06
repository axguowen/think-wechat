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

namespace think\wechat\platform\service\mini;

use think\wechat\platform\service\Service;
use think\wechat\utils\HttpClient;
use think\wechat\cryptor\MiniCryptor;
use think\wechat\exception\InvalidResponseException;
use think\wechat\exception\InvalidDecryptException;

/**
 * 数据加密处理
 */
class Crypt extends Service
{
    /**
     * 数据签名校验
     * @access public
     * @param string $iv
     * @param string $sessionKey
     * @param string $encryptedData
     * @return bool|array
     */
    public function decode($iv, $sessionKey, $encryptedData)
    {
        $miniCryptor = new MiniCryptor($this->platform->getConfig('appid'), $sessionKey);
        $errCode = $miniCryptor->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            return json_decode($data, true);
        }
        return false;
    }

    /**
     * 登录凭证校验
     * @access public
     * @param string $code 登录时获取的 code
     * @return array
     */
    public function session($code)
    {
        $appid = $this->platform->getConfig('appid');
        $secret = $this->platform->getConfig('appsecret');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
        return json_decode(HttpClient::get($url), true);
    }

    /**
     * 换取用户信息
     * @access public
     * @param string $code 用户登录凭证（有效期五分钟）
     * @param string $iv 加密算法的初始向量
     * @param string $encryptedData 加密数据( encryptedData )
     * @return array
     * @throws InvalidResponseException
     * @throws InvalidDecryptException
     */
    public function userInfo($code, $iv, $encryptedData)
    {
        $result = $this->session($code);
        if (empty($result['session_key'])) {
            return [null, new InvalidResponseException('Code 换取 SessionKey 失败', 403)];
        }
        $userinfo = $this->decode($iv, $result['session_key'], $encryptedData);
        if (empty($userinfo)) {
            return [null, new InvalidDecryptException('用户信息解析失败', 403)];
        }
        return [array_merge($result, $userinfo), null];
    }

    /**
     * 通过授权码换取手机号
     * @access public
     * @param string $code
     * @return array
     */
    public function getPhoneNumber($code)
    {
        $url = 'https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['code' => $code]);
    }

    /**
     * 用户支付完成后，获取该用户的 UnionId
     * @access public
     * @param string $openid 支付用户唯一标识
     * @param null|string $transaction_id 微信支付订单号
     * @param null|string $mch_id 微信支付分配的商户号，和商户订单号配合使用
     * @param null|string $out_trade_no 微信支付商户订单号，和商户号配合使用
     * @return array
     */
    public function getPaidUnionId($openid, $transaction_id = null, $mch_id = null, $out_trade_no = null)
    {
        $url = "https://api.weixin.qq.com/wxa/getpaidunionid?access_token=ACCESS_TOKEN&openid={$openid}";
        if (is_null($mch_id)) $url .= "&mch_id={$mch_id}";
        if (is_null($out_trade_no)) $url .= "&out_trade_no={$out_trade_no}";
        if (is_null($transaction_id)) $url .= "&transaction_id={$transaction_id}";
        return $this->platform->callGetApi($url);
    }
}