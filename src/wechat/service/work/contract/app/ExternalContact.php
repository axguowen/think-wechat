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
use think\wechat\utils\Tools;
use think\wechat\exception\InvalidResponseException;

/**
 * 客户联系服务基础类
 */
class ExternalContact extends Service
{
    // +=======================
    // | 企业服务人员管理
    // +=======================
    /**
     * 获取配置了客户联系功能的成员列表
     * @access public
     * @return array
     */
    public function getFollowUserList()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 客户管理
    // +=======================
    /**
     * 获取客户列表
     * @access public
     * @param string $userid 企业成员的userid
     * @return array
     */
    public function list($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取客户详情
     * @access public
     * @param string $externalUserid 客户的外部联系人userid
     * @param string $cursor 上次请求返回的next_cursor
     * @return array
     */
    public function get($externalUserid, $cursor = '')
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN&external_userid={$externalUserid}&cursor={$cursor}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 批量获取客户详情
     * @access public
     * @param array $useridList 企业成员的userid列表
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function batchGetByUser(array $useridList, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/batch/get_by_user?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
            'userid_list' => $useridList,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 修改客户备注信息
     * @access public
     * @param string $userid 企业成员的userid
     * @param string $externalUserid 外部联系人userid
     * @param array $remarkData 备注数据
     * @return array
     */
    public function remark($userid, $externalUserid, array $remarkData = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'userid' => $userid,
            'external_userid' => $externalUserid,
        ];
        return $this->platform->callPostApi($url, array_merge($remarkData, $data));
    }

    /**
     * 获取客户联系规则组列表
     * @access public
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function customerStrategyList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取客户联系规则组详情
     * @access public
     * @param int $strategyId 规则组id
     * @return array
     */
    public function customerStrategyGet($strategyId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['strategy_id' => $strategyId]);
    }

