<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
namespace davel\thinkphp5\driver;

/**
 * 
 */
class File extends Driver
{
    private function check($file,$type) {

    }

    public function upload($file,$dir,$type){
        $validate = $this->getValidateByType($type);
        $info = $file->validate($validate)->move(ROOT_PATH . 'public/uploads/'.$dir.'/');        
        if($info===false) {
            $this->error = $file->getError();
            return false;
        }

        $image_path =  $info->getSaveName();
        $image_path = str_replace('\\', '/', $image_path);
        $this->saveName = '/uploads/'.$dir.'/'.$image_path;

        return $this->getSaveName();
    }

    public function getSaveName() {
        return request()->doamin().$this->saveName;
    }
}