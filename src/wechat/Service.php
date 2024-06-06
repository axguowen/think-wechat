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

namespace think\wechat;

/**
 * 服务基础类
 */
abstract class Service
{
	/**
     * 当前所属平台
     * @var Platform
     */
	protected $platform;

    /**
     * 架构函数
     * @access public
     * @param Platform $platform 当前所属平台
     * @return void
     */
    public function __construct(Platform $platform)
    {
        // 当前所属平台
        $this->platform = $platform;
    }
}
