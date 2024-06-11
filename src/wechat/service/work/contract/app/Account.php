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

/**
 * 第三方应用和代开发应用账号ID服务基础类
 */
abstract class Account extends Service
{
    /**
     * userid的转换
     * 将企业主体下的明文userid转换为服务商主体下的密文userid
     * @access public
     * @param string[] $useridList 获取到的成员ID列表
     * @return array
     */
    public function useridToOpenuserid(array $useridList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/userid_to_openuserid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid_list' => $useridList]);
    }

    /**
     * 转换客户external_userid
     * 将企业主体下的external_userid转换为服务商主体下的external_userid
     * @access public
     * @param string[] $externalUseridList 企业主体下的external_userid列表
     * @return array
     */
    public function getNewExternalUserid(array $externalUseridList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_new_external_userid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['external_userid_list' => $externalUseridList]);
    }

    /**
     * 转换客户群成员external_userid
     * 将企业主体下的external_userid转换为服务商主体下的external_userid
     * @access public
     * @param string $chatId 客户群ID
     * @param string[] $externalUseridList 企业主体下的external_userid列表
     * @return array
     */
    public function getNewGroupExternalUserid($chatId, array $externalUseridList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get_new_external_userid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['chat_id' => $chatId, 'external_userid_list' => $externalUseridList]);
    }

    /**
     * unionid转换为第三方external_userid
     * @access public
     * @param string $unionid 微信客户的unionid
     * @param string $openid 微信客户的openid
     * @param string $subjectType 小程序或公众号的主体类型: 0企业(默认), 1服务商
     * @return array
     */
    public function unionidToExternalUserid($unionid, $openid, $subjectType = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/convert_tmp_external_userid?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tmp_external_userid_list' => $tmpExternalUseridList,
            'business_type' => $businessType,
            'user_type' => $userType,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * external_userid查询pending_id
     * @access public
     * @param string[] $externalUserid 该企业的外部联系人ID
     * @param string $chatId 客户群ID
     * @return array
     */
    public function externalUseridToPendingId(array $externalUserid, $chatId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/batch/external_userid_to_pending_id?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'external_userid' => $externalUserid,
        ];
        // 指定了群ID
        if(!empty($chatId)){
            $data['chat_id'] = $chatId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 客户标签ID的转换
     * 将企业主体下的客户标签ID(含标签组ID)转换成服务商主体下的客户标签ID
     * @access public
     * @param string[] $externalTagidList 企业主体下的客户标签ID或标签组ID列表
     * @return array
     */
    public function externalTagid(array $externalTagidList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/external_tagid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['external_tagid_list' => $externalTagidList]);
    }

    /**
     * 微信客服ID的转换
     * 将企业主体下的微信客服ID转换成服务商主体下的微信客服ID
     * @access public
     * @param string[] $openKfidList 微信客服ID列表
     * @return array
     */
    public function openKfid(array $openKfidList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/open_kfid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['open_kfid_list' => $openKfidList]);
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
        return $this->platform->callPostApi($url, $data);
    }
}