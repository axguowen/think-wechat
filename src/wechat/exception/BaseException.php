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

namespace think\wechat\exception;

/**
 * 接口异常基础类
 */
class BaseException extends \InvalidArgumentException
{
    /**
     * @var array
     */
    public $raw = [];

    /**
     * 构造方法
     * @access public
     * @param string $message
     * @param integer $code
     * @param array $raw
     * @return void
     */
    public function __construct($message, $code = 0, $raw = [])
    {
        parent::__construct($message, intval($code));
        $this->raw = $raw;
    }
}