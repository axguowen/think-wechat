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
use think\wechat\utils\Tools;

/**
 * 客户联系服务
 */
class ExternalContact extends Service
{
    // +=======================
    // | 客户管理
    // +=======================
    /**
     * 第三方主体unionid转换为第三方external_userid
     * @access public
     * @param string $unionid 微信用户的unionid
     * @param string $openid 微信用户的openid
     * @param string $corpid 需要换取的企业corpid，不填则拉取所有企业
     * @return array
     */
    public function unionidToExternalUserid($unionid, $openid, $corpid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/externalcontact/unionid_to_external_userid_3rd?suite_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'unionid' => $unionid,
            'openid' => $openid,
        ];
        // 指定企业corpid
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 获客助手组件(仅获客助手组件可调用)
    // +=======================
    /**
     * 获取待支付流水
     * @access public
     * @param string $authCorpid 授权企业corpid
     * @param int $beginTime 流水记录开始时间
     * @param int $endTime 流水记录结束时间
     * @param int $limit 返回的最大记录数
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function getBillList($authCorpid, $beginTime, $endTime, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/customer_acquisition/get_bill_list?suite_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'auth_corpid' => $authCorpid,
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'limit' => $limit,
        ];
        // 指定游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }
}