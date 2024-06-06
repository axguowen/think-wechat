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

namespace think\wechat\platform;

use think\facade\Cache;
use think\wechat\Platform;
use think\wechat\utils\HttpClient;
use think\wechat\exception\LocalCacheException;

/**
 * 微信开放平台
 */
class Open extends Platform
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 应用ID
        'appid' => '',
        // 应用密钥
        'appsecret' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\open\\';

    /**
     * 刷新Token
     * @var string
     */
    protected $refreshToken = '';

    /**
     * 刷新Token缓存获取器
     * @var string|array
     */
    protected $accessTokenGetter = Cache::class . '::get';

    /**
     * 刷新Token缓存修改器
     * @var string|array
     */
    protected $accessTokenSetter = Cache::class . '::set';

	/**
     * 初始化缓存器
     * @access protected
     * @return void
     */
    protected function initCacheHandler()
    {
        // 调用父类方法
        parent::initCacheHandler();
        // 设置刷新Token缓存获取器
        $this->refreshTokenGetter = Cache::class . '::get';
        // 设置刷新Token缓存修改器
        $this->refreshTokenSetter = Cache::class . '::set';
        
        // 如果配置了刷新Token
        if (isset($this->options['refresh_token']) && !empty($this->options['refresh_token'])) {
            // 设置刷新Token
            $this->refreshToken = $this->options['refresh_token'];
        }
        // 如果配置了刷新Token缓存获取器
        if (isset($this->options['refresh_token_getter']) && !empty($this->options['refresh_token_getter'])) {
            // 设置刷新Token缓存获取器
            $this->refreshTokenGetter = $this->options['refresh_token_getter'];
        }
        // 如果配置了刷新Token缓存修改器
        if (isset($this->options['refresh_token_setter']) && !empty($this->options['refresh_token_setter'])) {
            // 设置刷新Token缓存修改器
            $this->refreshTokenSetter = $this->options['refresh_token_setter'];
        }
    }

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'open_access_token_' . $this->options['appid'];
    }

    /**
     * 获取刷新接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getRefreshCacheKey()
    {
        return 'open_refresh_token_' . $this->options['appid'];
    }

    /**
     * 在线获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 接口请求地址
        $requestUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';
        // 获取刷新token
        $getRefreshTokenResult = $this->getRefreshToken();
        // 获取失败
        if(empty($getRefreshTokenResult[0])){
            return $getRefreshTokenResult;
        }
        // 参数
        $query = [
            'grant_type' => 'refresh_token',
            'appid' => $this->options['appid'],
            'refresh_token' => $getRefreshTokenResult[0],
        ];
        // 获取请求结果
        $response = HttpClient::get($requestUrl, $query);
        // 获取解析结果
        return $this->parseResponseData($response);
    }

    /**
     * 获取刷新Token
     * @access protected
     * @return array
     */
    protected function getRefreshToken()
    {
        // 当前已存在
        if (!empty($this->refreshToken)) {
            return [$this->refreshToken, null];
        }
        // 从缓存获取
        $this->refreshToken = $this->getRefreshTokenCache();
        // 缓存存在
        if (!empty($this->refreshToken)) {
            return [$this->refreshToken, null];
        }
        // 返回
        return [null, new LocalCacheException('refresh_token is empty')];
    }

    /**
     * 获取刷新token缓存
     * @access protected
     * @return string
     */
    protected function getRefreshTokenCache()
    {
        // 获取缓存键名
        $cacheKey = $this->getRefreshCacheKey();
        // 返回
        return call_user_func_array($this->refreshTokenGetter, [$cacheKey]);
    }

    /**
     * 更新当前接口调用凭证
     * @access public
     * @param array $data
     * @return $this
     */
    public function updateAccessToken(array $data = [])
    {
        // 调用凭证
        $accessToken = '';
        if(!empty($data['access_token'])){
            $accessToken = $data['access_token'];
        }
        
        // 到期时间
        $expiresIn = 0;
        if(!empty($data['expires_in'])){
            // 设置调用凭证
            $expiresIn = $data['expires_in'];
        }
        
        // 刷新Token
        $refreshToken = '';
        if(!empty($data['refresh_token'])){
            // 设置调用凭证
            $refreshToken = $data['refresh_token'];
        }
        // 获取缓存键名
        $cacheKey = $this->getAccessCacheKey();
        // 获取缓存键名
        $refreshKey = $this->getRefreshCacheKey();
        // 设置调用凭证
        $this->accessToken = $accessToken;
        // 设置刷新Token
        $this->refreshToken = $refreshToken;
        // 调用缓存修改器方法
        call_user_func_array($this->accessTokenSetter, [$cacheKey, $accessToken, $expiresIn]);
        // 刷新token缓存修改器方法
        call_user_func_array($this->refreshTokenSetter, [$refreshKey, $refreshToken, 86400 * 30]);
        // 返回
        return $this;
    }
}