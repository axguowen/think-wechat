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
 * 政民沟通服务
 */
class Report extends Service
{
    // +=======================
    // | 配置网格结构
    // +=======================
    /**
     * 添加网格
     * @access public
     * @param string $gridName 网格名称
     * @param string $gridParentId 父节点的id
     * @param string[] $gridAdmin 网格「负责人」userid列表
     * @param string[] $gridMember 该节点的成员userid列表
     * @return array
     */
    public function gridAdd($gridName, $gridParentId, array $gridAdmin, array $gridMember = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/add?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'grid_name' => $gridName,
            'grid_parent_id' => $gridParentId,
            'grid_admin' => $gridAdmin,
        ];
        // 指定了成员
        if(!empty($gridMember)){
            $data['grid_member'] = $gridMember;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 编辑网格
     * @access public
     * @param string $gridId 网格ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function gridUpdate($gridId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/update?access_token=ACCESS_TOK';
        $data['grid_id'] = $gridId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除网格
     * @access public
     * @param string $gridId 网格ID
     * @return array
     */
    public function gridDelete($gridId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/delete?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['grid_id' => $gridId]);
    }

    /**
     * 获取网格列表
     * @access public
     * @param string $gridId 网格ID
     * @return array
     */
    public function gridList($gridId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/list?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['grid_id' => $gridId]);
    }

    /**
     * 获取用户负责及参与的网格列表
     * @access public
     * @param string $userid 需要查询的成员userid
     * @return array
     */
    public function gridGetUserGridInfo($userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/get_user_grid_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid]);
    }

    // +=======================
    // | 配置事件类别
    // +=======================
    /**
     * 添加事件类别
     * @access public
     * @param string $categoryName 分类名称
     * @param int $level 分类层级, 只能传1或者2
     * @param string $parentCategoryId 所属的一级分类的id, level为2的话必传
     * @return array
     */
    public function gridAddCata($categoryName, $level = 1, $parentCategoryId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/add_cata?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'category_name' => $categoryName,
            'level' => $level,
        ];
        if(!empty($parentCategoryId)){
            $data['parent_category_id'] = $parentCategoryId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 修改事件类别
     * @access public
     * @param string $categoryId 类别ID
     * @param array $data 要更新的数据
     * @return array
     */
    public function gridUpdateCata($categoryId, array $data)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/update_cata?access_token=ACCESS_TOKEN';
        $data['category_id'] = $categoryId;
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除事件类别
     * @access public
     * @param string $categoryId 类别ID
     * @return array
     */
    public function gridDeleteCata($categoryId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/delete_cata?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['category_id' => $categoryId]);
    }

    /**
     * 获取事件类别列表
     * @access public
     * @return array
     */
    public function gridListCata()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/grid/list_cata?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }

    // +=======================
    // | 巡查上报
    // +=======================
    /**
     * 获取配置的网格及网格负责人
     * @access public
     * @return array
     */
    public function patrolGetGridInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/get_grid_info?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取单位巡查上报数据统计
     * @access public
     * @param string $gridId 网格ID
     * @return array
     */
    public function patrolGetCorpStatus($gridId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/get_corp_status?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        if(!empty($gridId)){
            $data['grid_id'] = $gridId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取个人巡查上报数据统计
     * @access public
     * @param string $userid 需要查询的成员userid
     * @return array
     */
    public function patrolGetUserStatus($userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/get_user_status?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid]);
    }

    /**
     * 获取上报事件分类统计
     * @access public
     * @param string $categoryId 类别ID
     * @return array
     */
    public function patrolCategoryStatistic($categoryId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/category_statistic?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['category_id' => $categoryId]);
    }

    /**
     * 获取巡查上报事件列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $beginCreateTime 指定事件之后新创建的上报
     * @param int $beginModifyTime 指定事件之后新修改的上报
     * @return array
     */
    public function patrolGetOrderList($limit = 20, $cursor = '', $beginCreateTime = 0, $beginModifyTime = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/get_order_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if ($beginCreateTime > 0) {
            $data['begin_create_time'] = $beginCreateTime;
        }
        if ($beginModifyTime > 0) {
            $data['begin_modify_time'] = $beginModifyTime;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取巡查上报的事件详情信息
     * @access public
     * @param string $orderId 类别ID
     * @return array
     */
    public function patrolGetOrderInfo($orderId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/patrol/get_order_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['order_id' => $orderId]);
    }

    // +=======================
    // | 居民上报
    // +=======================
    /**
     * 获取配置的网格及网格负责人
     * @access public
     * @return array
     */
    public function residentGetGridInfo()
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/get_grid_info?access_token=ACCESS_TOKEN';
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取单位居民上报数据统计
     * @access public
     * @param string $gridId 网格ID
     * @return array
     */
    public function residentGetCorpStatus($gridId = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/get_corp_status?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [];
        if(!empty($gridId)){
            $data['grid_id'] = $gridId;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取个人居民上报数据统计
     * @access public
     * @param string $userid 需要查询的成员userid
     * @return array
     */
    public function residentGetUserStatus($userid)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/get_user_status?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid]);
    }

    /**
     * 获取上报事件分类统计
     * @access public
     * @param string $categoryId 类别ID
     * @return array
     */
    public function residentCategoryStatistic($categoryId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/category_statistic?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['category_id' => $categoryId]);
    }

    /**
     * 获取居民上报事件列表
     * @access public
     * @param int $limit 拉取数量
     * @param string $cursor 上一次调用时返回的next_cursor
     * @param int $beginCreateTime 指定事件之后新创建的上报
     * @param int $beginModifyTime 指定事件之后新修改的上报
     * @return array
     */
    public function residentGetOrderList($limit = 20, $cursor = '', $beginCreateTime = 0, $beginModifyTime = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/get_order_list?access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'limit' => $limit,
        ];
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        if ($beginCreateTime > 0) {
            $data['begin_create_time'] = $beginCreateTime;
        }
        if ($beginModifyTime > 0) {
            $data['begin_modify_time'] = $beginModifyTime;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取居民上报的事件详情信息
     * @access public
     * @param string $orderId 类别ID
     * @return array
     */
    public function residentGetOrderInfo($orderId)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/report/resident/get_order_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['order_id' => $orderId]);
    }
}