<?php
namespace app\index\model;

use think\Model;

class Common extends Model
{
    protected $app_id, $app_key, $master_key, $baas_url, $header, $master_header;

    protected function initialize()
    {
        parent::initialize();

        //对应区分测试环境和正式环境的app id和key
        if (defined('FLYME_ENV')  && (FLYME_ENV=='dev' || FLYME_ENV=='test')) {
            $this->app_id     = config('TEST_BAAS_APP_ID');
            $this->app_key    = config('TEST_BAAS_APP_KEY');
            $this->master_key = config('TEST_BAAS_MASTER_KEY');
            $this->baas_url   = config('BAAS_URL');
        } else {
            $this->app_id     = config('BAAS_APP_ID');
            $this->app_key    = config('BAAS_APP_KEY');
            $this->master_key = config('BAAS_MASTER_KEY');
            $this->baas_url   = config('BAAS_URL');
        }

        //身份验证参数
        $timestamp           = getTimestamp(13);
        $this->header        = [
            'MZ-AppId:'.$this->app_id,
            'MZ-Sign:'.md5($timestamp.$this->app_key).','.$timestamp,
        ];
        $this->master_header = [
            'MZ-AppId:'.$this->app_id,
            'MZ-Sign:'.md5($timestamp.$this->master_key).','.$timestamp.',master',
        ];
    }

    //只在第一次初始化时执行，即new的时候，先于其它方法执行
    protected static function init()
    {
    }

    /**
     * 使用put的更新方式请求Baas
     * @param $table_url  要更新的表名和id ，例： test/23  ,更新test表中id为23的记录
     * @param string $data 要更新的数据，json格式或是数组
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @return mixed|string
     */
    public function update_put_baas($table_url, $data = '', $headers = [], $data_type = 'decode')
    {
        $headers = array_merge($this->header, $headers);

        $rs = curlContents($this->baas_url.$table_url, $data, $headers, 'PUT', $data_type);

        if ($rs['code'] == 000000) {
            return $rs['data']['_id'];
            //return true;
        } else {
            return false;
        }
    }

    /**
     * 使用put和master KEY的批量更新方式请求Baas
     * @param $table_url  要更新的表名和id ，例： test/23  ,更新test表中id为23的记录
     * @param string $data 要更新的数据，json格式或是数组
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @return mixed|string
     */
    public function update_batch_put_baas($table_url, $data = '', $headers = [], $data_type = 'decode')
    {
        $headers = array_merge($this->master_header, $headers);

        $rs = curlContents($this->baas_url.$table_url, $data, $headers, 'PUT', $data_type);

        if ($rs['code'] == 000000) {
            return $rs['data']['objectIds'];
            //return true;
        } else {
            return false;
        }
    }

    /**
     * 使用DELETE的删除方式请求Baas
     * @param $table_url  要删除的表名和id ，例： test/23  ,删除test表中id为23的记录
     * @param string $data 数据，json格式或是数组
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @return mixed|string
     */
    public function delete_baas($table_url, $data = '', $headers = [], $data_type = 'decode')
    {
        $headers = array_merge($this->header, $headers);

        $rs = curlContents($this->baas_url.$table_url, $data, $headers, 'DELETE', $data_type);

        if ($rs['code'] == 000000) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 使用DELETE和master KEY 批量删除方式请求Baas
     * @param $table_url  要删除的表名和id ，例： test?objectIds=2,3  ,删除test表中id为2和为3的记录
     * @param string $data 数据，json格式或是数组
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @return mixed|string
     */
    public function delete_batch_baas($table_url, $data = '', $headers = [], $data_type = 'decode')
    {
        $headers = array_merge($this->master_header, $headers);

        $rs = curlContents($this->baas_url.$table_url, $data, $headers, 'DELETE', $data_type);

        if ($rs['code'] == 000000) {
            //return $rs['data']['_ids'];
            return true;
        } else {
            //return $rs['message'];
            return false;
        }
    }

    /**
     * 使用post的方式请求Baas
     * @param $table_url  要新增的表名 ，例： test/
     * @param string $data 数据，json格式或是数组
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @return mixed|string
     */
    public function add_post_baas($table_url, $data = '', $headers = [], $data_type = 'decode')
    {
        $headers = array_merge($this->header, $headers);

        $rs = curlContents($this->baas_url.$table_url, $data, $headers, 'POST', $data_type);

        if ($rs['code'] == 000000) {
            return $rs['data']['_id'];
        } else {
            return false;
        }
    }

    /**
     * 使用POST方式来上传图片
     * @param $files_obj  表单文件对象
     * @param array $headers
     * @return bool
     */
    public function upload_image_baas($files_obj,$headers = [])
    {
        $upload_img_url = config('BAAS_UPLOAD_IMAGE_URL');

        $headers = array_merge($this->master_header, $headers);//只能用master key来绕过所谓的用户登录验证

        $rs = curlUpload($upload_img_url, $files_obj, $headers, 'decode');

        if ($rs['code'] == 000000) {
            return $rs['data']['images'][0];
        } else {
            return false;
        }
    }

    /**
     * 使用POST方式上传文件
     * @param $files_obj 表单文件对象
     * @param array $headers
     * @return bool
     */
    public function upload_file_baas($files_obj,$headers = [])
    {
        $upload_img_url = config('BAAS_UPLOAD_FILES_URL');

        $headers = array_merge($this->master_header, $headers);//只能用master key来绕过所谓的用户登录验证

        $rs = curlUpload($upload_img_url, $files_obj, $headers, 'decode');

        if ($rs['code'] == 000000) {
            return $rs['data']['files'][0];
        } else {
            return false;
        }
    }

    /**
     * 使用get的方式请求Baas
     * @param $table_url  要获取的表名和id ，例： test/23  ,获取test表中id为23的记录
     * @param array $headers 对应要新加的header
     * @param string $data_type 对应返回数据的格式，如果不填则默认返回请求回来的，如果写 encode则返回回来会先json_encode好,decode则是json_decode好
     * @param bool $is_return_count 是否返回总条数
     * @return mixed|string
     */
    public function get_baas($table_url, $headers = [],$is_return_count=false, $data_type = 'decode')
    {
        $headers = array_merge($this->header, $headers);

        $query_rs = curlContents($this->baas_url.$table_url, '', $headers, 'GET', $data_type);

        if ($query_rs['code'] == 000000) {
            $rs = [];
            if($is_return_count){
                if(isset($query_rs['data']['values'])){
                    $rs['data'] = $query_rs['data']['values'];
                }
                $rs['count'] = $query_rs['extra']['count'];
            }else{
                if(isset($query_rs['data']['values'])){
                    $rs = $query_rs['data']['values'];
                }else{
                    $rs = $query_rs['data'];
                }
            }
            return $rs;
        } else {
            return false;
        }
    }
}