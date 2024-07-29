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

use think\wechat\service\work\contract\app\School as Service;

/**
 * 家校 沟通/应用 服务
 */
class School extends Service
{
    // +=======================
    // | 健康上报
    // +=======================
    /**
     * 获取健康上报使用统计
     * @access public
     * @param string $date 具体某天的使用统计
     * @return array
     */
    public function healthGetHealthReportStat($date)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/health/get_health_report_stat?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['date' => $date]);
    }

    /**
     * 获取健康上报任务ID列表
     * @access public
     * @param int $limit 返回的最大记录数
     * @param string $offset 偏移量
     * @return array
     */
    public function healthGetReportJobids($limit = 50, $offset = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/health/get_report_jobids?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        // 指定了偏移量
        if(!empty($offset)){
            $data['offset'] = $offset;
        }
        return $this->handler->callPostApi($url, $data);
    }
    
    /**
     * 获取健康上报任务详情
     * @access public
     * @param string $jobid 任务ID
     * @param string $date 具体某天的任务详情
     * @return array
     */
    public function healthGetReportJobInfo($jobid, $date)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/health/get_report_job_info?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['jobid' => $jobid, 'date' => $date]);
    }
    
    /**
     * 获取用户填写答案
     * @access public
     * @param string $jobid 任务ID
     * @param string $date 具体某天任务的填写答案
     * @param int $limit 返回的最大记录数
     * @param string $offset 偏移量
     * @return array
     */
    public function healthGetReportAnswer($jobid, $date)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/health/get_report_answer?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
            'jobid' => $jobid,
            'date' => $date,
        ];
        // 指定了偏移量
        if(!empty($offset)){
            $data['offset'] = $offset;
        }
        return $this->handler->callPostApi($url, $data);
    }

    // +=======================
    // | 复学码
    // +=======================
    /**
     * 获取老师健康信息
     * @access public
     * @param string $date 具体某天的健康信息
     * @param int $limit 返回的最大记录数
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function userGetTeacherCustomizeHealthInfo($date, $limit = 50, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/get_teacher_customize_health_info?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'date' => $date,
            'limit' => $limit,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 获取学生健康信息
     * @access public
     * @param string $date 具体某天的健康信息
     * @param int $limit 返回的最大记录数
     * @param string $nextKey 上一次调用时返回的next_key
     * @return array
     */
    public function userGetStudentCustomizeHealthInfo($date, $limit = 50, $nextKey = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/get_student_customize_health_info?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'date' => $date,
            'limit' => $limit,
        ];
        // 指定了偏移量
        if(!empty($nextKey)){
            $data['next_key'] = $nextKey;
        }
        return $this->handler->callPostApi($url, $data);
    }

    /**
     *  获取师生健康码
     * @access public
     * @param string[] $userids 老师或者学生的userid列表
     * @param int $type userid类型, 1老师, 2学生
     * @return array
     */
    public function userGetHealthQrcode($userids, $type = 1)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/school/user/get_health_qrcode?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['userids' => $userids, 'type' => $type]);
    }
}