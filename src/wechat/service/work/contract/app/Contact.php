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
 * 企业微信应用通讯录管理服务基础类
 */
abstract class Contact extends Service
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
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 读取成员
     * @access public
     * @param string $userid 成员UserID
     * @return array
     */
    public function userGet($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
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
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, array_merge($data, ['userid' => $userid]));
    }

    /**
     * 删除成员
     * @access public
     * @param string $userid 成员UserID
     * @return array
     */
    public function userDelete($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 批量删除成员
     * @access public
     * @param string[] $useridlist 成员UserID
     * @return array
     */
    public function userBatchDelete(array $useridlist)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/batchdelete?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['useridlist' => $useridlist]);
    }

    /**
     * 获取部门成员
     * @access public
     * @param string $departmentId 获取的部门id
     * @return array
     */
    public function userSimplelist($departmentId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token=ACCESS_TOKEN&department_id={$departmentId}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取部门成员详情
     * @access public
     * @param string $departmentId 获取的部门id
     * @return array
     */
    public function userList($departmentId)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token=ACCESS_TOKEN&department_id={$departmentId}";
        return $this->platform->callGetApi($url);
    }

    /**
     * userid转openid
     * @access public
     * @param string $userid 企业内的成员id
     * @return array
     */
    public function userConvertToOpenid($userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid]);
    }

    /**
     * openid转userid
     * @access public
     * @param string $openid 企业内的成员id
     * @return array
     */
    public function userConvertToUserid($openid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid' => $openid]);
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
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/invite?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        if (!empty($user)) {
            $data['user'] = $user;
        }
        if (!empty($party)) {
            $data['party'] = $party;
        }
        if (!empty($tag)) {
            $data['tag'] = $tag;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 手机号获取userid
     * @access public
     * @param string $mobile 用户在企业微信通讯录中的手机号码
     * @return array
     */
    public function userGetuserid($mobile)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['mobile' => $mobile]);
    }

    /**
     * 邮箱获取userid
     * @access public
     * @param string $email 用户在企业微信通讯录中的手机号码
     * @param int $emailType 邮箱类型: 1企业邮箱(默认), 2个人邮箱
     * @return array
     */
    public function userGetUseridByEmail($email, $emailType = 1)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/get_userid_by_email?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['email' => $email, 'email_type' => $emailType]);
    }

    /**
     * 获取成员ID列表
     * @access public
     * @param int $limit 每次拉取的数据量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @return array
     */
    public function userListId($limit = 50, $cursor = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/list_id?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 返回
        return $this->platform->callPostApi($url, $data);
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
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
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
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, array_merge($data, ['id' => $id]));
    }

    /**
     * 删除部门
     * @access public
     * @param int $id 部门id
     * @return array
     */
    public function departmentDelete($id)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/delete?access_token=ACCESS_TOKEN&id={$id}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取部门列表
     * @access public
     * @param string $id 获取的部门id
     * @return array
     */
    public function departmentList($id)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN&id={$id}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取子部门ID列表
     * @access public
     * @param string $id 获取的部门id
     * @return array
     */
    public function departmentSimplelist($id)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/simplelist?access_token=ACCESS_TOKEN&id={$id}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取单个部门详情
     * @access public
     * @param int $id 部门id
     * @return array
     */
    public function departmentGet($id)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/get?access_token=ACCESS_TOKEN&id={$id}";
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 标签管理
    // +=======================
    /**
     * 创建标签
     * @access public
     * @param string $tagname 标签名称
     * @param int $tagid 标签ID
     * @return array
     */
    public function tagCreate($tagname, $tagid = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/create?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tagname' => $tagname,
        ];
        if ($tagid > 0) {
            $data['tagid'] = $tagid;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新标签
     * @access public
     * @param int $tagid 标签ID
     * @param string $tagname 标签名称
     * @return array
     */
    public function tagUpdate($tagid, $tagname)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['tagid' => $tagid, 'tagname' => $tagname]);
    }

    /**
     * 删除标签
     * @access public
     * @param int $tagid 标签id
     * @return array
     */
    public function tagDelete($tagid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/tag/delete?access_token=ACCESS_TOKEN&tagid={$tagid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取标签成员
     * @access public
     * @param int $tagid 标签id
     * @return array
     */
    public function tagGet($tagid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/tag/get?access_token=ACCESS_TOKEN&tagid={$tagid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 增加标签成员
     * @access public
     * @param int $tagid 标签ID
     * @param string[] $userlist 企业成员ID列表
     * @param int[] $partylist 企业部门ID列表
     * @return array
     */
    public function tagAddtagusers($tagid, array $userlist = [], array $partylist = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/addtagusers?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tagid' => $tagid,
        ];
        if (!empty($userlist)) {
            $data['userlist'] = $userlist;
        }
        if (!empty($partylist)) {
            $data['partylist'] = $partylist;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除标签成员
     * @access public
     * @param int $tagid 标签ID
     * @param string[] $userlist 企业成员ID列表
     * @param int[] $partylist 企业部门ID列表
     * @return array
     */
    public function tagDeltagusers($tagid, array $userlist = [], array $partylist = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/deltagusers?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'tagid' => $tagid,
        ];
        if (!empty($userlist)) {
            $data['userlist'] = $userlist;
        }
        if (!empty($partylist)) {
            $data['partylist'] = $partylist;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取标签列表
     * @access public
     * @return array
     */
    public function tagList()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/list?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
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
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/syncuser?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'media_id' => $mediaId,
            'to_invite' => $toInvite,
        ];
        if (!empty($callback)) {
            $data['callback'] = $callback;
        }
        return $this->platform->callPostApi($url, $data);
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
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/replaceuser?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'media_id' => $mediaId,
            'to_invite' => $toInvite,
        ];
        if (!empty($callback)) {
            $data['callback'] = $callback;
        }
        return $this->platform->callPostApi($url, $data);
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
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/batch/replaceparty?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'media_id' => $mediaId,
        ];
        if (!empty($callback)) {
            $data['callback'] = $callback;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取异步任务结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function batchGetresult($jobid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/batch/getresult?access_token=ACCESS_TOKEN&jobid={$jobid}";
        return $this->platform->callGetApi($url);
    }

    // +=======================
    // | 异步导出接口
    // +=======================
    /**
     * 导出成员
     * @access public
     * @param string $encodingAeskey Base64编码后的加密密钥
     * @param int $blockSize 每块数据的人员数
     * @return array
     */
    public function exportSimpleUser($encodingAeskey, $blockSize = 1000000)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/export/simple_user?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'encoding_aeskey' => $encodingAeskey,
            'block_size' => $blockSize,
        ]);
    }

    /**
     * 导出成员详情
     * @access public
     * @param string $encodingAeskey Base64编码后的加密密钥
     * @param int $blockSize 每块数据的人员数
     * @return array
     */
    public function exportUser($encodingAeskey, $blockSize = 1000000)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/export/user?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'encoding_aeskey' => $encodingAeskey,
            'block_size' => $blockSize,
        ]);
    }

    /**
     * 导出部门
     * @access public
     * @param string $encodingAeskey Base64编码后的加密密钥
     * @param int $blockSize 每块数据的人员数
     * @return array
     */
    public function exportDepartment($encodingAeskey, $blockSize = 1000000)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/export/department?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'encoding_aeskey' => $encodingAeskey,
            'block_size' => $blockSize,
        ]);
    }

    /**
     * 导出标签成员
     * @access public
     * @param int $tagid 标签id
     * @param string $encodingAeskey Base64编码后的加密密钥
     * @param int $blockSize 每块数据的人员数
     * @return array
     */
    public function exportTaguser($tagid, $encodingAeskey, $blockSize = 1000000)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/export/taguser?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, [
            'tagid' => $tagid,
            'encoding_aeskey' => $encodingAeskey,
            'block_size' => $blockSize,
        ]);
    }

    /**
     * 获取导出结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function exportGetResult($jobid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/export/get_result?access_token=ACCESS_TOKEN&jobid={$jobid}";
        return $this->platform->callGetApi($url);
    }
}