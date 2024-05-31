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

namespace think\wechat\platform\service\mini;

/**
 * 小程序导购助手
 */
class Guide extends Base
{
    /**
     * 服务号添加导购
     * @access public
     * @param array $data
     * @return array
     */
    public function addGuideAcct($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/addguideacct?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 服务号删除导购
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideAcct($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguideacct?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 服务号获取导购信息
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideAcct($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideacct?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取服务号的敏感词信息与自动回复信息
     * @access public
     * @return array
     */
    public function getGuideAcctConfig()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideacctconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }

    /**
     * 服务号拉取导购列表
     * @access public
     * @param integer $page
     * @param integer $num
     * @return array
     */
    public function getGuideAcctList($page = 0, $num = 10)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideacctconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['page' => $page, 'num' => $num]);
    }

    /**
     * 获取导购聊天记录
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideBuyerChatRecord($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideacct?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取导购快捷回复信息
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideConfig($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 生成导购二维码
     * @access public
     * @param array $data
     * @return array
     */
    public function guideCreateQrCode($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/guidecreateqrcode?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 推送菜单
     * @access public
     * @param array $data
     * @return array
     */
    public function pushShowWxaPathMenu($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/pushshowwxapathmenu?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为服务号设置敏感词与自动回复
     * @access public
     * @param array $data
     * @return array
     */
    public function setGuideAcctConfig($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguideacctconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 设置导购快捷回复信息
     * @access public
     * @param array $data
     * @return array
     */
    public function setGuideConfig($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguideconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新导购昵称或者头像
     * @access public
     * @param array $data
     * @return array
     */
    public function updateGuideAcct($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguideconfig?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加展示标签信息
     * @access public
     * @param array $data
     * @return array
     */
    public function addGuideBuyerDisplayTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/addguidebuyerdisplaytag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为粉丝添加可查询标签
     * @access public
     * @param array $data
     * @return array
     */
    public function addGuideBuyerTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/addguidebuyertag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加标签可选值
     * @access public
     * @param array $data
     * @return array
     */
    public function addGuideTagOption($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/addguidetagoption?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除粉丝标签
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideBuyerTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguidebuyertag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询展示标签信息
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideBuyerDisplayTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidebuyerdisplaytag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询粉丝标签
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideBuyerTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidebuyertag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询标签可选值信息
     * @access public
     * @return array
     */
    public function getGuideTagOption()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidetagoption?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url);
    }

    /**
     * 新建可查询标签类型,支持新建4类可查询标签
     * @access public
     * @param array $data
     * @return array
     */
    public function newGuideTagOption($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/newguidetagoption?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 根据标签值筛选粉丝
     * @access public
     * @param array $data
     * @return array
     */
    public function queryGuideBuyerByTag($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/queryguidebuyerbytag?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为服务号导购添加粉丝
     * @access public
     * @param array $data
     * @return array
     */
    public function addGuideBuyerRelation($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/addguidebuyerrelation?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除导购的粉丝
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideBuyerRelation($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguidebuyerrelation?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 查询某一个粉丝与导购的绑定关系
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideBuyerRelation($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidebuyerrelation?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 通过粉丝信息查询该粉丝与导购的绑定关系
     * @access public
     * @param string $openid
     * @return array
     */
    public function getGuideBuyerRelationByBuyer($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidebuyerrelation?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['openid' => $openid]);
    }

    /**
     * 拉取导购的粉丝列表
     * @access public
     * @param array $data
     * @return array
     */
    public function getGuideBuyerRelationList($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidebuyerrelationlist?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 将粉丝从一个导购迁移到另外一个导购下
     * @access public
     * @param array $data
     * @return array
     */
    public function rebindGuideAcctForBuyer($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/rebindguideacctforbuyer?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 更新粉丝昵称
     * @access public
     * @param array $data
     * @return array
     */
    public function updateGuideBuyerRelation($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/updateguidebuyerrelation?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除小程序卡片素材
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideCardMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguidecardmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除图片素材
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideImageMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguideimagematerial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 删除文字素材
     * @access public
     * @param array $data
     * @return array
     */
    public function delGuideWordMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/delguidewordmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取小程序卡片素材信息
     * @access public
     * @param integer $type
     * @return array
     */
    public function getGuideCardMaterial($type = 0)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidecardmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['type' => $type]);
    }

    /**
     * 获取图片素材信息
     * @access public
     * @param integer $type 操作类型
     * @param integer $start 分页查询，起始位置
     * @param integer $num 分页查询，查询个数
     * @return array
     */
    public function getGuideImageMaterial($type = 0, $start = 0, $num = 10)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguideimagematerial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['type' => $type, 'start' => $start, 'num' => $num]);
    }

    /**
     * 获取文字素材信息
     * @access public
     * @param integer $type 操作类型
     * @param integer $start 分页查询，起始位置
     * @param integer $num 分页查询，查询个数
     * @return array
     */
    public function getGuideWordMaterial($type = 0, $start = 0, $num = 10)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/getguidewordmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['type' => $type, 'start' => $start, 'num' => $num]);
    }

    /**
     * 添加小程序卡片素材
     * @access public
     * @param array $data
     * @return array
     */
    public function setGuideCardMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguidecardmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 添加图片素材
     * @access public
     * @param array $data
     * @return array
     */
    public function setGuideImageMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguideimagematerial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 为服务号添加文字素材
     * @access public
     * @param array $data
     * @return array
     */
    public function setGuideWordMaterial($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/guide/setguidewordmaterial?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, $data);
    }
}