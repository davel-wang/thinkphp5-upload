<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
namespace davel\thinkphp5\driver;

/**
 * 
 */
abstract class Driver
{
    protected $option = [];
    protected $saveName = '';
    protected $error = '';

    abstract protected function check($file,$type);
    abstract public function upload($file,$dir,$type);
    abstract protected function getSaveName();

    public function getError(){
        return $this->error;
    }

    public function setOption($option) {
        $this->option = $option;
    }

    protected function getValidateByType($type) {
        $config = isset($this->option[$type]) ? $this->option[$type] : [];
        if(empty($config)) {
            return ['size'=>6048000,'ext'=>'jpg,png,gif,jpeg'];
        } else {
            return ['size' => $config['size'],'ext'=> $config['ext']];
        }
    }
}