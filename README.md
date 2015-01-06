AliyunOSS
====================

```
    ___     __    _                                    ____    _____   _____
   /   |   / /   (_)   __  __  __  __   ____          / __ \  / ___/  / ___/
  / /| |  / /   / /   / / / / / / / /  / __ \        / / / /  \__ \   \__ \ 
 / ___ | / /   / /   / /_/ / / /_/ /  / / / /       / /_/ /  ___/ /  ___/ / 
/_/  |_|/_/   /_/    \__, /  \__,_/  /_/ /_/        \____/  /____/  /____/  
                    /____/                                                  
```

阿里云 OSS 官方 SDK 的 Composer 封装，支持任何 PHP 项目，包括 Laravel、Symfony、TinyLara 等等。

###安装

将以下内容增加到 composer.json：

```json
require: {
    "johnlui/aliyunoss": "dev-master"
}
```

###使用

```php
use JohnLui\AliyunOSS\AliyunOSS;


// 构建 OSSClient 对象
// 三个参数：服务器地址、阿里云提供的AccessKeyId、AccessKeySecret
$oss = AliyunOSS::boot('http://oss-cn-qingdao.aliyuncs.com',  $AccessKeyId, $AccessKeySecret);

// 设置 Bucket
$oss->setBucket($bucketName);

// 上传一个文件（示例文件为 public 目录下的 robots.txt）
// 两个参数：资源名称、文件路径
$oss->uploadFile('robots.txt', public_path('robots.txt'));

// 从服务器获取这个资源的 URL 并打印
// 两个参数：资源名称、过期时间
echo $oss->getUrl('robots.txt', new DateTime("+1 day"));
```

###License

除 “版权所有 （C）阿里云计算有限公司” 的代码文件外，遵循 [MIT license](http://opensource.org/licenses/MIT) 开源。