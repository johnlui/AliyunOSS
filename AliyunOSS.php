<?php

namespace JohnLui\AliyunOSS;

use Aliyun\OSS\OSSClient;
use \Aliyun\OSS\Models\OSSOptions;

/**
* \OssService
*/
class AliyunOSS {

  protected $ossClient;
  protected $bucket;

  public function __construct($serverName, $AccessKeyId, $AccessKeySecret)
  {
    $this->ossClient = OSSClient::factory([
      OSSOptions::ENDPOINT => $serverName,
      'AccessKeyId' => $AccessKeyId,
      'AccessKeySecret' => $AccessKeySecret
    ]);
  }

  public static function boot($serverName, $AccessKeyId, $AccessKeySecret)
  {
    return new AliyunOSS($serverName, $AccessKeyId, $AccessKeySecret);
  }

  public function setBucket($bucket)
  {
    $this->bucket = $bucket;
    return $this;
  }

  public function uploadFile($key, $file)
  {
    return $this->ossClient->putObject(array(
        'Bucket' => $this->bucket,
        'Key' => $key,
        'Content' => fopen($file, 'r'),
        'ContentLength' => filesize($file)
    ));
  }

  public function getUrl($key, $expire_time)
  {
    return $this->ossClient->generatePresignedUrl([
      'Bucket' => $this->bucket,
      'Key' => $key,
      'Expires' => $expire_time
    ]);
  }

  public function createBucket($bucketName)
  {
    return $this->ossClient->createBucket(['Bucket' => $bucketName]);
  }

  public function getAllObjectKey($bucketName)
  {
    $objectListing = $this->ossClient->listObjects(array(
      'Bucket' => $bucketName,
    ));

    $objectKeys = [];
    foreach ($objectListing->getObjectSummarys() as $objectSummary) {
      $objectKeys[] = $objectSummary->getKey();
    }
    return $objectKeys;
  }
}