<?php

namespace common\services;

use Aws\S3\S3Client;
use GuzzleHttp\Psr7\Uri;
use yii\helpers\FileHelper;

class FileService
{
    /**
     * @var S3Client
     */
    private $_s3Client;

    private $_bucketName = 'ssorder';

    public function __construct(S3Client $s3Client)
    {
        $this->_s3Client = $s3Client;
    }

    public function getPublicFileUrl($key)
    {
        $url = getenv('MINIO_PUBLIC_URL');
        $uri = new Uri($url);
        $uri = $uri->withPath($this->_bucketName . '/' . $key);
        return (string)$uri;
    }

    public function getFile($key)
    {
        return $this->_s3Client->getObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
        ]);
    }

    public function storeFile($key, $filePath)
    {
        $this->_s3Client->putObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
            'SourceFile' => $filePath,
            'ContentType' => FileHelper::getMimeType(
                $filePath,
                null,
                false
            )
        ]);
    }

    public function deleteFile($key)
    {
        $this->_s3Client->deleteObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
        ]);
    }
}
