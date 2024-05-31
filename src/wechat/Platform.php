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

use think\App;
use think\facade\Cache;
use think\helper\Str;
use think\wechat\utils\HttpClient;
use think\wechat\utils\Tools;
use think\wechat\exception\InvalidResponseException;
use think\wechat\exception\InvalidArgumentException;

/**
 * 平台抽象类
 */
abstract class Platform
{
	/**
     * 应用容器实例对象
     * @var App
     */
	protected $app;

	/**
     * 平台配置参数
     * @var array
     */
	protected $options = [];

    /**
     * 容器中的服务实例
     * @var array
     */
    protected $services = [];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = null;

    /**
     * 接口调用凭证
     * @var string
     */
    protected $accessToken = '';

    /**
     * 接口调用凭证缓存获取器
     * @var string|array
     */
    protected $accessTokenGetter = Cache::class . '::get';

    /**
     * 接口调用凭证缓存修改器
     * @var string|array
     */
    protected $accessTokenSetter = Cache::class . '::set';

    /**
     * 接口调用凭证是否无效
     * @var bool
     */
    protected $accessTokenInvalid = false;

    /**
     * 调用接口返回凭证无效的错误码
     * @var array
     */
    protected $accessTokenInvalidCode = [
        '40014',
        '40001',
        '41001',
        '42001',
    ];

    /**
     * 架构函数
     * @access public
     * @param App $app 应用容器
     * @param array $options 平台配置参数
     * @return void
     */
    public function __construct(App $app, array $options = [])
    {
        // 设置应用容器实例
        $this->app = $app;
        // 合并配置参数
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        // 初始化
        $this->init();
    }

	/**
     * 动态设置平台配置参数
     * @access public
     * @param array $options 平台配置
     * @return $this
     */
    public function setConfig(array $options)
    {
        // 合并配置
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        // 返回
        return $this->init();
    }

	/**
     * 初始化
     * @access protected
     * @return $this
     */
    protected function init()
    {
        // 初始化缓存器
        $this->initAccessTokenCacheHandler();
        // 如果配置了接口调用凭证
        if (isset($this->options['access_token']) && !empty($this->options['access_token'])) {
            // 设置接口调用凭证
            $this->accessToken = $this->options['access_token'];
        }
        // 如果配置了接口调用凭证错误码
        if (isset($this->options['access_token_invalid_code']) && !empty($this->options['access_token_invalid_code'])) {
            // 设置接口调用凭证错误码
            $this->accessTokenInvalidCode = $this->options['access_token_invalid_code'];
        }
        // 返回
        return $this;
    }

	/**
     * 初始化接口调用凭证缓存器
     * @access protected
     * @return void
     */
    protected function initAccessTokenCacheHandler()
    {
        // 设置默认接口调用凭证缓存获取器
        $this->accessTokenGetter = Cache::class . '::get';
        // 设置默认接口调用凭证缓存修改器
        $this->accessTokenSetter = Cache::class . '::set';
        
        // 如果配置了接口调用凭证缓存获取器
        if (isset($this->options['access_token_getter']) && !empty($this->options['access_token_getter'])) {
            // 设置接口调用凭证缓存获取器
            $this->accessTokenGetter = $this->options['access_token_getter'];
        }
        // 如果配置了接口调用凭证缓存修改器
        if (isset($this->options['access_token_setter']) && !empty($this->options['access_token_setter'])) {
            // 设置接口调用凭证缓存修改器
            $this->accessTokenSetter = $this->options['access_token_setter'];
        }
    }

    /**
     * 获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessToken()
    {
        // 当前已存在
        if (!empty($this->accessToken)) {
            return [$this->accessToken, null];
        }
        // 从缓存获取
        $this->accessToken = $this->getAccessTokenCache();
        // 缓存存在
        if (!empty($this->accessToken)) {
            return [$this->accessToken, null];
        }
        // 在线获取
        $getAccessTokenResult = $this->getAccessTokenOnline();
        // 失败
        if(is_null($getAccessTokenResult[0])){
            return $getAccessTokenResult;
        }
        // 获取缓存数据
        $accessTokenData = $getAccessTokenResult[0];
        // 更新当前凭证
        $this->updateAccessToken($accessTokenData['access_token'], $accessTokenData['expires_in']);
        // 返回
        return [$this->accessToken, null];
    }

    /**
     * 获取接口调用凭证缓存
     * @access protected
     * @return string
     */
    protected function getAccessTokenCache()
    {
        // 如果是接口调用凭证已经无效
        if ($this->accessTokenInvalid) {
            return null;
        }
        // 获取缓存键名
        $cacheKey = $this->getAccessCacheKey();
        // 返回
        return call_user_func_array($this->accessTokenGetter, [$cacheKey]);
    }

    /**
     * 更新当前接口调用凭证
     * @access public
     * @param string $accessToken
     * @param int $expiresIn
     * @return bool
     */
    public function updateAccessToken(string $accessToken, int $expiresIn)
    {
        // 设置调用凭证
        $this->accessToken = $accessToken;
        // 获取缓存键名
        $cacheKey = $this->getAccessCacheKey();
        // 返回
        return call_user_func_array($this->accessTokenSetter, [$cacheKey, $accessToken, $expiresIn]);
    }

