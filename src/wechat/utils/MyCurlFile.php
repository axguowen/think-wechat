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

namespace think\wechat\utils;

/**
 * 自定义CURL文件类
 */
class MyCurlFile extends \stdClass
{
    /**
     * 当前数据类型
     * @var string
     */
    public $datatype = 'MY_CURL_FILE';

    /**
     * 构造方法
     * @access public
     * @param string|array $filename
     * @param string $mimetype
     * @param string $postname
     * @return void
     */
    public function __construct($filename, $mimetype = '', $postname = '')
    {
        if (is_array($filename)) {
            foreach ($filename as $k => $v) $this->{$k} = $v;
        } else {
            $this->mimetype = $mimetype;
            $this->postname = $postname;
            $this->extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (empty($this->extension)) $this->extension = 'tmp';
            if (empty($this->mimetype)) $this->mimetype = Tools::getExtMine($this->extension);
            if (empty($this->postname)) $this->postname = pathinfo($filename, PATHINFO_BASENAME);
            $this->content = base64_encode(file_get_contents($filename));
            $this->tempname = md5($this->content) . ".{$this->extension}";
        }
    }

    /**
     * 获取文件上传信息
     * @access public
     * @return \CURLFile|string
     */
    public function get()
    {
        $this->filename = Tools::pushFile($this->tempname, base64_decode($this->content));
        if (class_exists('CURLFile')) {
            return new \CURLFile($this->filename, $this->mimetype, $this->postname);
        } else {
            return "@{$this->tempname};filename={$this->postname};type={$this->mimetype}";
        }
    }
}