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
 * 微信小程序数据接口
 */
class Total extends Service
{
    /**
     * 数据分析接口
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，限定查询1天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidDailySummarytrend($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailysummarytrend?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 访问分析
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，限定查询1天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidDailyVisittrend($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailyvisittrend?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 周趋势
     * @access public
     * @param string $beginDate 开始日期，为周一日期
     * @param string $endDate 结束日期，为周日日期，限定查询一周数据
     * @return array
     */
    public function getWeanalysisAppidWeeklyVisittrend($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidweeklyvisittrend?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 月趋势
     * @access public
     * @param string $beginDate 开始日期，为自然月第一天
     * @param string $endDate 结束日期，为自然月最后一天，限定查询一个月数据
     * @return array
     */
    public function getWeanalysisAppidMonthlyVisittrend($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyvisittrend?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 访问分布
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，限定查询1天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidVisitdistribution($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidvisitdistribution?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 日留存
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，限定查询1天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidDailyRetaininfo($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailyretaininfo?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 周留存
     * @access public
     * @param string $beginDate 开始日期，为周一日期
     * @param string $endDate 结束日期，为周日日期，限定查询一周数据
     * @return array
     */
    public function getWeanalysisAppidWeeklyRetaininfo($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidweeklyretaininfo?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 月留存
     * @access public
     * @param string $beginDate 开始日期，为自然月第一天
     * @param string $endDate 结束日期，为自然月最后一天，限定查询一个月数据
     * @return array
     */
    public function getWeanalysisAppidMonthlyRetaininfo($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyretaininfo?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 访问页面
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，限定查询1天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidVisitPage($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappidvisitpage?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }

    /**
     * 用户画像
     * @access public
     * @param string $beginDate 开始日期
     * @param string $endDate 结束日期，开始日期与结束日期相差的天数限定为0/6/29，分别表示查询最近1/7/30天数据，endDate允许设置的最大值为昨日
     * @return array
     */
    public function getWeanalysisAppidUserportrait($beginDate, $endDate)
    {
        $url = 'https://api.weixin.qq.com/datacube/getweanalysisappiduserportrait?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['begin_date' => $beginDate, 'end_date' => $endDate]);
    }
}