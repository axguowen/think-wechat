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
 * 会话内容存档服务基础类
 */
abstract class Chatdata extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
    /**
     * 获取会话记录
     * @access public
     * @param int $limit 拉取数量
     * @param string $token 回调事件返回的token字段
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function syncMsg($limit = 50, $token = '', $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/sync_msg?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($token)) {
            $data['token'] = $token;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取内部群信息
     * @access public
     * @param string $chatid 待查询的群id
     * @return array
     */
    public function groupchatGet($chatid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/groupchat/get?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['chatid' => $chatid]);
    }

    /**
     * 获取单聊会话同意情况
     * @access public
     * @param array $chatList 待查询的会话信息
     * @return array
     */
    public function getAgreeStatusSingle(array $chatList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/getagreestatus/single?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['item' => $chatList]);
    }

    /**
     * 获取群聊会话同意情况
     * @access public
     * @param string $chatid 待查询的群id
     * @return array
     */
    public function getAgreeStatusRoom($chatid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/getagreestatus/room?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['chatid' => $chatid]);
    }

    // +=======================
    // | 会话搜索
    // +=======================
    /**
     * 会话名称搜索
     * @access public
     * @param string $queryWord 搜索的文本
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function searchChat($queryWord = '', $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/search_chat?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'query_word' => $queryWord,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 会话消息搜索
     * @access public
     * @param string $queryWord 搜索的文本
     * @param array $chatInfo 指定要搜索的客户会话范围
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function searchMsg($queryWord, array $chatInfo = [], $startTime = 0, $endTime = 0, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/search_msg?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'query_word' => $queryWord,
            'limit' => $limit,
        ];
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
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 关键词规则管理
    // +=======================
    /**
     * 新增关键词规则
     * @access public
     * @param string $name 关键词规则名称
     * @param string[] $wordList 关键词列表
     * @param int[] $semanticsList 关键行为列表
     * @param array $applicableRange 规则适用说明
     * @return array
     */
    public function keywordCreateRule($name, array $wordList = [], array $semanticsList = [], array $applicableRange = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/create_rule?access_token=ACCESS_TOKEN';
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
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取关键词规则列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function keywordGetRuleList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/get_rule_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取关键词规则详情
     * @access public
     * @param string $ruleId 规则id
     * @return array
     */
    public function keywordGetRuleDetail($ruleId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/get_rule_detail?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['rule_id' => $ruleId]);
    }

    /**
     * 修改关键词规则
     * @access public
     * @param string $ruleId 规则id
     * @param string $name 关键词规则名称
     * @param string[] $wordList 关键词列表
     * @param int[] $semanticsList 关键行为列表
     * @param array $applicableRange 规则适用说明
     * @return array
     */
    public function keywordUpdateRule($ruleId, $name = '', array $wordList = [], array $semanticsList = [], array $applicableRange = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/update_rule?access_token=ACCESS_TOKEN';
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
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取关键词规则详情
     * @access public
     * @param string $ruleId 规则id
     * @return array
     */
    public function keywordDeleteRule($ruleId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/delete_rule?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['rule_id' => $ruleId]);
    }

    /**
     * 会话消息搜索
     * @access public
     * @param string $token 回调事件返回的token字段
     * @param int $needDetail 是否需要消息详情
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function keywordGetHitMsgList($token = '', $needDetail = 0, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/keyword/get_hit_msg_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'need_detail' => $needDetail,
            'limit' => $limit,
        ];
        if (!empty($token)) {
            $data['token'] = $token;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 会话内容分析与导出
    // +=======================
    /**
     * 创建分析任务
     * @access public
     * @param array $msgList 消息列表
     * @param int $analyzeTask 指定要分析的任务
                                1: （单条分析）情感分析
                                2: （单条分析）反垃圾分析
                                3: （批量分析）摘要提取。展示结果为文本
     * @param string $jobid 任务id
     * @return array
     */
    public function analyzeTaskAdd(array $msgList, $analyzeTask = 1, $jobid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/analyze_task_add?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'msg_list' => $msgList,
            'analyze_task' => $analyzeTask,
        ];
        if (!empty($jobid)) {
            $data['jobid'] = $jobid;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 提交分析任务
     * @access public
     * @param string $jobid 任务id
     * @return array
     */
    public function analyzeTaskSubmit($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/analyze_task_submit?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['jobid' => $jobid]);
    }

    /**
     * 获取分析任务结果
     * @access public
     * @param string $jobid 任务id
     * @return array
     */
    public function analyzeTaskResult($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/analyze_task_result?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['jobid' => $jobid]);
    }

    /**
     * 创建会话内容导出任务
     * @access public
     * @param string $code 从会话展示组件获取的code
     * @param string $mediaId 导出内容的模板文件media_id
     * @return array
     */
    public function exportCreateJob($code, $mediaId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/export/create_job?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['code' => $code, 'media_id' => $mediaId]);
    }

    /**
     * 获取会话内容导出任务结果
     * @access public
     * @param string $jobid 任务id
     * @return array
     */
    public function exportGetJobStatus($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/chatdata/export/get_job_status?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['jobid' => $jobid]);
    }
}