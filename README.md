# laravel-upload

### 创建文件/application/extra/davel.php
```
<?php
return [
    'upload' => [
        'driver' => 'File',
        'validate' => [
            'image' => ['size'=>6048000,'ext'=>'jpg,png,gif,jpeg'],
            'file' => ['size'=>6048000,'ext'=>'zip']
        ],
        'Aliyun' => [
            'id' => '',
            'key' => '',
            'endpoint' => '',
            'bucket' => '',
            'host' => '', //外网地址
        ],
        'Qiniu' => [
            'ak' => '',
            'sk' => '',
            'bucket' => '',
            'host' => '', //外网地址
        ],
        'File' => [
            
        ],
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