    /**
     * 设置接口调用凭证缓存无效
     * @access protected
     * @return void
     */
    protected function invalidAccessToken()
    {
        // 清空当前调用凭证
        $this->accessToken = '';
        // 设置无效状态
        $this->accessTokenInvalid = true;
    }

    /**
     * 接口通用GET请求方法
     * @access public
     * @param string $url 接口URL
     * @param array $query GET参数
     * @param array $headers 请求头
     * @param array $options 其它参数
     * @return array
     */
    public function callGetApi($url, array $query = [], array $headers = [], array $options = [])
    {
        // 获取接口调用凭证
        $getAccessTokenResult = $this->getAccessToken();
        // 获取接口调用凭证失败
        if(is_null($getAccessTokenResult[0])){
            return $getAccessTokenResult;
        }
        $accessToken = $getAccessTokenResult[0];
        // 替换URL中的参数
        $requestUrl = str_replace('=ACCESS_TOKEN', '=' . urlencode($accessToken), $url);
        // 获取请求结果
        $response = HttpClient::get($requestUrl, $query, $headers, $options);
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseDataResult[0])){
            // 如果接口调用凭证未标记为无效，且返回码为凭证无效则重试一次
            if(false === $this->accessTokenInvalid && in_array($parseResponseDataResult[1]->getCode(), $this->accessTokenInvalidCode)){
                // 标记调用凭证无效
                $this->invalidAccessToken();
                // 重试一次
                return $this->callGetApi($url, $query, $headers, $options);
            }
        }
        // 请求成功且当前当前调用凭证标记的是无效
        if(false !== $this->accessTokenInvalid){
            $this->accessTokenInvalid = false;
        }
        // 返回
        return $parseResponseDataResult;
    }

    /**
     * 接口通用POST请求方法
     * @access public
     * @param string $url 接口URL
     * @param array $data POST提交接口参数
     * @param array $headers 请求头
     * @param array $options 请求扩展数据
     * @param bool $toJson 是否转换为JSON参数
     * @return array
     */
    public function callPostApi($url, array $data = [], array $headers = [], array $options = [], $toJson = true)
    {
        // 获取接口调用凭证
        $getAccessTokenResult = $this->getAccessToken();
        // 获取接口调用凭证失败
        if(is_null($getAccessTokenResult[0])){
            return $getAccessTokenResult;
        }
        $accessToken = $getAccessTokenResult[0];
        // 替换URL中的参数
        $requestUrl = str_replace('=ACCESS_TOKEN', '=' . urlencode($accessToken), $url);
        // 请求体
        $body = $data;
        // 请求头
        $head = $headers;
        // json请求
        if ($toJson){
            $head['Content-Type'] = 'application/json';
            $body = Tools::arr2json($body);
        }
        // 获取请求结果
        $response = HttpClient::post($requestUrl, $body, $head, $options);
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseDataResult[0])){
            // 如果接口调用凭证未标记为无效，且返回码为凭证无效则重试一次
            if(false === $this->accessTokenInvalid && in_array($parseResponseDataResult[1]->getCode(), $this->accessTokenInvalidCode)){
                // 标记调用凭证无效
                $this->invalidAccessToken();
                // 重试一次
                return $this->callPostApi($url, $data, $headers, $options, $toJson);
            }
        }
        // 请求成功且当前当前调用凭证标记的是无效
        if(false !== $this->accessTokenInvalid){
            $this->accessTokenInvalid = false;
        }
        // 返回
        return $parseResponseDataResult;
    }

    /**
     * 解析接口响应数据
     * @access protected
     * @param string $response
     * @return array
     */
    protected function parseResponseData($response)
    {
        // 默认数据
        $data = [];

        try{
            // 获取转换结果
            $data = Tools::json2arr($response);
        } catch (\Exception $e) {
            return [null, $e];
        }

        // 响应数据为空
        if (empty($data)) {
            return [null, new InvalidResponseException('empty response.', '0', $data)];
        }
        // 存在错误码
        if (!empty($data['errcode'])) {
            return [null, new InvalidResponseException($data['errmsg'], $data['errcode'], $data)];
        }

        // 返回结果
        return [$data, null];
    }

    /**
     * 获取服务实例
     * @access public
     * @param string $name
     * @return mixed
     */
    public function service(string $name)
    {
        // 为空
        if (empty($name)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to resolve empty service for [%s].',
                static::class
            ));
        }

        // 如果服务已经存在
        if(isset($this->services[$name])){
            // 直接返回
            return $this->services[$name];
        }
        // 创建了再返回
        return $this->services[$name] = $this->createService($name);
    }

    /**
     * 创建服务
     * @access protected
     * @param string $name
     * @return mixed
     */
    protected function createService(string $name)
    {
        // 如果命名空间为空且服务名称不带命名空间
        if (empty($this->serviceNamespace) && false === strpos($name, '\\')) {
            throw new InvalidArgumentException("Service [$name] not supported.");
        }
        // 获取服务类名
        $class = false !== strpos($name, '\\') ? $name : $this->serviceNamespace . Str::studly($name);
        // 服务类不存在
        if (!class_exists($class)) {
            throw new InvalidArgumentException("Service [$name] class not exists.");
        }
        // 实例化服务
        return $this->app->invokeClass($class, [$this]);
    }

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    abstract protected function getAccessCacheKey();

    /**
     * 在线获取接口调用凭证
     * @access protected
     * @return array
     */
    abstract protected function getAccessTokenOnline();
}