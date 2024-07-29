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

use think\wechat\contract\HandlerInterface;

/**
 * 服务基础类
 */
abstract class Service
{
	/**
     * 当前所属平台驱动句柄
     * @var HandlerInterface
     */
	protected $handler;

    /**
     * 架构函数
     * @access public
     * @param HandlerInterface $handler 当前所属平台驱动句柄
     * @return void
     */
    public function __construct(HandlerInterface $handler)
    {
        // 当前所属平台驱动句柄
        $this->handler = $handler;
        // 初始化
        $this->init();
    }

	/**
     * 初始化
     * @access protected
     * @return void
     */
    protected function init()
    {
    }
}
