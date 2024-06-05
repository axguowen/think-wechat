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

namespace think\wechat\platform\service\work\provider;

/**
 * 企业微信服务商接口调用许可服务
 */
class License extends Base
{
    // +=======================
    // | 订单管理
    // +=======================
    /**
     * 下单购买账号
     * @access public
     * @param string $corpid 授权方企业corpid
     * @param string $buyerUserid 下单人, 服务商企业内成员的明文userid
     * @param int $baseCount 基础账号个数
     * @param int $externalContactCount 互通账号个数
     * @param int $months 购买的月数
     * @param int $days 购买的天数
     * @return array
     */
    public function createNewOrder($corpid, $buyerUserid, $baseCount = 10, $externalContactCount = 0, $months = 1, $days = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/create_new_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'corpid' => $corpid,
            'buyer_userid' => $buyerUserid,
            'account_count' => [
                'base_count' => $baseCount,
                'external_contact_count' => $externalContactCount,
            ],
            'account_duration' => [
                'months' => $months,
                'days' => $days,
            ],
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建续期任务
     * @access public
     * @param string $corpid 授权方企业corpid
     * @param array $accountList 续期的账号列表, 每次最多1000个
     * @param string $jobid 任务id, 若不传则默认创建一个新任务
     * @return array
     */
    public function createRenewOrderJob($corpid, array $accountList, $jobid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/create_renew_order_job?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'corpid' => $corpid,
            'account_list' => $accountList,
        ];
        // 传入了任务ID
        if(!empty($jobid)){
            $data['jobid'] = $jobid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 提交续期订单
     * @access public
     * @param string $jobid 任务id
     * @param string $buyerUserid 下单人, 服务商企业内成员的明文userid
     * @param int $months 购买的月数, 与newExpireTime二者填其一
     * @param int $newExpireTime 指定的新到期时间戳, 与months二者填其一
     * @return array
     */
    public function submitOrderJob($jobid, $buyerUserid, $months = 1, $newExpireTime = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/submit_order_job?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'jobid' => $jobid,
            'buyer_userid' => $buyerUserid,
        ];
        // 指定了新的到期时间
        if($newExpireTime > 0){
            $data['account_duration']['new_expire_time'] = $newExpireTime;
        }
        else{
            $data['account_duration']['months'] = $months;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取订单列表
     * @access public
     * @param string $corpid 授权方企业ID
     * @param int $startTime 起始时间, 按下单时间排序
     * @param int $endTime 结束时间, 起始时间跟结束时间不能超过31天
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function listOrder($corpid = '', $startTime = 0, $endTime = 0, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/list_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了授权方企业ID
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
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
     * 获取订单详情
     * @access public
     * @param string $orderId 订单ID
     * @return array
     */
    public function getOrder($orderId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_order?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['order_id' => $orderId]);
    }

    /**
     * 获取订单中的账号列表
     * @access public
     * @param string $orderId 订单ID
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function listOrderAccount($orderId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/list_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'limit' => $limit,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 取消订单
     * @access public
     * @param string $orderId 订单ID
     * @param string $corpid 企业id, 如果是多企业新购订单时不填, 否则必填
     * @return array
     */
    public function cancelOrder($orderId, $corpid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/cancel_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $order_id,
        ];
        // 指定了企业id
        if(!empty($corpid)){
            $data['corpid'] = $corpid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建多企业新购任务
     * @access public
     * @param array $buyList 企业新购信息列表
     * @param string $jobid 任务id, 若不传则默认创建一个新任务
     * @return array
     */
    public function createNewOrderJob($buyList, $jobid = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/create_renew_order_job?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'buy_list' => $buyList,
        ];
        // 传入了任务ID
        if(!empty($jobid)){
            $data['jobid'] = $jobid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 提交多企业新购订单
     * @access public
     * @param string $jobid 任务id
     * @param string $buyerUserid 下单人, 服务商企业内成员的明文userid
     * @return array
     */
    public function submitNewOrderJob($jobid, $buyerUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/submit_new_order_job?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['jobid' => $jobid, 'buyer_userid' => $buyerUserid]);
    }

    /**
     * 获取订单详情
     * @access public
     * @param string $orderId 订单ID
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function getUnionOrder($orderId, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_union_order?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'order_id' => $orderId,
            'limit' => $limit,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 使用余额支付订单
     * @access public
     * @param string $orderId 订单ID
     * @param string $payerUserid 支付人, 服务商企业内成员的明文userid
     * @return array
     */
    public function submitPayJob($orderId, $payerUserid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/submit_pay_job?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['orderid' => $orderId, 'payer_userid' => $payerUserid]);
    }

    /**
     * 获取订单支付结果
     * @access public
     * @param string $jobid “提交余额支付订单任务” 返回的jobid
     * @return array
     */
    public function payJobResult($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/pay_job_result?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['jobid' => $jobid]);
    }

    // +=======================
    // | 账号管理
    // +=======================
    /**
     * 激活账号
     * @access public
     * @param string $corpid 激活码所属企业corpid
     * @param string $userid 待绑定激活的企业成员userid
     * @param string $activeCode 账号激活码
     * @return array
     */
    public function activeAccount($corpid, $userid, $activeCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/active_account?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['active_code' => $activeCode, 'corpid' => $corpid, 'userid' => $userid]);
    }

    /**
     * 批量激活账号
     * @access public
     * @param string $corpid 激活码所属企业corpid
     * @param array $activeList 需要激活的账号列表
     * @return array
     */
    public function batchActiveAccount($corpid, array $activeList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/batch_active_account?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'active_list' => $activeList]);
    }

    /**
     * 获取激活码详情
     * @access public
     * @param string $corpid 要查询的企业的corpid
     * @param string $activeCode 激活码
     * @return array
     */
    public function getActiveInfoByCode($corpid, $activeCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_active_info_by_code?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'active_code' => $activeCode]);
    }

    /**
     * 批量获取激活码详情
     * @access public
     * @param string $corpid 要查询的企业的corpid
     * @param array $activeCodeList 激活码列表
     * @return array
     */
    public function batchGetActiveInfoByCode($corpid, array $activeCodeList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/batch_get_active_info_by_code?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'active_code_list' => $activeCodeList]);
    }

    /**
     * 获取企业的账号列表
     * @access public
     * @param string $corpid 要查询的企业的corpid
     * @param int $limit 返回的最大记录数, 整型, 最大值1000, 默认值50
     * @param string $cursor 用于分页查询的游标
     * @return array
     */
    public function listActivedAccount($corpid, $limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/list_actived_account?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'corpid' => $corpid,
            'limit' => $limit,
        ];
        // 指定了分页游标
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取成员的激活详情 
     * @access public
     * @param string $corpid 要查询的企业的corpid
     * @param string $userid 待查询员工的userid
     * @return array
     */
    public function getActiveInfoByUser($corpid, $userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_active_info_by_user?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'userid' => $userid]);
    }

    /**
     * 账号继承
     * @access public
     * @param string $corpid 待绑定激活的成员所属企业corpid
     * @param array $transferList 激活码列表
     * @return array
     */
    public function batchTransferLicense($corpid, array $transferList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/batch_transfer_license?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'transfer_list' => $transferList]);
    }

    /**
     * 分配激活码给下游/下级企业
     * @access public
     * @param string $fromCorpid 上游/上级企业corpid
     * @param string $toCorpid 下游/下级企业corpid
     * @param array $shareList 分配的接口许可列表
     * @param int $corpLinkType 分配的场景, 0上下游, 1企业互联, 默认0
     * @return array
     */
    public function batchShareActiveCode($fromCorpid, $toCorpid, array $shareList, $corpLinkType = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/batch_share_active_code?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'from_corpid' => $fromCorpid,
            'to_corpid' => $toCorpid,
            'share_list' => $shareList,
            'corp_link_type' => $corpLinkType,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 应用管理
    // +=======================
    /**
     * 获取应用的接口许可状态
     * @access public
     * @param string $corpid 企业id
     * @param string $suiteId 应用SuiteId
     * @return array
     */
    public function getAppLicenseInfo($corpid, $suiteId)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_app_license_info?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'corpid' => $corpid,
            'suite_id' => $suiteId,
            'appid' => 1,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 自动激活设置
    // +=======================
    /**
     * 设置企业的许可自动激活状态
     * @access public
     * @param string $corpid 企业id
     * @param string $autoActiveStatus 许可自动激活状态: 0关闭,1打开
     * @return array
     */
    public function setAutoActiveStatus($corpid, $autoActiveStatus)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/set_auto_active_status?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid, 'auto_active_status' => $autoActiveStatus]);
    }

    /**
     * 查询企业的许可自动激活状态
     * @access public
     * @param string $corpid 企业id
     * @return array
     */
    public function getAutoActiveStatus($corpid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/license/get_auto_active_status?provider_access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['corpid' => $corpid]);
    }
}