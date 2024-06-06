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

namespace think\wechat\service\mini;

use think\wechat\Service;

/**
 * 微信小程序地址管理
 */
class Poi extends Service
{
    /**
     * 添加地点
     * @access public
     * @param string $related_name 经营资质主体
     * @param string $related_credential 经营资质证件号
     * @param string $related_address 经营资质地址
     * @param string $related_proof_material 相关证明材料照片临时素材mediaid
     * @return array
     */
    public function addBearByPoi($related_name, $related_credential, $related_address, $related_proof_material)
    {
        $url = 'https://api.weixin.qq.com/wxa/addnearbypoi?access_token=ACCESS_TOKEN';
        $data = [
            'related_name'    => $related_name, 'related_credential' => $related_credential,
            'related_address' => $related_address, 'related_proof_material' => $related_proof_material,
        ];
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查看地点列表
     * @access public
     * @param integer $page 起始页id（从1开始计数）
     * @param integer $page_rows 每页展示个数（最多1000个）
     * @return array
     */
    public function getNearByPoiList($page = 1, $page_rows = 1000)
    {
        $url = "https://api.weixin.qq.com/wxa/getnearbypoilist?page={$page}&page_rows={$page_rows}&access_token=ACCESS_TOKEN";
        return $this->platform->callGetApi($url);
    }

    /**
     * 删除地点
     * @access public
     * @param string $poi_id 附近地点ID
     * @return array
     */
    public function delNearByPoiList($poi_id)
    {
        $url = 'https://api.weixin.qq.com/wxa/delnearbypoi?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['poi_id' => $poi_id]);
    }

    /**
     * 展示/取消展示附近小程序
     * @access public
     * @param string $poi_id 附近地点ID
     * @param string $status 0：取消展示；1：展示
     * @return array
     */
    public function setNearByPoiShowStatus($poi_id, $status)
    {
        $url = 'https://api.weixin.qq.com/wxa/setnearbypoishowstatus?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['poi_id' => $poi_id, 'status' => $status]);
    }
}