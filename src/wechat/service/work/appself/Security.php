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

use think\wechat\Service;

/**
 * 企业微信自建应用安全管理服务
 */
class Security extends Service
{
    // +=======================
    // | 文件防泄漏
    // +=======================
    /**
     * 查询文件上传、下载、转发等操作记录
     * @access public
     * @param int $startTime 开始时间
     * @param int $endTime 结束时间
     * @param array $useridList 需要查询的文件操作者的userid
     * @param array $operation
     * @param int $limit 限制返回的条数
     * @param string $cursor 分页游标
     * @return array
     */
    public function getFileOperRecord($startTime, $endTime, array $useridList = [], array $operation = [], $limit = 10, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/get_file_oper_record?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'limit' => $limit,
        ];
        if(!empty($useridList)){
            $data['userid_list'] = $useridList;
        }
        if(!empty($operation)){
            $data['operation'] = $operation;
        }
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 设备管理
    // +=======================
    /**
     * 导入可信企业设备
     * @access public
     * @param array $deviceList 设备列表
     * @return array
     */
    public function trustdeviceImport(array $deviceList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/trustdevice/import?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['device_list' => $deviceList]);
    }

    /**
     * 获取设备信息
     * @access public
     * @param int $type 查询设备类型, 1可信企业设备 2未知设备 3可信个人设备
     * @param int $limit 每页数量
     * @param string $cursor 分页游标
     * @return array
     */
    public function trustdeviceList($type = 1, $limit = 10, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/trustdevice/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'type' => $type,
            'limit' => $limit,
        ];
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取成员使用设备
     * @access public
     * @param string $lastLoginUserid 最后登录的成员userid
     * @param int $type 查询设备类型, 1可信企业设备 2未知设备 3可信个人设备
     * @return array
     */
    public function trustdeviceGetByUser($lastLoginUserid, $type = 1)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/trustdevice/get_by_user?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'last_login_userid' => $lastLoginUserid,
            'type' => $type,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    // +=======================
    // | 高级功能账号管理
    // +=======================
    /**
     * 分配高级功能账号
     * @access public
     * @param string[] $useridList 要分配高级功能的企业成员userid列表
     * @return array
     */
    public function vipSubmitBatchAddJob(array $useridList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/vip/submit_batch_add_job?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid_list' => $useridList]);
    }

    /**
     * 查询分配高级功能账号结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function vipBatchAddJobResult($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/vip/batch_add_job_result?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['jobid' => $jobid]);
    }

    /**
     * 取消高级功能账号
     * @access public
     * @param string[] $useridList 要分配高级功能的企业成员userid列表
     * @return array
     */
    public function vipSubmitBatchDelJob(array $useridList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/vip/submit_batch_del_job?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid_list' => $useridList]);
    }

    /**
     * 查询取消高级功能账号结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function vipBatchDelJobResult($jobid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/vip/batch_del_job_result?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['jobid' => $jobid]);
    }

    /**
     * 查询取消高级功能账号结果
     * @access public
     * @param int $limit 每页数量
     * @param string $cursor 分页游标
     * @return array
     */
    public function vipList($limit = 10, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/security/vip/list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if(!empty($cursor)){
            $data['cursor'] = $cursor;
        }
        return $this->platform->callPostApi($url, $data);
    }
}