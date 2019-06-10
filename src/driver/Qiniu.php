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
    private function check($file,$type) {
        $validate = $this->getValidateByType($type);
        $flag = $file->check($validate);        
        if($info===false) {
            $this->error = $file->getError();
            return false;
        }
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

        $path = rtrim($path, DS) . DS;
        $saveName = $this->buildSaveName(true);
        $key = $this->saveName = $path . $saveName;

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