    /**
     * 获取客户联系规则组管理范围
     * @access public
     * @param int $strategyId 规则组id
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function customerStrategyGetRange($strategyId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/get_range?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'strategy_id' => $strategyId,
            'limit' => $limit,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建新的客户联系规则组
     * @access public
     * @param string $strategyName 规则组名称
     * @param string[] $adminList 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param int $parentId 父规则组id
     * @param array $privilege 权限列表
     * @param array $range 管理范围节点
     * @return array
     */
    public function customerStrategyCreate($strategyName, array $adminList, $parentId = 0, array $privilege = [], array $range = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/create?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'strategy_name' => $strategyName,
            'admin_list' => $adminList,
            'parent_id' => $parentId,
        ];
        // 指定了权限列表
        if(!empty($privilege)){
            $data['privilege'] = $privilege;
        }
        // 指定了管理范围节点
        if(!empty($range)){
            $data['range'] = $range;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑客户联系规则组及其管理范围
     * @access public
     * @param int $strategyId 规则组id
     * @param array $data 要更新的数据
     * @return array
     */
    public function customerStrategyEdit($strategyId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/edit?access_token=ACCESS_TOKEN';
        $data['strategy_id'] = $strategyId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除客户联系规则组
     * @access public
     * @param int $strategyId 规则组id
     * @return array
     */
    public function customerStrategyDel($strategyId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_strategy/del?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['strategy_id' => $strategyId]);
    }

    // +=======================
    // | 客户标签管理
    // +=======================
    /**
     * 获取企业标签库
     * @access public
     * @param string[] $tagId 要查询的标签id
     * @param string[] $groupId 要查询的标签组id
     * @return array
     */
    public function getCorpTagList(array $tagId = [], array $groupId = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        // 指定了标签id
        if(!empty($tagId)){
            $data['tag_id'] = $tagId;
        }
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加企业客户标签
     * @access public
     * @param array $tagList
     * @param string $groupId 标签组id
     * @param string $groupName 标签组名称
     * @param int $order 标签组次序值
     * @return array
     */
    public function addCorpTag(array $tagList, $groupId = '', $groupName = '', $order = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tag' => $tagList,
            'order' => $order,
        ];
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        // 指定了标签组名称
        if(!empty($groupName)){
            $data['group_name'] = $groupName;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑企业客户标签
     * @access public
     * @param string $id 标签或标签组的id
     * @param array $data 要更新的数据
     * @return array
     */
    public function editCorpTag($id, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN';
        $data['id'] = $id;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除企业客户标签
     * @access public
     * @param string[] $tagId 要查询的标签id
     * @param string[] $groupId 要查询的标签组id
     * @return array
     */
    public function delCorpTagList(array $tagId = [], array $groupId = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        // 指定了标签id
        if(!empty($tagId)){
            $data['tag_id'] = $tagId;
        }
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取指定规则组下的企业客户标签
     * @access public
     * @param int $strategyId 规则组id
     * @param string[] $tagId 要查询的标签id
     * @param string[] $groupId 要查询的标签组id
     * @return array
     */
    public function getStrategyTagList($strategyId = 0, array $tagId = [], array $groupId = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_strategy_tag_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        // 指定了规则组id
        if(!empty($strategyId)){
            $data['strategy_id'] = $strategyId;
        }
        // 指定了标签id
        if(!empty($tagId)){
            $data['tag_id'] = $tagId;
        }
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为指定规则组创建企业客户标签
     * @access public
     * @param int $strategyId 规则组id
     * @param array $tagList
     * @param string $groupId 标签组id
     * @param string $groupName 标签组名称
     * @param int $order 标签组次序值
     * @return array
     */
    public function addStrategyTag($strategyId, array $tagList, $groupId = '', $groupName = '', $order = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_strategy_tag?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'strategy_id' => $strategyId,
            'tag' => $tagList,
            'order' => $order,
        ];
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        // 指定了标签组名称
        if(!empty($groupName)){
            $data['group_name'] = $groupName;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑指定规则组下的企业客户标签
     * @access public
     * @param string $id 标签或标签组的id
     * @param array $data 要更新的数据
     * @return array
     */
    public function editStrategyTag($id, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/edit_strategy_tag?access_token=ACCESS_TOKEN';
        $data['id'] = $id;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除企业客户标签
     * @access public
     * @param string[] $tagId 要查询的标签id
     * @param string[] $groupId 要查询的标签组id
     * @return array
     */
    public function delStrategyTag(array $tagId = [], array $groupId = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_strategy_tag?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        // 指定了标签id
        if(!empty($tagId)){
            $data['tag_id'] = $tagId;
        }
        // 指定了标签组id
        if(!empty($groupId)){
            $data['group_id'] = $groupId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑客户企业标签
     * @access public
     * @param string $userid 添加该外部联系人的企业成员的userid
     * @param string $externalUserid 外部联系人userid
     * @param string[] $addTag 要标记的标签列表
     * @param string[] $removeTag 要移除的标签列表
     * @return array
     */
    public function markTag($userid, $externalUserid, array $addTag = [], array $removeTag = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'userid' => $userid,
            'external_userid' => $externalUserid,
        ];

        // 指定了要标记的标签
        if(!empty($addTag)){
            $data['add_tag'] = $addTag;
        }
        // 指定了要移除的标签
        if(!empty($removeTag)){
            $data['remove_tag'] = $removeTag;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 在职继承
    // +=======================
    /**
     * 分配在职成员的客户
     * @access public
     * @param string $handoverUserid 原跟进成员的userid
     * @param string $takeoverUserid 接替成员的userid
     * @param string[] $externalUserid 客户的external_userid列表
     * @param string $transferSuccessMsg 转移成功后发给客户的消息
     * @return array
     */
    public function transferCustomer($handoverUserid, $takeoverUserid, array $externalUserid, $transferSuccessMsg = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer_customer?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'handover_userid' => $handoverUserid,
            'takeover_userid' => $takeoverUserid,
            'external_userid' => $externalUserid,
        ];

        // 指定了消息
        if(!empty($transferSuccessMsg)){
            $data['transfer_success_msg'] = $transferSuccessMsg;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询客户接替状态
     * @access public
     * @param string $handoverUserid 原跟进成员的userid
     * @param string $takeoverUserid 接替成员的userid
     * @param string $cursor 分页查询的cursor
     * @return array
     */
    public function transferResult($handoverUserid, $takeoverUserid, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer_result?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'handover_userid' => $handoverUserid,
            'takeover_userid' => $takeoverUserid,
        ];
        // 指定了游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 分配在职成员的客户群
     * @access public
     * @param string[] $chatIdList 需要转群主的客户群ID列表
     * @param string $newOwner 新群主ID
     * @return array
     */
    public function onjobTransfer(array $chatIdList, $newOwner)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/onjob_transfer?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['chat_id_list' => $chatIdList, 'new_owner' => $newOwner]);
    }

    // +=======================
    // | 离职继承
    // +=======================
    /**
     * 获取待分配的离职成员列表
     * @access public
     * @param int $pageSize 返回的最大记录数
     * @param string $cursor 分页查询游标
     * @return array
     */
    public function getUnassignedList($pageSize = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_unassigned_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'page_size' => $pageSize,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 分配离职成员的客户
     * @access public
     * @param string $handoverUserid 原跟进成员的userid
     * @param string $takeoverUserid 接替成员的userid
     * @param string[] $externalUserid 客户的external_userid列表
     * @return array
     */
    public function resignedTransferCustomer($handoverUserid, $takeoverUserid, array $externalUserid)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/resigned/transfer_customer?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'handover_userid' => $handoverUserid,
            'takeover_userid' => $takeoverUserid,
            'external_userid' => $externalUserid,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询离职成员客户接替状态
     * @access public
     * @param string $handoverUserid 原跟进成员的userid
     * @param string $takeoverUserid 接替成员的userid
     * @param string $cursor 分页查询的cursor
     * @return array
     */
    public function resignedTransferResult($handoverUserid, $takeoverUserid, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/resigned/transfer_result?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'handover_userid' => $handoverUserid,
            'takeover_userid' => $takeoverUserid,
        ];
        // 指定了游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 分配离职成员的客户群
     * @access public
     * @param string[] $chatIdList 需要转群主的客户群ID列表
     * @param string $newOwner 新群主ID
     * @return array
     */
    public function groupchatTransfer(array $chatIdList, $newOwner)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['chat_id_list' => $chatIdList, 'new_owner' => $newOwner]);
    }

    // +=======================
    // | 客户群管理
    // +=======================
    /**
     * 获取客户群列表
     * @access public
     * @param int $statusFilter 客户群跟进状态过滤
     * @param array $ownerFilter 群主过滤
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function groupchatList($statusFilter = 0, array $ownerFilter = [], $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'ownerFilter' => $statusFilter,
            'limit' => $limit,
        ];
        // 指定了群主过滤
        if(!empty($ownerFilter)){
            $data['owner_filter'] = $ownerFilter;
        }
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取客户群详情
     * @access public
     * @param string $chatId 客户群ID
     * @param int $needName 是否需要返回群成员的名字
     * @return array
     */
    public function groupchatGet($chatId, $needName = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chat_id' => $chatId,
            'need_name' => $needName,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 客户群opengid转换
     * @access public
     * @param string $opengid 小程序在微信获取到的群ID
     * @return array
     */
    public function opengidToChatid($opengid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/opengid_to_chatid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['opengid' => $opengid]);
    }

    // +=======================
    // | 联系我与客户入群方式
    // +=======================
    /**
     * 配置客户联系「联系我」方式
     * @access public
     * @param int $type 联系方式类型, 1单人, 2多人
     * @param int $scene 场景, 1在小程序中联系, 2通过二维码联系
     * @param array $options 其它参数
     * @return array
     */
    public function addContactWay($type, $scene, array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'type' => $type,
            'scene' => $scene,
        ];
        return $this->platform->callPostApi($url, array_merge($data, $options));
    }

    /**
     * 获取企业已配置的「联系我」方式
     * @access public
     * @param string $configId 联系方式的配置id
     * @return array
     */
    public function getContactWay($configId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_contact_way?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['config_id' => $configId]);
    }

    /**
     * 获取企业已配置的「联系我」列表
     * @access public
     * @param int $startTime 起始时间,
     * @param int $endTime 结束时间
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function listContactWay($startTime = 0, $endTime = 0, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list_contact_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了时间
        if($startTime > 0 || $endTime > 0){
            $data['start_time'] = $startTime;
            $data['end_time'] = $endTime;
        }
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新企业已配置的「联系我」方式
     * @access public
     * @param string $configId 联系方式的配置id
     * @param array $options 要更新的数据
     * @return array
     */
    public function updateContactWay($configId, array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'config_id' => $configId,
        ];
        return $this->platform->callPostApi($url, array_merge($data, $options));
    }

    /**
     * 删除企业已配置的「联系我」方式
     * @access public
     * @param string $configId 联系方式的配置id
     * @return array
     */
    public function delContactWay($configId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['config_id' => $configId,]);
    }

    /**
     * 结束临时会话
     * @access public
     * @param string $userid 企业成员的userid
     * @param string $externalUserid 客户的外部联系人userid
     * @return array
     */
    public function closeTempChat($userid, $externalUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/close_temp_chat?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid, 'external_userid' => $externalUserid]);
    }

    /**
     * 配置客户群进群方式
     * @access public
     * @param string[] $chatIdList 使用该配置的客户群ID列表
     * @param int $scene 场景, 1在小程序中联系, 2通过二维码联系
     * @param array $options 其它参数
     * @return array
     */
    public function groupchatAddJoinWay(array $chatIdList, $scene, array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/add_join_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'chat_id_list' => $chatIdList,
            'scene' => $scene,
        ];
        return $this->platform->callPostApi($url, array_merge($data, $options));
    }

    /**
     * 获取客户群进群方式配置
     * @access public
     * @param string $configId 联系方式的配置id
     * @return array
     */
    public function groupchatGetJoinWay($configId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get_join_way?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['config_id' => $configId]);
    }

    /**
     * 更新客户群进群方式配置
     * @access public
     * @param string $configId 联系方式的配置id
     * @param string[] $chatIdList 使用该配置的客户群ID列表
     * @param int $scene 场景, 1在小程序中联系, 2通过二维码联系
     * @param array $options 要更新的数据
     * @return array
     */
    public function groupchatUpdateJoinWay($configId, array $chatIdList, $scene, array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/update_join_way?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'config_id' => $configId,
            'chat_id_list' => $chatIdList,
            'scene' => $scene,
        ];
        return $this->platform->callPostApi($url, array_merge($data, $options));
    }

