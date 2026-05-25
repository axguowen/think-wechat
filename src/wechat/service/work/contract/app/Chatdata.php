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
 * 数据与智能专区服务基础类
 */
abstract class Chatdata extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
    /**
     * 设置公钥
     * @access public
     * @param string $publicKey 公钥
     * @param int $publicKeyVer 公钥版本
     * @return array
     */
    public function setPublicKey($publicKey, $publicKeyVer)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/set_public_key?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'public_key' => $publicKey,
            'public_key_ver' => $publicKeyVer,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取授权存档的成员列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getAuthUserList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/get_auth_user_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        if($limit > 0){
            $data['limit'] = $limit;
        }
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 设置专区接收回调事件
     * @access public
     * @param string $programId 程序id
     * @return array
     */
    public function setReceiveCallback($programId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/set_receive_callback?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['program_id' => $programId]);
    }

    /**
     * 设置成员会话组件敏感信息隐藏配置
     * @access public
     * @param string $userid 成员的userid
     * @param array $config 敏感信息隐藏配置: 
     *                      hide_mobile 是否隐藏手机号码
     *                      hide_idcard 是否隐藏身份证号
     *                      hide_bankno 是否隐藏银行卡号
     * @return array
     */
    public function setHideSensitiveinfoConfig($userid, array $config = [])
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/set_hide_sensitiveinfo_config?access_token=ACCESS_TOKEN';
        $data = [
            'userid' => $userid,
            'config' => $config,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取成员会话组件敏感信息隐藏配置
     * @access public
     * @param string $userid 成员的userid
     * @return array
     */
    public function getHideSensitiveinfoConfig($userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/get_hide_sensitiveinfo_config?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['userid' => $userid]);
    }

    /**
     * 设置日志打印级别
     * @access public
     * @param string $programId 程序id
     * @param int $logLevel 日志级别取值范围: 1-ERR; 2-INFO; 3-DBG
     * @return array
     */
    public function setLogLevel($programId, $logLevel)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/set_log_level?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['program_id' => $programId, 'log_level' => $logLevel]);
    }

    /**
     * 获取当前日志打印级别
     * @access public
     * @param string $programId 程序id
     * @return array
     */
    public function getLogLevel($programId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/get_log_level?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['program_id' => $programId]);
    }

    /**
     * 上传临时文件到专区
     * @access public
     * @param string $fileName 文件名
     * @param string $fileContent 文件内容
     * @param string $mimeType 文件类型
     * @param string $type 媒体文件类型, image图片、voice语音、video视频, file普通文件
     * @return array
     */
    public function upload($fileName, $fileContent, $mimeType = null, $type = 'file')
    {
        if (!in_array($type, ['image', 'voice', 'video', 'file'])) {
            throw new \Exception('Invalid Media Type.', '0');
        }
        // 请求地址
        $url = "https://qyapi.weixin.qq.com/cgi-bin/chatdata/upload_media?access_token=ACCESS_TOKEN&type={$type}";
        return $this->handler->callMultipartPostApi($url, [], 'media', $fileName, $fileContent, $mimeType);
    }

    /**
     * 获取数据与智能专区授权信息
     * @access public
     * @return array
     */
    public function getCorpAuthInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/get_corp_auth_info?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url);
    }

    /**
     * 应用同步调用专区程序
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $abilityId 程序关联的能力id
     * @param array $requestData 请求的输入JSON
     * @param string $notifyId 通知id
     * @return array
     */
    public function syncCallProgram($programId, $abilityId, array $requestData = [], $notifyId = '')
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/sync_call_program?access_token=ACCESS_TOKEN';
        // 转换为JSON字符串
        $requestData = json_encode($requestData, JSON_UNESCAPED_UNICODE);
        // 请求参数
        $data = [
            'program_id' => $programId,
            'ability_id' => $abilityId,
            'request_data' => $requestData,
        ];
        // 如果通知ID不为空
        if (!empty($notifyId)) {
            $data['notify_id'] = $notifyId;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 应用异步调用专区程序
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $abilityId 程序关联的能力id
     * @param array $requestData 请求的输入JSON
     * @return array
     */
    public function asyncCallProgram($programId, $abilityId, array $requestData = [])
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/async_call_program?access_token=ACCESS_TOKEN';
        // 转换为JSON字符串
        $requestData = json_encode($requestData, JSON_UNESCAPED_UNICODE);
        // 请求参数
        $data = [
            'program_id' => $programId,
            'ability_id' => $abilityId,
            'request_data' => $requestData,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取异步调用专区程序结果
     * @access public
     * @param string $jobid 任务id
     * @return array
     */
    public function asyncProgramResult($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/async_program_result?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['jobid' => $jobid]);
    }

    /**
     * 应用开启调试模式
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $debugToken 程序的调试凭证
     * @return array
     */
    public function openDebugMode($programId, $debugToken)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/open_debug_mode?access_token=ACCESS_TOKEN';
        $data = [
            'program_id' => $programId,
            'debug_token' => $debugToken,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 应用关闭调试模式
     * @access public
     * @param string $programId 应用关联的程序id
     * @return array
     */
    public function closeDebugMode($programId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/close_debug_mode?access_token=ACCESS_TOKEN';
        $data = [
            'program_id' => $programId,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 应用获取调试模式状态
     * @access public
     * @param string $programId 应用关联的程序id
     * @return array
     */
    public function checkDebugMode($programId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/check_debug_mode?access_token=ACCESS_TOKEN';
        $data = [
            'program_id' => $programId,
        ];
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 应用调用程序方法
    // +=======================
    /**
     * 获取回调数据
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $notifyId 通知id
     * @return array
     */
    public function getCallbackData($programId, $notifyId)
    {
        return $this->syncCallProgram($programId, 'get_callback_data', [], $notifyId);
    }

    /**
     * 获取会话记录
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $token 回调事件返回的 token 字段
     * @param int $mode 消息拉取模式。0：默认模式；1-预分页模式；2-自适应模式
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @param int $beginTime 起始时间
     * @return array
     */
    public function invokeSyncMsg($programId, $token = '', $mode = 0, $cursor = '', $limit = 50, $beginTime = 0)
    {
        // 请求参数
        $data = [];
        // 如果token不为空
        if (!empty($token)) {
            $data['token'] = $token;
        }
        // 如果指定了消息拉取模式
        if ($mode > 0) {
            $data['mode'] = $mode;
        }
        // 如果cursor不为空
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 如果limit不为空
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        // 如果beginTime不为空
        if (!empty($beginTime)) {
            $data['begin_time'] = $beginTime;
        }
        return $this->syncCallProgram($programId, 'invoke_sync_msg', $data);
    }

    /**
     * page_id获取消息列表
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $pageId 分页id
     * @return array
     */
    public function invokeGetMsgListByPageId($programId, $pageId)
    {
        return $this->syncCallProgram($programId, 'invoke_get_msg_list_by_page_id', ['page_id' => $pageId]);
    }

    /**
     * 获取单聊会话同意情况
     * @access public
     * @param string $programId 应用关联的程序id
     * @param array $items 待查询的会话信息列表，列表项包含以下字段:
                    userid: 内部成员的userid
                    external_userid: 外部成员的external_userid
     * @return array
     */
    public function invokeGetAgreeStatusSingle($programId, array $items)
    {
        return $this->syncCallProgram($programId, 'invoke_get_agree_status_single', ['item' => $items]);
    }

    /**
     * 获取群聊会话同意情况
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $chatid 待查询的群id
     * @return array
     */
    public function invokeGetAgreeStatusRoom($programId, $chatid)
    {
        return $this->syncCallProgram($programId, 'invoke_get_agree_status_room', ['chatid' => $chatid]);
    }

    /**
     * 获取内部群信息
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $chatid 待查询的群id
     * @return array
     */
    public function invokeGetGroupChat($programId, $chatid)
    {
        return $this->syncCallProgram($programId, 'invoke_get_group_chat', ['chatid' => $chatid]);
    }

    /**
     * 会话名称搜索
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $queryWord 搜索的文本
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @return array
     */
    public function invokeSearchChat($programId, $queryWord = '', $cursor = '', $limit = 50)
    {
        // 请求参数
        $data = [
            'query_word' => $queryWord,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        return $this->syncCallProgram($programId, 'invoke_search_chat', $data);
    }

    /**
     * 会话消息搜索
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $queryWord 搜索的文本
     * @param array $chatInfo 指定要搜索的客户会话范围
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @return array
     */
    public function invokeSearchMsg($programId, $queryWord, array $chatInfo = [], $startTime = 0, $endTime = 0, $cursor = '', $limit = 50)
    {
        // 请求参数
        $data = [
            'query_word' => $queryWord,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($chatInfo)) {
            $data['chat_info'] = $chatInfo;
        }
        if (!empty($startTime)) {
            $data['start_time'] = $startTime;
        }
        if (!empty($endTime)) {
            $data['end_time'] = $endTime;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        return $this->syncCallProgram($programId, 'invoke_search_msg', $data);
    }

    /**
     * 员工或客户名称搜索
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $queryWord 搜索的文本
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @param string $queryUserType 搜索的用户类型: 0. 员工和客户的名称; 1. 员工名称; 2. 客户名称
     * @return array
     */
    public function invokeSearchContactOrCustomer($programId, $queryWord = '', $cursor = '', $limit = 50, $queryUserType = 0)
    {
        // 请求参数
        $data = [
            'query_word' => $queryWord,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        if (!empty($queryUserType)) {
            $data['query_user_type'] = $queryUserType;
        }
        return $this->syncCallProgram($programId, 'invoke_search_contact_or_customer', $data);
    }

    // +=======================
    // | 关键词规则管理
    // +=======================
    /**
     * 新增关键词规则
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $name 关键词规则名称
     * @param string[] $wordList 关键词列表
     * @param int[] $semanticsList 关键行为列表
     * @param array $applicableRange 规则适用说明
     * @return array
     */
    public function invokeCreateRule($programId, $name, array $wordList = [], array $semanticsList = [], array $applicableRange = [])
    {
        // 请求参数
        $data = [
            'name' => $name,
        ];
        if (!empty($wordList)) {
            $data['keyword'] = [
                'word_list' => $wordList,
            ];
        }
        if (!empty($semanticsList)) {
            $data['semantics'] = [
                'semantics_list' => $semanticsList,
            ];
        }
        if (!empty($applicableRange)) {
            $data['applicable_range'] = $applicableRange;
        }
        return $this->syncCallProgram($programId, 'invoke_create_rule', $data);
    }

    /**
     * 获取关键词规则列表
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @return array
     */
    public function invokeGetRuleList($programId, $cursor = '', $limit = 50)
    {
        // 请求参数
        $data = [];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        return $this->syncCallProgram($programId, 'invoke_get_rule_list', $data);
    }

    /**
     * 获取关键词规则详情
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $ruleId 规则id
     * @return array
     */
    public function invokeGetRuleDetail($programId, $ruleId)
    {
        return $this->syncCallProgram($programId, 'invoke_get_rule_detail', ['rule_id' => $ruleId]);
    }

    /**
     * 修改关键词规则
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $ruleId 规则id
     * @param string $name 关键词规则名称
     * @param string[] $wordList 关键词列表
     * @param int[] $semanticsList 关键行为列表
     * @param array $applicableRange 规则适用说明
     * @return array
     */
    public function invokeUpdateRule($programId, $ruleId, $name = '', array $wordList = [], array $semanticsList = [], array $applicableRange = [])
    {
        // 请求参数
        $data = [
            'rule_id' => $ruleId,
        ];
        if (!empty($name)) {
            $data['name'] = $name;
        }
        if (!empty($wordList)) {
            $data['keyword'] = [
                'word_list' => $wordList,
            ];
        }
        if (!empty($semanticsList)) {
            $data['semantics'] = [
                'semantics_list' => $semanticsList,
            ];
        }
        if (!empty($applicableRange)) {
            $data['applicable_range'] = $applicableRange;
        }
        return $this->syncCallProgram($programId, 'invoke_update_rule', $data);
    }

    /**
     * 删除关键词规则
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $ruleId 规则id
     * @return array
     */
    public function invokeDeleteRule($programId, $ruleId)
    {
        return $this->syncCallProgram($programId, 'invoke_delete_rule', ['rule_id' => $ruleId]);
    }

    /**
     * 获取命中关键词规则的会话记录
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $token 回调事件返回的token字段
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $limit 拉取数量
     * @param int $needDetail 是否需要消息详情
     * @return array
     */
    public function invokeGetHitMsgList($programId, $token = '', $cursor = '', $limit = 50, $needDetail = 0)
    {
        // 请求参数
        $data = [];
        if (!empty($token)) {
            $data['token'] = $token;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if (!empty($limit)) {
            $data['limit'] = $limit;
        }
        if (!empty($needDetail)) {
            $data['need_detail'] = $needDetail;
        }
        return $this->syncCallProgram($programId, 'invoke_get_hit_msg_list', $data);
    }

    // +=======================
    // | 管理企业知识集
    // +=======================
    /**
     * 获取企业授权给应用的知识集列表
     * @access public
     * @param string $programId 应用关联的程序id
     * @return array
     */
    public function invokeKnowledgeBaseList($programId)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_list');
    }

    /**
     * 创建知识集
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbName 知识集名称
     * @param array $docList 知识集内容列表
     * @return array
     */
    public function invokeKnowledgeBaseCreate($programId, $kbName, array $docList)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_create', [
            'kb_name' => $kbName,
            'doc_list' => $docList,
        ]);
    }

    /**
     * 获取知识集详情
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbId 知识集id
     * @return array
     */
    public function invokeKnowledgeBaseDetail($programId, $kbId)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_detail', [
            'kb_id' => $kbId,
        ]);
    }

    /**
     * 添加知识集内容
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbId 知识集id
     * @param array $docList 知识集内容列表
     * @return array
     */
    public function invokeKnowledgeBaseAddDoc($programId, $kbId, array $docList)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_add_doc', [
            'kb_id' => $kbId,
            'doc_list' => $docList,
        ]);
    }

    /**
     * 删除知识集内容
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbId 知识集id
     * @param array $docidList 知识集内容列表
     * @return array
     */
    public function invokeKnowledgeBaseRemoveDoc($programId, $kbId, array $docList)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_remove_doc', [
            'kb_id' => $kbId,
            'docid_list' => $docidList,
        ]);
    }

    /**
     * 修改知识集名称
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbId 知识集id
     * @param string $kbName 知识集名称
     * @return array
     */
    public function invokeKnowledgeBaseModifyName($programId, $kbId, $kbName)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_modify_name', [
            'kb_id' => $kbId,
            'kb_name' => $kbName,
        ]);
    }

    /**
     * 删除知识集
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $kbId 知识集id
     * @return array
     */
    public function invokeKnowledgeBaseDelete($programId, $kbId)
    {
        return $this->syncCallProgram($programId, 'invoke_knowledge_base_delete', [
            'kb_id' => $kbId,
        ]);
    }

    // +=======================
    // | 会话内容导出
    // +=======================
    /**
     * 创建会话内容导出任务
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $code 从会话展示组件获取的code
     * @param string $mediaId 导出内容的模板文件media_id
     * @return array
     */
    public function invokeCreateChatdataExportJob($programId, $code, $mediaId)
    {
        return $this->syncCallProgram($programId, 'invoke_create_chatdata_export_job', [
            'code' => $code,
            'media_id' => $mediaId,
        ]);
    }

    /**
     * 获取会话内容导出任务结果
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $jobid 任务id
     * @return array
     */
    public function invokeGetChatdataExportJobStatus($programId, $jobid)
    {
        return $this->syncCallProgram($programId, 'invoke_get_chatdata_export_job_status', [
            'jobid' => $jobid,
        ]);
    }

    /**
     * 专区通知应用
     * @access public
     * @param string $programId 应用关联的程序id
     * @param string $notifyId 通知ID
     * @param string $notifyScene 通知场景
     * @return array
     */
    public function invokeSpecNotifyApp($programId, $notifyId = '', $notifyScene = '')
    {
        // 请求参数
        $data = [];
        if(!empty($notifyId)){
            $data['notify_id'] = $notifyId;
        }
        if(!empty($notifyScene)){
            $data['notify_scene'] = $notifyScene;
        }
        return $this->syncCallProgram($programId, 'invoke_spec_notify_app', $data);
    }
}