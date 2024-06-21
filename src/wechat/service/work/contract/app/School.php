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
 * 家校 沟通/应用 服务基础类
 */
abstract class School extends Service
{
    // +=======================
    // | 基础接口
    // +=======================
    /**
     * 获取「学校通知」二维码
     * @access public
     * @return array
     */
    public function getSubscribeQrCode()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_subscribe_qr_code?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 设置关注「学校通知」的模式
     * @access public
     * @param string $subscribeMode 关注模式, 1可扫码填写资料加入, 2禁止扫码填写资料加入
     * @return array
     */
    public function setSubscribeMode($subscribeMode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/set_subscribe_mode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['subscribe_mode' => $subscribeMode]);
    }

    /**
     * 获取关注「学校通知」的模式
     * @access public
     * @return array
     */
    public function getSubscribeMode()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_subscribe_mode?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url, ['subscribe_mode' => $subscribeMode]);
    }

    /**
     * 发送「学校通知」
     * @access public
     * @param int $agentid 企业应用的id
     * @param array $msgdata 消息内容
     * @param array $todata 指定接收消息的用户或部门数据
     * @param string $msgtype 消息类型
     * @param array $options 其它参数
     * @return array
     */
    public function messageSend($agentid, array $msgdata, array $todata, $msgtype = 'text', array $options = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/message/send?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = array_merge($options, $todata, [
            'agentid' => $agentid,
            'msgtype' => $msgtype,
            $msgtype => $msgdata,
        ]);
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取班级群创建方式
     * @access public
     * @return array
     */
    public function getChatCreateMode()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/get_chat_create_mode?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 设置班级群创建方式
     * @access public
     * @param string $createMode 创建模式, 0自动创建, 1手动创建
     * @return array
     */
    public function setChatCreateMode($createMode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/set_chat_create_mode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['create_mode' => $createMode]);
    }

    /**
     * 外部联系人openid转换
     * @access public
     * @param string $externalUserid 外部联系人的userid
     * @return array
     */
    public function convertToOpenid($externalUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/convert_to_openid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['external_userid' => $externalUserid]);
    }

    /**
     * 获取可使用的家长范围
     * @access public
     * @param int $agentid 企业应用的id
     * @return array
     */
    public function agentGetAllowScope()
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/agent/get_allow_scope?access_token=ACCESS_TOKEN&agentid={$agentid}";
        return $this->platform->callGetApi($url);
    }
    
    // +=======================
    // | 网页授权登录
    // +=======================
    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthRedirect($redirectUri, $state = '', $scope = 'snsapi_base')
    {
        $appid = $this->platform->getConfig('corpid');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$suiteId}&agentid={$agentid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 获取访问用户身份
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getUserInfo($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo?access_token=ACCESS_TOKEN&code={$code}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取家校访问用户身份 
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getSchoolUserInfo($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/getuserinfo?access_token=ACCESS_TOKEN&code={$code}";
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 学生与家长管理
    // +=======================
    /**
     * 创建学生
     * @access public
     * @param string $studentUserid 学生UserID
     * @param string $name 学生姓名
     * @param int[] $department 学生所在的班级id列表
     * @param string $mobile 学生手机号
     * @param bool $toInvite 是否发起邀请
     * @return array
     */
    public function userCreateStudent($studentUserid, $name, array $department, $mobile = '', $toInvite = true)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/create_student?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'student_userid' => $studentUserid,
            'name' => $name,
            'department' => $department,
            'mobile' => $mobile,
            'to_invite' => $toInvite,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除学生
     * @access public
     * @param string $userid 家校通信录中学生的userid
     * @return array
     */
    public function userDeleteStudent($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/user/delete_student?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 更新学生
     * @access public
     * @param string $studentUserid 学生UserID
     * @param array $data 要更新的数据
     * @return array
     */
    public function userUpdateStudent($studentUserid, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/update_student?access_token=ACCESS_TOKEN';
        $data['student_userid'] = $studentUserid;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 批量创建学生
     * @access public
     * @param array $students 学生列表
     * @return array
     */
    public function userBatchCreateStudent(array $students)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_create_student?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['students' => $students,]);
    }

    /**
     * 批量删除学生
     * @access public
     * @param string[] $useridlist 家校通信录中学生的userid列表
     * @return array
     */
    public function userBatchDeleteStudent($useridlist)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_delete_student?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['useridlist' => $useridlist,]);
    }

    /**
     * 批量更新学生
     * @access public
     * @param array $students 学生列表
     * @return array
     */
    public function userBatchUpdateStudent(array $students)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_update_student?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['students' => $students,]);
    }

    /**
     * 创建家长
     * @access public
     * @param string $parentUserid 家长UserID
     * @param string $mobile 学生手机号
     * @param array $children 学生所在的班级id列表
     * @param bool $toInvite 是否发起邀请
     * @return array
     */
    public function userCreateParent($parentUserid, $mobile = '', array $children, $toInvite = true)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/create_parent?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'parent_userid' => $parentUserid,
            'mobile' => $mobile,
            'children' => $children,
            'to_invite' => $toInvite,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除家长
     * @access public
     * @param string $userid 家校通信录中家长的userid
     * @return array
     */
    public function userDeleteParent($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/user/delete_parent?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 更新家长
     * @access public
     * @param string $parentUserid 家长UserID
     * @param array $data 要更新的数据
     * @return array
     */
    public function userUpdateParent($parentUserid, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/update_parent?access_token=ACCESS_TOKEN';
        $data['parent_userid'] = $parentUserid;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 批量创建家长
     * @access public
     * @param array $parents 家长列表
     * @return array
     */
    public function userBatchCreateParent(array $parents)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_create_parent?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['parents' => $parents,]);
    }

    /**
     * 批量删除家长
     * @access public
     * @param string[] $useridlist 家校通信录中家长的userid列表
     * @return array
     */
    public function userBatchDeleteParent($useridlist)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_delete_parent?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['useridlist' => $useridlist,]);
    }

    /**
     * 批量更新家长
     * @access public
     * @param array $parents 家长列表
     * @return array
     */
    public function userBatchUpdateParent(array $parents)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/batch_update_parent?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['parents' => $parents,]);
    }

    /**
     * 读取学生或家长
     * @access public
     * @param string $userid 家校通讯录的userid
     * @return array
     */
    public function userGet($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/user/get?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取部门学生详情
     * @access public
     * @param int $departmentId 获取的部门id
     * @return array
     */
    public function userList($departmentId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/user/list?access_token=ACCESS_TOKEN&department_id={$departmentId}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 设置家校通讯录自动同步模式
     * @access public
     * @param string $archSyncMode 家校通讯录同步模式: 1禁止将标签同步至家校通讯录, 2禁止将家校通讯录同步至标签, 3禁止家校通讯录和标签相互同步
     * @return array
     */
    public function setArchSyncMode($archSyncMode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/set_arch_sync_mode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['arch_sync_mode' => $archSyncMode,]);
    }

    /**
     * 获取部门家长详情
     * @access public
     * @param int $departmentId 获取的部门id
     * @return array
     */
    public function userListParent($departmentId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/user/list_parent?access_token=ACCESS_TOKEN&department_id={$departmentId}";
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 部门管理
    // +=======================
    /**
     * 创建部门
     * @access public
     * @param array $data 数据
     * @return array
     */
    public function departmentCreate(array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/department/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新部门
     * @access public
     * @param int $id 部门ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function departmentUpdate($id, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/department/update?access_token=ACCESS_TOKEN';
        $data['id'] = $id;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除部门
     * @access public
     * @param int $id 部门ID
     * @return array
     */
    public function departmentDelete($id)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/department/delete?access_token=ACCESS_TOKEN&id={$id}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取部门列表 
     * @access public
     * @param int $id 部门ID
     * @return array
     */
    public function departmentList($id = 0)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/department/list?access_token=ACCESS_TOKEN';
        $data = [];
        if($id > 0){
            $data['id'] = $id;
        }
        return $this->platform->callGetApi($url, $data);
    }

    /**
     * 修改自动升年级的配置
     * @access public
     * @param int $upgradeSwitch 开启或关闭自动升年级
     * @param int $upgradeTime 自动升年级的时间, 该时间戳只有月和日有效
     * @return array
     */
    public function setUpgradeInfo($upgradeSwitch = 0, $upgradeTime = 0)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/set_upgrade_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'upgrade_switch' => $upgradeSwitch,
            'upgrade_time' => $upgradeTime,
        ]);
    }

    // +=======================
    // | 上课直播
    // +=======================
    /**
     * 获取老师直播ID列表
     * @access public
     * @param string $userid 企业成员的userid
     * @param int $limit 返回的最大记录数
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function livingGetUserAllLivingid($userid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/living/get_user_all_livingid?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'userid' => $userid,
            'limit' => $limit,
        ];
        // 指定了游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取直播详情
     * @access public
     * @param string $livingid 直播ID
     * @return array
     */
    public function livingGetLivingInfo($livingid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/living/get_living_info?access_token=ACCESS_TOKEN&livingid={$livingid}";
        return $this->platform->callGetApi($url);
    }
    
    /**
     * 获取观看直播统计
     * @access public
     * @param string $livingid 直播ID
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function livingGetWatchStat($livingid, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/living/get_watch_stat?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'livingid' => $livingid,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取未观看直播统计
     * @access public
     * @param string $livingid 直播ID
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function livingGetUnwatchStat($livingid, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/living/get_unwatch_stat?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'livingid' => $livingid,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 删除直播回放
     * @access public
     * @param string $livingid 直播ID
     * @return array
     */
    public function livingDeleteReplayData($livingid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/living/delete_replay_data?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['livingid' => $livingid]);
    }
    
    /**
     * 获取观看直播统计V2
     * @access public
     * @param string $livingid 直播ID
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function livingGetWatchStatV2($livingid, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/living/get_watch_stat_v2?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'livingid' => $livingid,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->platform->callPostApi($url, $data);
    }
    
    /**
     * 获取未观看直播统计V2
     * @access public
     * @param string $livingid 直播ID
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function livingGetUnwatchStatV2($livingid, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/living/get_unwatch_stat_v2?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'livingid' => $livingid,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 班级收款
    // +=======================
    /**
     * 获取学生付款结果
     * @access public
     * @param string $paymentId 收款项目id
     * @return array
     */
    public function getPaymentResult($paymentId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/get_payment_result?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['payment_id' => $paymentId]);
    }

    /**
     * 获取订单详情
     * @access public
     * @param string $paymentId 收款项目id
     * @param string $tradeNo 订单号
     * @return array
     */
    public function getTrade($tradeNo)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/get_trade?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['payment_id' => $paymentId, 'trade_no' => $tradeNo]);
    }
}