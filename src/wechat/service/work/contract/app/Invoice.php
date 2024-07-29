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
 * 电子发票服务基础类
 */
abstract class Invoice extends Service
{
    /**
     * 查询电子发票
     * @access public
     * @param string $cardId 发票ID
     * @param string $encryptCode 加密code
     * @return array
     */
    public function getInvoiceInfo($cardId, $encryptCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/getinvoiceinfo?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, ['card_id' => $cardId, 'encrypt_code' => $encryptCode]);
    }

    /**
     * 更新发票状态
     * @access public
     * @param string $cardId 发票ID
     * @param string $encryptCode 加密code
     * @param string $reimburseStatus 发票状态
     * @return array
     */
    public function updateInvoiceStatus($cardId, $encryptCode, $reimburseStatus)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/updateinvoicestatus?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, [
            'card_id' => $cardId,
            'encrypt_code' => $encryptCode,
            'reimburse_status' => $reimburseStatus,
        ]);
    }

    /**
     * 批量更新发票状态
     * @access public
     * @param string $openid 用户openid
     * @param string $reimburseStatus 发票状态
     * @param array $invoiceList 发票列表
     * @return array
     */
    public function updateStatusBatch($openid, $reimburseStatus, array $invoiceList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/updatestatusbatch?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, [
            'openid' => $openid,
            'reimburse_status' => $reimburseStatus,
            'invoice_list' => $invoiceList,
        ]);
    }

    /**
     * 批量查询电子发票
     * @access public
     * @param array $itemList 发票列表
     * @return array
     */
    public function getInvoiceInfoBatch(array $itemList)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch?access_token=ACCESS_TOKEN';
        return $this->handler->callPostApi($url, [
            'item_list' => $itemList,
        ]);
    }
}