<?php namespace App\Services;

include __DIR__.'/vendor/autoload.php';

use JohnLui\AliyunOSS\AliyunOSS;
use Config;

class OSS {

  private $ossClient;

  public function __construct($isInternal = false)
  {
    $serverAddress = $isInternal ? Config::get('app.ossServerInternal') : Config::get('app.ossServer');
    $this->ossClient = AliyunOSS::boot(
      $serverAddress,
      Config::get('app.AccessKeyId'),
      Config::get('app.AccessKeySecret')
    );
  }

  public static function upload($ossKey, $filePath)
  {
    $oss = new OSS(true); // 上传文件使用内网，免流量费
    $oss->ossClient->setBucket('yishuodian-test');
    $oss->ossClient->uploadFile($ossKey, $filePath);
  }

  public static function getUrl($ossKey)
  {
    $oss = new OSS();
    $oss->ossClient->setBucket('yishuodian-test');
    return $oss->ossClient->getUrl($ossKey, new \DateTime("+1 day"));
  }

  public static function createBucket($bucketName)
  {
    $oss = new OSS();
    return $oss->ossClient->createBucket($bucketName);
  }

  public static function getAllObjectKey($bucketName)
  {
    $oss = new OSS();
    return $oss->ossClient->getAllObjectKey($bucketName);
  }

}
