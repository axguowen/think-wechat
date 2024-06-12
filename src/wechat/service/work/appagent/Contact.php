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

namespace think\wechat\service\work\appagent;

use think\wechat\service\work\contract\app\Contact as Service;

/**
 * 企业微信代开发应用通讯录管理服务
 */
class Contact extends Service
{
    // +=======================
    // | 成员管理
    // +=======================
    /**
     * 创建成员
     * @access public
     * @param array $data 成员信息
     * @return array
     */
    public function userCreate(array $data)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 更新成员
     * @access public
     * @param string $userid 成员UserID
     * @param array $data 成员信息
     * @return array
     */
    public function userUpdate($userid, array $data)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 删除成员
     * @access public
     * @param string $userid 成员UserID
     * @return array
     */
    public function userDelete($userid)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 批量删除成员
     * @access public
     * @param string[] $useridlist 成员UserID
     * @return array
     */
    public function userBatchDelete(array $useridlist)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 邀请成员
     * @access public
     * @param string[] $user 成员ID列表
     * @param int[] $party 部门ID列表
     * @param int[] $tag 标签ID列表
     * @return array
     */
    public function batchInvite(array $user = [], array $party = [], array $tag = [])
    {
        return [null, new \Exception('不支持该方法')];
    }

    // +=======================
    // | 部门管理
    // +=======================
    /**
     * 创建部门
     * @access public
     * @param array $data 部门信息
     * @return array
     */
    public function departmentCreate(array $data)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 更新部门
     * @access public
     * @param int $id 部门id
     * @param array $data 部门信息
     * @return array
     */
    public function departmentUpdate($id, array $data)
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 删除部门
     * @access public
     * @param int $id 部门id
     * @return array
     */
    public function departmentDelete($id)
    {
        return [null, new \Exception('不支持该方法')];
    }

    // +=======================
    // | 异步导入接口
    // +=======================
    /**
     * 增量更新成员
     * @access public
     * @param string $mediaId 上传的csv文件的media_id
     * @param bool $toInvite 是否邀请新建的成员使用企业微信
     * @param array $callback 回调信息
     * @return array
     */
    public function batchSyncuser($mediaId, $toInvite = true, array $callback = [])
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 全量覆盖成员
     * @access public
     * @param string $mediaId 上传的csv文件的media_id
     * @param bool $toInvite 是否邀请新建的成员使用企业微信
     * @param array $callback 回调信息
     * @return array
     */
    public function batchReplaceuser($mediaId, $toInvite = true, array $callback = [])
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 全量覆盖部门
     * @access public
     * @param string $mediaId 上传的csv文件的media_id
     * @param array $callback 回调信息
     * @return array
     */
    public function batchReplaceparty($mediaId, array $callback = [])
    {
        return [null, new \Exception('不支持该方法')];
    }

    /**
     * 获取异步任务结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function batchGetresult($jobid)
    {
        return [null, new \Exception('不支持该方法')];
    }
}