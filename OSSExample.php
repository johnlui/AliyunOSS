<?php

namespace App\Services;

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
  /**
   * 直接把变量内容上传到oss
   * @param $osskey
   * @param $content
   */
  public static function uploadContent($osskey,$content)
  {
    $oss = new OSS(true); // 上传文件使用内网，免流量费
    $oss->ossClient->setBucket('yishuodian-test');
    $oss->ossClient->uploadContent($osskey,$content);
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