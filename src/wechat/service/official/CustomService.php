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

namespace think\wechat\service\official;

use think\wechat\Service;

/**
 * 客服消息处理
 */
class CustomService extends Service
{
    /**
     * 添加客服帐号
     * @access public
     * @param string $kf_account 客服账号
     * @param string $nickname 客服昵称
     * @return array
     */
    public function addAccount($kf_account, $nickname)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['kf_account' => $kf_account, 'nickname' => $nickname]);
    }

    /**
     * 修改客服帐号
     * @access public
     * @param string $kfAccount 客服账号
     * @param string $nickname 客服昵称
     * @return array
     */
    public function updateAccount($kfAccount, $nickname)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['kf_account' => $kfAccount, 'nickname' => $nickname]);
    }

    /**
     * 删除客服帐号
     * @access public
     * @param string $kfAccount 客服账号
     * @return array
     */
    public function deleteAccount($kfAccount)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['kf_account' => $kfAccount]);
    }

    /**
     * 邀请绑定客服帐号
     * @access public
     * @param string $kfAccount 完整客服帐号，格式为：帐号前缀@公众号微信号
     * @param string $inviteWx 接收绑定邀请的客服微信号
     * @return array
     */
    public function inviteWorker($kfAccount, $inviteWx)
    {
        $url = 'https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['kf_account' => $kfAccount, 'invite_wx' => $inviteWx]);
    }

    /**
     * 获取所有客服账号
     * @access public
     * @return array
     */
    public function getAccountList()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    /**
     * 获取在线客服账号
     * @access public
     * @return array
     */
    public function getOnlineAccountList()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=ACCESS_TOKEN';
        return $this->handler->callGetApi($url);
    }

    /**
     * 设置客服帐号的头像
     * @access public
     * @param string $kfAccount 客户账号
     * @param string $fileName 文件名
     * @param string $fileContent 文件内容
     * @param string $mimeType 文件类型
     * @return array
     */
    public function uploadHeadimg($kfAccount, $fileName, $fileContent, $mimeType = null)
    {
        $url = "https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=ACCESS_TOKEN&kf_account={$kfAccount}";
        return $this->handler->callMultipartPostApi($url, [], 'media', $fileName, $fileContent, $mimeType);
    }

    /**
     * 客服接口-发消息
     * @access public
     * @param array $data
     * @return array
     */
    public function send(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 客服输入状态
     * @access public
     * @param string $openid 普通用户（openid）
     * @param string $command Typing:正在输入,CancelTyping:取消正在输入
     * @return array
     */
    public function typing($openid, $command = 'Typing')
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['touser' => $openid, 'command' => $command]);
    }

    /**
     * 根据标签进行群发【订阅号与服务号认证后均可用】
     * @access public
     * @param array $data
     * @return array
     */
    public function massSendAll(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
     * @access public
     * @param array $data
     * @return array
     */
    public function massSend(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 删除群发【订阅号与服务号认证后均可用】
     * @access public
     * @param integer $msg_id 发送出去的消息ID
     * @param null|integer $article_idx 要删除的文章在图文消息中的位置，第一篇编号为1，该字段不填或填0会删除全部文章
     * @return array
     */
    public function massDelete($msg_id, $article_idx = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=ACCESS_TOKEN';
        $data = ['msg_id' => $msg_id];
        is_null($article_idx) || $data['article_idx'] = $article_idx;
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 预览接口【订阅号与服务号认证后均可用】
     * @access public
     * @param array $data
     * @return array
     */
    public function massPreview(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, $data);
    }

    /**
     * 查询群发消息发送状态【订阅号与服务号认证后均可用】
     * @access public
     * @param integer $msgId 群发消息后返回的消息id
     * @return array
     */
    public function massGet($msgId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['msg_id' => $msgId]);
    }

    /**
     * 获取群发速度
     * @access public
     * @return array
     */
    public function massGetSeed()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, []);
    }

    /**
     * 设置群发速度
     * @access public
     * @param integer $speed 群发速度的级别
     * @return array
     */
    public function massSetSeed($speed)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/set?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['speed' => $speed]);
    }
}