# laravel-upload

### 创建文件/application/extra/davel.php
```
<?php
// +------------------------------------------------------
// | Author: Davel <davel28@qq.com>
// +------------------------------------------------------
return [
    'driver' => 'File',
    'Aliyun' => [
        'id' => '',
        'key' => '',
        'endpoint' => '',
        'bucket' => '',
        'host' => '', //外网访问地址
    ],
    'Qiniu' => [
        'ak' => '',
        'sk' => '',
        'bucket' => '',
        'host' => '', //外网访问地址
    ],
];
```

### 使用
```

$file = $this->request->file('file');

$uploader = new \davel\thinkphp5\Uploader();
$savepath = $uploader->upload($file,'path','images');
if($savepath==false) {
    $error = $this->getError();
}

return $savepath;

```