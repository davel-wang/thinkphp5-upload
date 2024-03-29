<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
namespace davel\thinkphp5;

/**
 * 上传类
 */
class Uploader
{
    protected $handler = null;
    public function __construct()
    {
        if(is_null($this->handler)) {
            $config = config('davel.upload');
            if(!$config || empty($config['driver'])) $config =['driver'=>'File','File'=>[],'validate'=>[]];

            $class = '\\davel\\thinkphp5\\driver\\'.$config['driver'];
            $this->handler = new $class;
            $this->handler->setOption(array_merge($config[$config['driver']],$config['validate']));
        }
    }

    public function upload($file,$dir,$type='image'){
        $file = $file->rule('sha1');
        return $this->handler->upload($file,$dir,$type);
    }

    public function getSaveName(){
        return $this->handler->getSaveName();
    }

    public function getError() {
        return $this->handler->getError();
    }
}