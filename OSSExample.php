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

  /**
   * 删除存储在oss中的文件
   *
   * @param string $ossKey 存储的key（文件路径和文件名）
   * @return
   */
  public static function deleteObject($ossKey)
  {
      $oss = new OSS(true); // 上传文件使用内网，免流量费

      return $oss->ossClient->deleteObject('your-bucket-name', $ossKey);
  }

  /**
   * 复制存储在阿里云OSS中的Object
   *
   * @param string $sourceBuckt 复制的源Bucket
   * @param string $sourceKey - 复制的的源Object的Key
   * @param string $destBucket - 复制的目的Bucket
   * @param string $destKey - 复制的目的Object的Key
   * @return Models\CopyObjectResult
   */
  public function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
  {
      $oss = new OSS(true); // 上传文件使用内网，免流量费

      return $oss->ossClient->copyObject('your-source-bucket-name', $sourceKey, 'your-dest-bucket-name', $destKey);
  }

  /**
   * 移动存储在阿里云OSS中的Object
   *
   * @param string $sourceBuckt 复制的源Bucket
   * @param string $sourceKey - 复制的的源Object的Key
   * @param string $destBucket - 复制的目的Bucket
   * @param string $destKey - 复制的目的Object的Key
   * @return Models\CopyObjectResult
   */
  public function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
  {
      $oss = new OSS(true); // 上传文件使用内网，免流量费

      return $oss->ossClient->moveObject('your-source-bucket-name', $sourceKey, 'your-dest-bucket-name', $destKey);
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