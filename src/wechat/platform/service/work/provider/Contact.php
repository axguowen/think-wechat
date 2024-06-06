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

namespace think\wechat\platform\service\work\provider;

use think\wechat\platform\service\Service;

/**
 * 企业微信服务商通讯录管理服务
 */
class Contact extends Service
{
    /**
     * 通讯录单个搜索
     * @access public
     * @param string $authCorpid 授权方企业corpid
     * @param string $queryWord 搜索关键词
     * @param int $limit 查询返回的最大数量
     * @param string $cursor 用于分页查询的游标
     * @param int $queryType 查询类型: 1查询用户返回用户userid列表; 2查询部门返回部门id列表
     * @param int $queryRange 查询范围, 仅查询类型包含用户时有效 0只查询在职用户 1同时查询在职和离职用户
     * @param int $agentid 应用id, 若非0则只返回应用可见范围内的用户或者部门信息
     * @param int $fullMatchField 精确匹配的字段: 1匹配用户名称或者部门名称 2匹配用户英文名, 不填则为模糊匹配
     * @return array
     */
    public function search($authCorpid, $queryWord, $limit = 50, $cursor = '', $queryType = 1, $queryRange = 0, $agentid = 0, $fullMatchField = 0)
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/contact/search?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'auth_corpid' => $authCorpid,
            'query_word' => $queryWord,
            'limit' => $limit,
            'query_type' => $queryType,
            'query_range' => $queryRange,
            'agentid' => $agentid,
        ];
        // 指定游标
        if (!empty($cursor)) {
            $data['cursor'] = $cursor;
        }
        // 指定应用id
        if ($fullMatchField > 0) {
            $data['full_match_field'] = $fullMatchField;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 异步通讯录id转译
     * @access public
     * @param string $authCorpid 授权方企业corpid
     * @param array $mediaIdList 需要转译的文件的media_id列表, 只支持后缀名为xls/xlsx、doc/docx、csv、txt的文件
     * @param string $outputFileName 转译完打包的文件名, 不需带后缀
     * @param string $outputFileFormat 转译完打包的文件后缀, 若不指定, 则输出格式跟输入格式相同
     * @return array
     */
    public function idTranslate($authCorpid, array $mediaIdList, $outputFileName = '', $outputFileFormat = '')
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/contact/id_translate?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'auth_corpid' => $authCorpid,
            'media_id_list' => $mediaIdList,
        ];
        // 指定文件名
        if (!empty($outputFileName)) {
            $data['output_file_name'] = $outputFileName;
        }
        // 指定后缀
        if (!empty($outputFileFormat)) {
            $data['output_file_format'] = $outputFileFormat;
        }
        return $this->platform->callPostApi($url, $data);
    }

    /**
     * 获取异步任务结果
     * @access public
     * @param string $jobid 异步任务id
     * @return array
     */
    public function getResult($jobid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/batch/getresult?provider_access_token=ACCESS_TOKEN&jobid={$jobid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 通讯录userid排序
     * @access public
     * @param string $authCorpid 授权方企业corpid
     * @param array $useridList 要排序的userid列表
     * @param array $sortOptions 排序选项列表
     * @return array
     */
    public function sort($authCorpid, array $useridList, array $sortOptions = [])
    {
        // 请求地址
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/contact/sort?provider_access_token=ACCESS_TOKEN';
        // 请求参数
        $data = [
            'auth_corpid' => $authCorpid,
            'useridlist' => $useridList,
        ];
        // 指定排序选项
        if (!empty($sortOptions)) {
            $data['sort_options'] = $sortOptions;
        }
        return $this->platform->callPostApi($url, $data);
    }
}