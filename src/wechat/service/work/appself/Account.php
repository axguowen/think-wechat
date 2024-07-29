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

namespace think\wechat\service\work\appself;

use think\wechat\Service;

/**
 * 账号ID服务
 */
class Account extends Service
{
    /**
     * userid转换
     * 将代开发应用或第三方应用获取的密文open_userid转换为明文userid
     * @access public
     * @param string[] $openUseridList open_userid列表, 最多不超过1000个
     * @param int $sourceAgentid 企业授权的代开发自建应用或第三方应用的agentid
     * @return array
     */
    public function openuseridToUserid(array $openUseridList, $sourceAgentid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/openuserid_to_userid?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['open_userid_list' => $openUseridList, 'source_agentid' => $sourceAgentid]);
    }

    /**
     * external_userid转换
     * 将代开发应用或第三方应用获取的externaluserid转换成自建应用的externaluserid
     * @access public
     * @param string $externalUserid 服务商主体的external_userid
     * @param int $sourceAgentid 企业授权的代开发自建应用或第三方应用的agentid
     * @return array
     */
    public function fromServiceExternalUserid($externalUserid, $sourceAgentid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/from_service_external_userid?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['external_userid' => $externalUserid, 'source_agentid' => $sourceAgentid]);
    }

    /**
     * tmp_external_userid的转换
     * 将应用获取的外部用户临时idtmp_external_userid，转换为external_userid
     * @access public
     * @param string[] $tmpExternalUseridList 外部用户临时id
     * @param int $businessType 业务类型: 1会议,2收集表
     * @param int $userType 转换的目标用户类型: 1客户,2企业互联,3上下游,4互联企业(圈子)
     * @return array
     */
    public function convertTmpExternalUserid(array $tmpExternalUseridList, $businessType, $userType)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/convert_tmp_external_userid?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tmp_external_userid_list' => $tmpExternalUseridList,
            'business_type' => $businessType,
            'user_type' => $userType,
        ];
        return $this->handler->callPostApi($url, $data);
    }
}