    /**
     * 删除客户群进群方式配置
     * @access public
     * @param string $configId 联系方式的配置id
     * @return array
     */
    public function groupchatDelJoinWay($configId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/del_join_way?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['config_id' => $configId,]);
    }

    // +=======================
    // | 客户朋友圈
    // +=======================
    /**
     * 创建发表客户朋友圈任务
     * @access public
     * @param array $data 要发表的内容
     * @return array
     */
    public function addMomentTask(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_moment_task?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取客户朋友圈任务创建结果
     * @access public
     * @param string $jobid 任务id
     * @return array
     */
    public function getMomentTaskResult($jobid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_task_result?access_token=ACCESS_TOKEN&jobid={$jobid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 停止发表企业朋友圈
     * @access public
     * @param string $momentId 朋友圈id
     * @return array
     */
    public function cancelMomentTask($momentId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/cancel_moment_task?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['moment_id' => $momentId]);
    }
    
    /**
     * 获取企业全部的发表列表
     * @access public
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @param string $creator 朋友圈创建人的userid
     * @param string $filterType 朋友圈类型, 0企业发表, 1个人发表, 2所有
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getMomentList($startTime, $endTime, $creator = '', $filterType = 2, $limit = 20, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'filter_type' => $filterType,
            'limit' => $limit,
        ];
        if (!empty($creator)) {
            $data['creator'] = $creator;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取客户朋友圈企业发表的列表
     * @access public
     * @param string $momentId 朋友圈id
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getMomentTask($momentId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_task?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'moment_id' => $momentId,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取客户朋友圈发表时选择的可见范围
     * @access public
     * @param string $momentId 朋友圈id
     * @param string $userid 企业发表成员userid
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getMomentCustomerList($momentId, $userid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_customer_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'moment_id' => $momentId,
            'userid' => $userid,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取客户朋友圈发表后的可见客户列表
     * @access public
     * @param string $momentId 朋友圈id
     * @param string $userid 企业发表成员userid
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getMomentSendResult($momentId, $userid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_send_result?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'moment_id' => $momentId,
            'userid' => $userid,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取客户朋友圈的互动数据
     * @access public
     * @param string $momentId 朋友圈id
     * @param string $userid 企业发表成员userid
     * @return array
     */
    public function getMomentComments($momentId, $userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_comments?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'moment_id' => $momentId,
            'userid' => $userid,
        ]);
    }
    
    /**
     * 获取客户朋友圈规则组列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function momentStrategyList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取规则组详情
     * @access public
     * @param string $strategyId 规则组id
     * @return array
     */
    public function momentStrategyGet($strategyId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['strategy_id' => $strategyId]);
    }
    
    /**
     * 获取客户朋友圈规则组列表
     * @access public
     * @param string $strategyId 规则组id
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function momentStrategyGetRange($strategyId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/get_range?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'strategy_id' => $strategyId,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 创建新的客户朋友圈规则组
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function momentStrategyCreate(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑客户朋友圈规则组及其管理范围
     * @access public
     * @param int $strategyId 规则组id
     * @param array $data 要更新的数据
     * @return array
     */
    public function momentStrategyEdit($strategyId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/edit?access_token=ACCESS_TOKEN';
        $data['strategy_id'] = $strategyId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑客户朋友圈规则组及其管理范围
     * @access public
     * @param int $strategyId 规则组id
     * @return array
     */
    public function momentStrategyDel($strategyId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/moment_strategy/del?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['strategy_id' => $strategyId]);
    }

    // +=======================
    // | 获客助手
    // +=======================
    /**
     * 获取获客链接列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function customerAcquisitionListLink($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/list_link?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取获客链接详情
     * @access public
     * @param string $linkId 获客链接id
     * @return array
     */
    public function customerAcquisitionGet($linkId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['link_id' => $linkId]);
    }
    
    /**
     * 创建获客链接
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function customerAcquisitionCreateLink(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/create_link?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑获客链接
     * @access public
     * @param string $linkId 获客链接id
     * @param array $data 要更新的数据
     * @return array
     */
    public function customerAcquisitionUpdateLink($linkId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/update_link?access_token=ACCESS_TOKEN';
        $data['link_id'] = $linkId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除获客链接
     * @access public
     * @param string $linkId 获客链接id
     * @return array
     */
    public function customerAcquisitionDeleteLink($linkId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/delete_link?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['link_id' => $linkId]);
    }

    /**
     * 获取获客链接添加的客户列表
     * @access public
     * @param string $linkId 获客链接id
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function customerAcquisitionCustomer($linkId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/customer?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'link_id' => $linkId,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询获客链接剩余使用量
     * @access public
     * @return array
     */
    public function customerAcquisitionQuota()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition_quota?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }
    
    /**
     * 查询获客链接使用详情
     * @access public
     * @param string $linkId 朋友圈创建人的userid
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @return array
     */
    public function customerAcquisitionStatistic($linkId, $startTime, $endTime)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/statistic?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'link_id' => $linkId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 消息推送
    // +=======================
    /**
     * 创建企业群发
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function addMsgTemplate(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 提醒成员群发
     * @access public
     * @param string $msgid 群发消息的id
     * @return array
     */
    public function remindGroupmsgSend($msgid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remind_groupmsg_send?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['msgid' => $msgid]);
    }

    /**
     * 停止企业群发
     * @access public
     * @param string $msgid 群发消息的id
     * @return array
     */
    public function cancelGroupmsgSend($msgid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/cancel_groupmsg_send?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['msgid' => $msgid]);
    }
    
    /**
     * 获取群发记录列表
     * @access public
     * @param string $chatType 群发任务的类型, 默认为single, 表示发送给客户, group表示发送给客户群
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @param string $creator 群发任务创建人企业账号id
     * @param string $filterType 创建人类型, 0企业发表, 1个人发表, 2所有
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getGroupmsgListV2($startTime, $endTime, $chatType = 'single', $creator = '', $filterType = 2, $limit = 20, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_list_v2?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'chat_type' => $chatType,
            'filter_type' => $filterType,
            'limit' => $limit,
        ];
        if (!empty($creator)) {
            $data['creator'] = $creator;
        }
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取群发成员发送任务列表
     * @access public
     * @param string $msgid 群发消息的id
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getGroupmsgTask($msgid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_task?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'msgid' => $msgid,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取企业群发成员执行结果
     * @access public
     * @param string $msgid 群发消息的id
     * @param string $userid 发送成员userid
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getGroupmsgSendResult($msgid, $userid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_send_result?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'msgid' => $msgid,
            'userid' => $userid,
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 发送新客户欢迎语
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function sendWelcomeMsg(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加入群欢迎语素材
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function groupWelcomeTemplateAdd(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑入群欢迎语素材
     * @access public
     * @param string $templateId 欢迎语素材id
     * @param array $data 要更新的数据
     * @return array
     */
    public function groupWelcomeTemplateEdit($templateId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/edit?access_token=ACCESS_TOKEN';
        $data['template_id'] = $templateId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取入群欢迎语素材
     * @access public
     * @param string $templateId 欢迎语素材id
     * @return array
     */
    public function groupWelcomeTemplateGet($templateId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['template_id' => $templateId]);
    }

    /**
     * 删除入群欢迎语素材
     * @access public
     * @param string $templateId 欢迎语素材id
     * @return array
     */
    public function groupWelcomeTemplateDel($templateId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/del?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['template_id' => $templateId]);
    }

    // +=======================
    // | 统计管理
    // +=======================
    /**
     * 获取「联系客户统计」数据
     * @access public
     * @param string[] $userId 成员ID列表
     * @param int[] $partyId 部门ID列表
     * @param int $startTime 起始时间
     * @param int $endTime 结束时间
     * @return array
     */
    public function getUserBehaviorData($startTime, $endTime, array $userId = [], array $partyId = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_user_behavior_data?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
        if (!empty($userId)) {
            $data['userid'] = $userId;
        }
        if (!empty($partyId)) {
            $data['partyid'] = $partyId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取「群聊数据统计」数据(按群主聚合的方式)
     * @access public
     * @param array $data 筛选数据
     * @return array
     */
    public function groupchatStatistic(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/statistic?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取「群聊数据统计」数据(按自然日聚合的方式)
     * @access public
     * @param string[] $useridList 群主ID列表
     * @param int $dayBeginTime 起始日期的时间戳
     * @param int $dayEndTime 结束日期的时间戳
     * @return array
     */
    public function groupchatStatisticGroupByDay(array $useridList, $dayBeginTime, $dayEndTime = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/statistic_group_by_day?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'day_begin_time' => $dayBeginTime,
            'owner_filter' => [
                'userid_list' => $useridList,
            ]
        ];
        if (!empty($dayEndTime)) {
            $data['day_end_time'] = $dayEndTime;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 统计管理
    // +=======================
    /**
     * 创建商品图册
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function addProductAlbum(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_product_album?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取商品图册
     * @access public
     * @param string $productId 商品图册ID
     * @return array
     */
    public function getProductAlbum($productId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_product_album?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取商品图册列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function getProductAlbumList($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_product_album_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑商品图册
     * @access public
     * @param string $productId 商品图册ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function updateProductAlbum($productId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_product_album?access_token=ACCESS_TOKEN';
        $data['product_id'] = $productId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除商品图册
     * @access public
     * @param string $productId 商品图册ID
     * @return array
     */
    public function deleteProductAlbum($productId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/delete_product_album?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['product_id' => $productId]);
    }

    // +=======================
    // | 聊天敏感词管理
    // +=======================
    /**
     * 新建敏感词规则
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function addInterceptRule(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_intercept_rule?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取敏感词规则列表
     * @access public
     * @return array
     */
    public function getInterceptRuleList()
    {
        $url = 'ttps://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_intercept_rule_list?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }

    /**
     * 获取敏感词规则详情
     * @access public
     * @param string $ruleId 规则ID
     * @return array
     */
    public function getInterceptRule($ruleId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_intercept_rule?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['rule_id' => $ruleId]);
    }

    /**
     * 修改敏感词规则
     * @access public
     * @param string $ruleId 规则ID
     * @return array
     */
    public function updateInterceptRule($ruleId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_intercept_rule?access_token=ACCESS_TOKEN';
        $data['rule_id'] = $ruleId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除敏感词规则
     * @access public
     * @param string $ruleId 规则ID
     * @return array
     */
    public function delInterceptRule($ruleId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_intercept_rule?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['rule_id' => $ruleId]);
    }
}