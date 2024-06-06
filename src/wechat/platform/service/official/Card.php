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

namespace think\wechat\platform\service\official;

use think\wechat\platform\service\Service;

/**
 * 卡券管理
 */
class Card extends Service
{
    /**
     * 创建卡券
     * @access public
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 设置买单接口
     * @access public
     * @param string $cardId
     * @param bool $isOpen
     * @return array
     */
    public function setPaycell($cardId, $isOpen = true)
    {
        $url = 'https://api.weixin.qq.com/card/paycell/set?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'is_open' => $isOpen]);
    }

    /**
     * 设置自助核销接口
     * @access public
     * @param string $cardId
     * @param bool $isOpen
     * @return array
     */
    public function setConsumeCell($cardId, $isOpen = true)
    {
        $url = 'https://api.weixin.qq.com/card/selfconsumecell/set?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'is_open' => $isOpen]);
    }

    /**
     * 创建二维码接口
     * @access public
     * @param array $data
     * @return array
     */
    public function createQrc(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/qrcode/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建货架接口
     * @access public
     * @param array $data
     * @return array
     */
    public function createLandingPage(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/landingpage/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 导入自定义code
     * @access public
     * @param string $cardId
     * @param array $code
     * @return array
     */
    public function deposit($cardId, array $code)
    {
        $url = 'https://api.weixin.qq.com/card/code/deposit?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'code' => $code]);
    }

    /**
     * 查询导入code数目
     * @access public
     * @param string $cardId
     * @return array
     */
    public function getDepositCount($cardId)
    {
        $url = 'https://api.weixin.qq.com/card/code/getdepositcount?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId]);
    }

    /**
     * 核查code接口
     * @access public
     * @param string $cardId 进行导入code的卡券ID
     * @param array $code 已经微信卡券后台的自定义code，上限为100个
     * @return array
     */
    public function checkCode($cardId, array $code)
    {
        $url = 'https://api.weixin.qq.com/card/code/checkcode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'code' => $code]);
    }

    /**
     * 图文消息群发卡券
     * @access public
     * @param string $cardId
     * @return array
     */
    public function getNewsHtml($cardId)
    {
        $url = 'https://api.weixin.qq.com/card/mpnews/gethtml?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId]);
    }

    /**
     * 设置测试白名单
     * @access public
     * @param array $openids
     * @param array $usernames
     * @return array
     */
    public function setTestWhiteList($openids = [], $usernames = [])
    {
        $url = 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid' => $openids, 'username' => $usernames]);
    }

    /**
     * 线下核销查询Code
     * @access public
     * @param string $code 单张卡券的唯一标准
     * @param string $cardId 卡券ID代表一类卡券。自定义code卡券必填
     * @param bool $checkConsume 是否校验code核销状态，填入true和false时的code异常状态返回数据不同
     * @return array
     */
    public function getCode($code, $cardId = null, $checkConsume = null)
    {
        $data = ['code' => $code];
        is_null($cardId) || $data['card_id'] = $cardId;
        is_null($checkConsume) || $data['check_consume'] = $checkConsume;
        $url = 'https://api.weixin.qq.com/card/code/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 线下核销核销Code
     * @access public
     * @param string $code 需核销的Code码
     * @param null $card_id 券ID。创建卡券时use_custom_code填写true时必填。非自定义Code不必填写
     * @return array
     */
    public function consume($code, $card_id = null)
    {
        $data = ['code' => $code];
        is_null($card_id) || $data['card_id'] = $card_id;
        $url = 'https://api.weixin.qq.com/card/code/consume?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * Code解码接口
     * @access public
     * @param string $encryptCode
     * @return array
     */
    public function decrypt($encryptCode)
    {
        $url = 'https://api.weixin.qq.com/card/code/decrypt?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['encrypt_code' => $encryptCode]);
    }

    /**
     * 获取用户已领取卡券接口
     * @access public
     * @param string $openid
     * @param null|string $cardId
     * @return array
     */
    public function getCardList($openid, $cardId = null)
    {
        $data = ['openid' => $openid];
        is_null($cardId) || $data['card_id'] = $cardId;
        $url = 'https://api.weixin.qq.com/card/user/getcardlist?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查看卡券详情
     * @access public
     * @param string $cardId
     * @return array
     */
    public function getCard($cardId)
    {
        $url = 'https://api.weixin.qq.com/card/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId]);
    }

    /**
     * 批量查询卡券列表
     * @access public
     * @param int $offset 查询卡列表的起始偏移量，从0开始，即offset: 5是指从从列表里的第六个开始读取
     * @param int $count 需要查询的卡片的数量（数量最大50）
     * @param array $statusList 支持开发者拉出指定状态的卡券列表
     * @return array
     */
    public function batchGet($offset, $count = 50, array $statusList = [])
    {
        $data = ['offset' => $offset, 'count' => $count];
        empty($statusList) || $data['status_list'] = $statusList;
        $url = 'https://api.weixin.qq.com/card/batchget?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更改卡券信息接口
     * @access public
     * @param string $cardId
     * @param array $memberCard
     * @return array
     */
    public function updateCard($cardId, array $memberCard)
    {
        $url = 'https://api.weixin.qq.com/card/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'member_card' => $memberCard]);
    }

    /**
     * 修改库存接口
     * @access public
     * @param string $cardId 卡券ID
     * @param null|integer $increaseStockValue 增加多少库存，支持不填或填0
     * @param null|integer $reduceStockValue 减少多少库存，可以不填或填0
     * @return array
     */
    public function modifyStock($cardId, $increaseStockValue = null, $reduceStockValue = null)
    {
        $data = ['card_id' => $cardId];
        is_null($increaseStockValue) || $data['increase_stock_value'] = $increaseStockValue;
        is_null($reduceStockValue) || $data['reduce_stock_value'] = $reduceStockValue;
        $url = 'https://api.weixin.qq.com/card/modifystock?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更改Code接口
     * @access public
     * @param string $code 需变更的Code码
     * @param string $new_code 变更后的有效Code码
     * @param null|string $card_id 卡券ID
     * @return array
     */
    public function updateCode($code, $new_code, $card_id = null)
    {
        $data = ['code' => $code, 'new_code' => $new_code];
        is_null($card_id) || $data['card_id'] = $card_id;
        $url = 'https://api.weixin.qq.com/card/code/update?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除卡券接口
     * @access public
     * @param string $cardId
     * @return array
     */
    public function deleteCard($cardId)
    {
        $url = 'https://api.weixin.qq.com/card/delete?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId]);
    }

    /**
     * 设置卡券失效接口
     * @access public
     * @param string $code
     * @param string $cardId
     * @param null|string $reason
     * @return array
     */
    public function unAvailable($code, $cardId, $reason = null)
    {
        $data = ['code' => $code, 'card_id' => $cardId];
        is_null($reason) || $data['reason'] = $reason;
        $url = 'https://api.weixin.qq.com/card/code/unavailable?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 拉取卡券概况数据接口
     * @access public
     * @param string $beginDate 查询数据的起始时间
     * @param string $endDate 查询数据的截至时间
     * @param string $condSource 卡券来源(0为公众平台创建的卡券数据 1是API创建的卡券数据)
     * @return array
     */
    public function getCardBizuininfo($beginDate, $endDate, $condSource)
    {
        $url = 'https://api.weixin.qq.com/datacube/getcardbizuininfo?access_token=ACCESS_TOKEN';
        $data = ['begin_date' => $beginDate, 'end_date' => $endDate, 'cond_source' => $condSource];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取免费券数据接口
     * @access public
     * @param string $beginDate 查询数据的起始时间
     * @param string $endDate 查询数据的截至时间
     * @param integer $condSource 卡券来源，0为公众平台创建的卡券数据、1是API创建的卡券数据
     * @param null $cardId 卡券ID
     * @return array
     */
    public function getCardCardinfo($beginDate, $endDate, $condSource, $cardId = null)
    {
        $url = 'https://api.weixin.qq.com/datacube/getcardcardinfo?access_token=ACCESS_TOKEN';
        $data = ['begin_date' => $beginDate, 'end_date' => $endDate, 'cond_source' => $condSource];
        is_null($cardId) || $data['card_id'] = $cardId;
        return $this->platform->callPostApi($url, $data);
    }


    /**
     * 激活会员卡
     * @access public
     * @param array $data
     * @return array
     */
    public function activateMemberCard(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/membercard/activate?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 设置开卡字段接口
     * 用户激活时需要填写的选项
     * @access public
     * @param array $data
     * @return array
     */
    public function setActivateMemberCardUser(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/membercard/activateuserform/set?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取用户提交资料
     * 根据activateTicket获取到用户填写的信息
     * @access public
     * @param string $activateTicket
     * @return array
     */
    public function getActivateMemberCardTempinfo($activateTicket)
    {
        $url = 'https://api.weixin.qq.com/card/membercard/activatetempinfo/get?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['activate_ticket' => $activateTicket]);
    }

    /**
     * 更新会员信息
     * @access public
     * @param array $data
     * @return array
     */
    public function updateMemberCardUser(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/membercard/updateuser?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 拉取会员卡概况数据接口
     * @access public
     * @param string $beginDate 查询数据的起始时间
     * @param string $endDate 查询数据的截至时间
     * @param string $condSource 卡券来源(0为公众平台创建的卡券数据 1是API创建的卡券数据)
     * @return array
     */
    public function getCardMemberCardinfo($beginDate, $endDate, $condSource)
    {
        $url = 'https://api.weixin.qq.com/datacube/getcardmembercardinfo?access_token=ACCESS_TOKEN';
        $data = ['begin_date' => $beginDate, 'end_date' => $endDate, 'cond_source' => $condSource];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 拉取单张会员卡数据接口
     * @access public
     * @param string $beginDate 查询数据的起始时间
     * @param string $endDate 查询数据的截至时间
     * @param string $cardId 卡券id
     * @return array
     */
    public function getCardMemberCardDetail($beginDate, $endDate, $cardId)
    {
        $url = 'https://api.weixin.qq.com/datacube/getcardmembercarddetail?access_token=ACCESS_TOKEN';
        $data = ['begin_date' => $beginDate, 'end_date' => $endDate, 'card_id' => $cardId];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 拉取会员信息（积分查询）接口
     * @access public
     * @param string $cardId 查询会员卡的cardid
     * @param string $code 所查询用户领取到的code值
     * @return array
     */
    public function getCardMemberCard($cardId, $code)
    {
        $url = 'https://api.weixin.qq.com/card/membercard/userinfo/get?access_token=ACCESS_TOKEN';
        $data = ['card_id' => $cardId, 'code' => $code];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 设置支付后投放卡券接口
     * @access public
     * @param array $data
     * @return array
     */
    public function payGiftCard(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/paygiftcard/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除支付后投放卡券规则
     * @access public
     * @param integer $ruleId 支付即会员的规则名称
     * @return array
     */
    public function delPayGiftCard($ruleId)
    {
        $url = 'https://api.weixin.qq.com/card/paygiftcard/add?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['rule_id' => $ruleId]);
    }

    /**
     * 查询支付后投放卡券规则详情
     * @access public
     * @param integer $ruleId 要查询规则id
     * @return array
     */
    public function getPayGiftCard($ruleId)
    {
        $url = 'https://api.weixin.qq.com/card/paygiftcard/getbyid?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['rule_id' => $ruleId]);
    }

    /**
     * 批量查询支付后投放卡券规则
     * @access public
     * @param integer $offset 起始偏移量
     * @param integer $count 查询的数量
     * @param bool $effective 是否仅查询生效的规则
     * @return array
     */
    public function batchGetPayGiftCard($offset = 0, $count = 10, $effective = true)
    {
        $url = 'https://api.weixin.qq.com/card/paygiftcard/batchget?access_token=ACCESS_TOKEN';
        $data = ['type' => 'RULE_TYPE_PAY_MEMBER_CARD', 'offset' => $offset, 'count' => $count, 'effective' => $effective];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 创建支付后领取立减金活动
     * @access public
     * @param array $data
     * @return array
     */
    public function addActivity(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/mkt/activity/create?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 开通券点账户接口
     * @access public
     * @return array
     */
    public function payActivate()
    {
        $url = 'https://api.weixin.qq.com/card/pay/activate?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 对优惠券批价
     * @access public
     * @param string $cardId 需要来配置库存的card_id
     * @param integer $quantity 本次需要兑换的库存数目
     * @return array
     */
    public function getPayprice($cardId, $quantity)
    {
        $url = 'POST https://api.weixin.qq.com/card/pay/getpayprice?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['card_id' => $cardId, 'quantity' => $quantity]);
    }

    /**
     * 查询券点余额接口
     * @access public
     * @return array
     */
    public function getCoinsInfo()
    {
        $url = 'https://api.weixin.qq.com/card/pay/getcoinsinfo?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 确认兑换库存接口
     * @access public
     * @param string $card_id 需要来兑换库存的card_id
     * @param integer $quantity 本次需要兑换的库存数目
     * @param string $orderId 仅可以使用上面得到的订单号，保证批价有效性
     * @return array
     */
    public function payConfirm($cardId, $quantity, $orderId)
    {
        $url = 'https://api.weixin.qq.com/card/pay/confirm?access_token=ACCESS_TOKEN';
        $data = ['card_id' => $cardId, 'quantity' => $quantity, 'order_id' => $orderId];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 充值券点接口
     * @access public
     * @param integer $coinCount
     * @return array
     */
    public function payRecharge($coinCount)
    {
        $url = 'https://api.weixin.qq.com/card/pay/recharge?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['coin_count' => $coinCount]);
    }

    /**
     * 查询订单详情接口
     * @access public
     * @param string $orderId
     * @return array
     */
    public function payGetOrder($orderId)
    {
        $url = 'https://api.weixin.qq.com/card/pay/getorder?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['order_id' => $orderId]);
    }

    /**
     * 查询券点流水详情接口
     * @access public
     * @param array $data
     * @return array
     */
    public function payGetList(array $data)
    {
        $url = 'https://api.weixin.qq.com/card/pay/getorderlist?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

}