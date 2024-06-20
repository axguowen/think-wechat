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
 * 微信客服服务基础类
 */
abstract class Kefu extends Service
{
    // +=======================
    // | 客服账号管理
    // +=======================
    /**
     * 添加客服账号
     * @access public
     * @param string $name 客服名称
     * @param string $mediaId 客服头像临时素材id
     * @return array
     */
    public function accountAdd($name, $mediaId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['name' => $name, 'media_id' => $mediaId]);
    }

    /**
     * 删除客服账号
     * @access public
     * @param string $openKfid 客服头像临时素材id
     * @return array
     */
    public function accountDel($openKfid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/del?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['open_kfid' => $openKfid]);
    }

    /**
     * 修改客服账号
     * @access public
     * @param string $openKfid 要修改的客服账号ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function accountUpdate($openKfid, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/update?access_token=ACCESS_TOKEN';
        $data['open_kfid'] = $openKfid;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取客服账号列表
     * @access public
     * @param int $limit 返回的最大记录数
     * @param string $offset 偏移量
     * @return array
     */
    public function accountList($limit = 50, $offset = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了偏移量
        if(!empty($offset)){
            $data['offset'] = $offset;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取客服账号链接
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string $scene 场景值
     * @return array
     */
    public function addContactWay($openKfid, $scene = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/add_contact_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
        ];
        // 指定了场景值
        if(!empty($scene)){
            $data['scene'] = $scene;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 接待人员管理
    // +=======================
    /**
     * 添加接待人员
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string[] $useridList 接待人员userid列表
     * @param int[] $departmentIdList 接待人员部门id列表
     * @return array
     */
    public function servicerAdd($openKfid, array $useridList, array $departmentIdList = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/add?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
        ];
        if(!empty($useridList)){
            $data['userid_list'] = $useridList;
        }
        if(!empty($departmentIdList)){
            $data['department_id_list'] = $departmentIdList;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除接待人员
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string[] $useridList 接待人员userid列表
     * @param int[] $departmentIdList 接待人员部门id列表
     * @return array
     */
    public function servicerDel($openKfid, array $useridList, array $departmentIdList = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/del?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
        ];
        if(!empty($useridList)){
            $data['userid_list'] = $useridList;
        }
        if(!empty($departmentIdList)){
            $data['department_id_list'] = $departmentIdList;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取接待人员列表
     * @access public
     * @param string $openKfid 客服头像临时素材id
     * @return array
     */
    public function servicerList($openKfid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/list?access_token=ACCESS_TOKEN&open_kfid={$openKfid}";
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 会话分配与消息收发
    // +=======================
    /**
     * 获取会话状态
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string $externalUserid 微信客户的external_userid
     * @return array
     */
    public function serviceStateGet($openKfid, $externalUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/service_state/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'open_kfid' => $openKfid,
            'external_userid' => $externalUserid,
        ]);
    }

    /**
     * 变更会话状态
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string $externalUserid 微信客户的external_userid
     * @param string $serviceState 变更的目标状态, 0未处理, 1由智能助手接待, 2待接入池排队中, 3由人工接待, 4已结束/未开始
     * @param string $servicerUserid 接待人员的userid
     * @return array
     */
    public function serviceStateTrans($openKfid, $externalUserid, $serviceState, $servicerUserid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/service_state/trans?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'external_userid' => $externalUserid,
            'service_state' => $serviceState,
        ];
        if(!empty($servicerUserid)){
            $data['servicer_userid'] = $servicerUserid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 读取消息
     * @access public
     * @param string $openKfid 指定拉取某个客服账号的消息
     * @param string $token 回调事件返回的token字段
     * @param int $limit 返回的最大记录数
     * @param string $cursor 用于分页查询的游标
     * @param int $voiceFormat 语音消息类型
     * @return array
     */
    public function syncMsg($openKfid, $token, $limit = 50, $cursor = '', $voiceFormat = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/sync_msg?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'limit' => $limit,
            'voice_format' => $voiceFormat,
        ];
        if(!empty($token)){
            $data['token'] = $token;
        }
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 发送消息
     * @access public
     * @param string $openKfid 指定发送消息的客服账号ID
     * @param string $touser 指定接收消息的用户或部门数据
     * @param array $msgdata 消息内容
     * @param string $msgtype 消息类型
     * @param string $msgid 指定消息ID
     * @return array
     */
    public function sendMsg($openKfid, $touser, array $msgdata, $msgtype = 'text', $msgid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'touser' => $touser,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ];
        if(!empty($msgid)){
            $data['msgid'] = $msgid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 发送欢迎语等事件响应消息
     * @access public
     * @param string $code 事件响应消息对应的code
     * @param array $msgdata 消息内容
     * @param string $msgtype 消息类型
     * @param string $msgid 消息ID
     * @return array
     */
    public function sendMsgOnEvent($code, array $msgdata, $msgtype = 'text', $msgid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg_on_event?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'code' => $code,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ];
        if(!empty($msgid)){
            $data['msgid'] = $msgid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 「升级服务」配置
    // +=======================
    /**
     * 获取配置的专员与客户群
     * @access public
     * @return array
     */
    public function customerGetUpgradeServiceConfig()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/get_upgrade_service_config?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url,);
    }

    /**
     * 为客户升级为专员或客户群服务
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string $externalUserid 微信客户的external_userid
     * @param array $options 要升级服务的数据
     * @param int $type 升级到专员服务还是客户群服务, 1专员服务, 2客户群服务
     * @return array
     */
    public function customerUpgradeService($openKfid, $externalUserid, array $options, $type = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/upgrade_service?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'external_userid' => $externalUserid,
            'type' => $type,
        ];
        if($type == 1){
            $data['member'] = $options;
        }else{
            $data['groupchat'] = $options;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为客户取消推荐
     * @access public
     * @param string $openKfid 客服账号ID
     * @param string $externalUserid 微信客户的external_userid
     * @return array
     */
    public function customerCancelUpgradeService($openKfid, $externalUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/cancel_upgrade_service?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'open_kfid' => $openKfid,
            'external_userid' => $externalUserid,
        ]);
    }

    // +=======================
    // | 其他基础信息获取
    // +=======================
    /**
     * 为客户取消推荐
     * @access public
     * @param string[] $externalUseridList 微信客户的external_userid列表
     * @param string $needEnterSessionContext 是否需要返回客户48小时内最后一次进入会话的上下文信息
     * @return array
     */
    public function customerBatchget($externalUseridList, $needEnterSessionContext = 0)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/batchget?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'external_userid_list' => $externalUseridList,
            'need_enter_session_context' => $needEnterSessionContext,
        ]);
    }

    // +=======================
    // | 统计管理
    // +=======================
    /**
     * 获取「客户数据统计」企业汇总数据
     * @access public
     * @param string $openKfid 客服账号ID
     * @param int $startTime 起始日期的时间戳
     * @param int $endTime 结束日期的时间戳
     * @return array
     */
    public function getCorpStatistic($openKfid, $startTime, $endTime)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/get_corp_statistic?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取「客户数据统计」接待人员明细数据
     * @access public
     * @param string $openKfid 客服账号ID
     * @param int $startTime 起始日期的时间戳
     * @param int $endTime 结束日期的时间戳
     * @param string $servicerUserid 接待人员的userid
     * @return array
     */
    public function getServicerStatistic($openKfid, $startTime, $endTime, $servicerUserid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/get_servicer_statistic?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'open_kfid' => $openKfid,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        if (!empty($servicerUserid)) {
            $data['servicer_userid'] = $servicerUserid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 机器人管理
    // +=======================
    /**
     * 添加知识库分组
     * @access public
     * @param string $name 分组名
     * @return array
     */
    public function knowledgeAddGroup($name)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/add_group?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['name' => $name]);
    }

    /**
     * 删除知识库分组
     * @access public
     * @param string $groupId 分组ID
     * @return array
     */
    public function knowledgeDelGroup($groupId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/del_group?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['group_id' => $groupId]);
    }

    /**
     * 修改知识库分组
     * @access public
     * @param string $groupId 分组ID
     * @param string $name 分组名
     * @return array
     */
    public function knowledgeModGroup($groupId, $name)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/mod_group?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['group_id' => $groupId, 'name' => $name]);
    }

    /**
     * 获取知识库分组列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param string $groupId 分组ID
     * @return array
     */
    public function knowledgeListGroup($limit = 50, $cursor = '', $groupId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/list_group?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($groupId)) {
            $data['group_id'] = $groupId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加知识库问答
     * @access public
     * @param string $groupId 分组ID
     * @param array $question 主问题
     * @param array $answers 回答列表
     * @param array $similarQuestions 相似问题
     * @return array
     */
    public function knowledgeAddIntent($groupId, array $question, array $answers, array $similarQuestions = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/add_intent?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'group_id' => $groupId,
            'question' => $question,
            'answers' => $answers,
        ];
        if (!empty($cursor)) {
            $data['similar_questions'] = $similarQuestions;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除知识库问答
     * @access public
     * @param string $intentId 问答ID
     * @return array
     */
    public function knowledgeDelIntent($intentId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/del_intent?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['intent_id' => $intentId]);
    }

    /**
     * 修改知识库问答
     * @access public
     * @param string $groupId 问答ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function knowledgeModIntent($intentId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/mod_intent?access_token=ACCESS_TOKEN';
        $data['intent_id'] = $intentId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取知识库问答列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param string $groupId 分组ID
     * @param string $intentId 问答ID
     * @return array
     */
    public function knowledgeListIntent($limit = 50, $cursor = '', $groupId = '', $intentId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/list_intent?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($groupId)) {
            $data['group_id'] = $groupId;
        }
        if (!empty($intentId)) {
            $data['intent_id'] = $intentId;
        }
        return $this->platform->callPostApi($url, $data);
    }
}