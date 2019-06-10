<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
namespace davel\thinkphp5\driver;

/**
 * 
 */
class Aliyun extends Driver
{
    protected function check($file,$type) {
        $validate = $this->getValidateByType($type);
        $flag = $file->check($validate);
        if($flag===false) {
            $this->error = $file->getError();
            return false;
        }
        return true;
    }

    public function upload($file,$path,$type){
        $flag = $this->check($file,$type);
        if(!$flag) return false;

        $accessKeyId = $this->option['id'];
        $accessKeySecret = $this->option['key'];
        $endpoint = $this->option['endpoint'];
        $bucket= $this->option['bucket'];

        $file_info = $file->getInfo();
        $filePath = $file_info['tmp_name'];
        $object = $this->saveName = $path .'/'. hash_file('sha1', $filePath).$file_info['name'];

        try{
            $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $result = $ossClient->uploadFile($bucket, $object, $filePath);
        } catch(\OSS\Core\OssException $e) {
            $this->error = '上传失败';
            return false;
        }

        return $this->getSaveName();
    }

    public function getSaveName() {
        return request()->scheme().'://'.$this->option['host'].'/'.$this->saveName;
    }
}