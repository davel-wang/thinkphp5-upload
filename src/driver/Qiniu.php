<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
namespace davel\thinkphp5\driver;

/**
 * 
 */
class Qiniu extends Driver
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

        $accessKey = $this->option['ak'];
        $secretKey = $this->option['sk'];
        $bucket =  $this->option['bucket'];
        $auth = new \Qiniu\Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucket);
        
        $file_info = $file->getInfo();
        $filePath = $file_info['tmp_name']; //上传的文件

        $key = $this->saveName = $path .'/'. hash_file('sha1', $filePath).$file_info['name'];

        $uploadMgr = new \Qiniu\Storage\UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            $this->error = '上传失败';
            return false;
        }
        return $this->getSaveName();
    }

    public function getSaveName() {
        return request()->scheme().'://'.$this->option['host'].'/'.$this->saveName;
    }
}