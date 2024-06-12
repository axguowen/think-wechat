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

namespace think\wechat\service\work\appthird;

use think\wechat\service\work\contract\app\Corpgroup as Service;

/**
 * 企业微信应用企业互联&上下游服务
 */
class Corpgroup extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
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
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 获取企业上下游通讯录下的企业信息
     * @access public
     * @param string $chainId 上下游id
     * @param string $corpid 分组id
     * @param string $pendingCorpid 是否需要返回未加入的企业
     * @return array
     */
    public function getChainCorpinfo($chainId, $corpid = '', $pendingCorpid = '')
    {
        return [null, new \Exception('不支持该方法')];
    }
}