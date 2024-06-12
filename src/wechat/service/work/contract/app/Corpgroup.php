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
 * 企业微信应用企业互联&上下游服务基础类
 */
abstract class Corpgroup extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
    /**
     * 获取应用共享信息
     * @access public
     * @param int $agentid 上级/上游企业应用agentid
     * @param int $businessType 0企业互联/局校互联, 1上下游企业
     * @param string $corpid 下级/下游企业corpid
     * @param int $limit 返回的最大记录数
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function listAppShareInfo($agentid, $businessType = null, $corpid = '', $limit = 10, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/list_app_share_info?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'agentid' => $agentid,
            'limit' => $limit,
        ];
        // 指定业务类型
        if(!is_null($businessType)){
            $data['business_type'] = $businessType;
        }
        // 指定下游企业ID
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url);
    }

    /**
     * 获取下级/下游企业的access_token
     * @access public
     * @param string $corpid 已授权的下级/下游企业corpid
     * @param int $agentid 已授权的下级/下游企业应用ID
     * @param int $businessType 0企业互联/局校互联, 1上下游企业
     * @return array
     */
    public function gettoken($corpid, $agentid, $businessType = null)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/gettoken?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'corpid' => $corpid,
            'agentid' => $agentid,
        ];
        // 指定业务类型
        if(!is_null($businessType)){
            $data['business_type'] = $businessType;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取下级/下游企业小程序session
     * @access public
     * @param string $userid 通过code2Session接口获取到的加密的userid
     * @param string $sessionKey 通过code2Session接口获取到的属于上级/上游企业的会话密钥
     * @return array
     */
    public function transferSession($userid, $sessionKey)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/miniprogram/transfer_session?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid, 'session_key' => $sessionKey]);
    }

    /**
     * 通过unionid和openid查询external_userid
     * @access public
     * @param string $unionid 微信客户的unionid
     * @param string $openid 微信客户的openid
     * @param string $corpid 需要换取的企业corpid，不填则拉取所有企业
     * @param string $massCallTicket 大批量调用凭据
     * @return array
     */
    public function unionidToExternalUserid($unionid, $openid, $corpid = '', $massCallTicket = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/unionid_to_external_userid?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'unionid' => $unionid,
            'openid' => $openid,
        ];
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
        if(!empty($massCallTicket)){
            $data['mass_call_ticket'] = $massCallTicket;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * unionid查询pending_id
     * @access public
     * @param string $unionid 微信客户的unionid
     * @param string $openid 微信客户的openid
     * @return array
     */
    public function unionidToPendingId($unionid, $openid)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/unionid_to_pending_id?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'unionid' => $unionid,
            'openid' => $openid,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * external_userid查询pending_id
     * @access public
     * @param string $externalUserid 上游或下游企业外部联系人id
     * @param string $chatId 群id
     * @return array
     */
    public function externalUseridToPendingId($externalUserid, $chatId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/batch/external_userid_to_pending_id?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'external_userid' => $externalUserid,
            'chat_id' => $chatId,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 上下游通讯录管理
    // +=======================
    /**
     * 获取上下游列表
     * @access public
     * @return array
     */
    public function getChainList()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/get_chain_list?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取上下游通讯录分组
     * @access public
     * @param string $chainId 上下游id
     * @param int $groupid 分组id
     * @return array
     */
    public function getChainGroup($chainId, $groupid = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/get_chain_group?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
        ];
        if($groupid > 0){
            $data['groupid'] = $groupid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取企业上下游通讯录分组下的企业详情列表
     * @access public
     * @param string $chainId 上下游id
     * @param int $groupid 分组id
     * @param bool $needPending 是否需要返回未加入的企业
     * @param int $limit 每页数量
     * @param string $cursor 分页游标
     * @return array
     */
    public function getChainCorpinfoList($chainId, $groupid = 0, $needPending = false, $limit = 10, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/get_chain_corpinfo_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'need_pending' => $needPending,
            'limit' => $limit,
        ];
        if($groupid > 0){
            $data['groupid'] = $groupid;
        }
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取企业上下游通讯录下的企业信息
     * @access public
     * @param string $chainId 上下游id
     * @param string $corpid 企业id
     * @param string $pendingCorpid 是否需要返回未加入的企业
     * @return array
     */
    public function getChainCorpinfo($chainId, $corpid = '', $pendingCorpid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/get_chain_corpinfo?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
        ];
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
        if(!empty($pendingCorpid)){
            $data['pending_corpid'] = $pendingCorpid;
        }
        return $this->platform->callPostApi($url, $data);
    }
}