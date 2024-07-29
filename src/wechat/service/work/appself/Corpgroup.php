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

use think\wechat\service\work\contract\app\Corpgroup as Service;

/**
 * 企业微信应用企业互联&上下游服务
 */
class Corpgroup extends Service
{
    // +=======================
    // | 上下游通讯录管理
    // +=======================
    /**
     * 提交批量导入上下游联系人任务
     * @access public
     * @param string $chainId 上下游id
     * @param array $contactList 上下游联系人列表
     * @return array
     */
    public function importChainContact($chainId, array $contactList)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/import_chain_contact?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'contact_list' => $contactList
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取异步任务结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function getresult($jobid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/corpgroup/getresult?access_token=ACCESS_TOKEN&jobid={$jobid}";
        return $this->handler->callGetApi($url);
    }

    /**
     * 移除下游/下级企业
     * @access public
     * @param string $chainId 上下游id
     * @param string $corpid 企业id
     * @param string $pendingCorpid 是否需要返回未加入的企业
     * @return array
     */
    public function removeCorp($chainId, $corpid = '', $pendingCorpid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/remove_corp?access_token=ACCESS_TOKEN';
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
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询成员自定义id
     * @access public
     * @param string $chainId 上下游id
     * @param string $corpid 已加入企业id
     * @param string $userid 企业内的成员
     * @return array
     */
    public function getChainUserCustomId($chainId, $corpid, $userid)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/corp/get_chain_user_custom_id?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'corpid' => $corpid,
            'userid' => $userid,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询成员自定义id
     * @access public
     * @param string $corpid 已加入企业id
     * @return array
     */
    public function getCorpSharedChainList($corpid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/get_corp_shared_chain_list?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['corpid' => $corpid]);
    }
    
    // +=======================
    // | 上下游规则
    // +=======================
    /**
     * 获取对接规则id列表
     * @access public
     * @param string $chainId 上下游id
     * @return array
     */
    public function ruleListIds($chainId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/rule/list_ids?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['chain_id' => $chainId]);
    }

    /**
     * 删除对接规则
     * @access public
     * @param string $chainId 上下游id
     * @param int $ruleId 上下游规则id
     * @return array
     */
    public function ruleDeleteRule($chainId, $ruleId)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/rule/delete_rule?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'rule_id' => $ruleId,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取对接规则详情
     * @access public
     * @param string $chainId 上下游id
     * @param int $ruleId 上下游规则id
     * @return array
     */
    public function ruleGetRuleInfo($chainId, $ruleId)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/rule/get_rule_info?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'rule_id' => $ruleId,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 新增对接规则
     * @access public
     * @param string $chainId 上下游id
     * @param array $ruleInfo 上下游关系规则的详情
     * @return array
     */
    public function ruleAddRule($chainId, array $ruleInfo)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/rule/add_rule?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'rule_info' => $ruleInfo
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 更新对接规则
     * @access public
     * @param string $chainId 上下游id
     * @param array $ruleInfo 上下游关系规则的详情
     * @return array
     */
    public function ruleModifyRule($chainId, array $ruleInfo)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/corpgroup/rule/modify_rule?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chain_id' => $chainId,
            'rule_info' => $ruleInfo
        ];
        return $this->handler->callPostApi($url, $data);
    }
}