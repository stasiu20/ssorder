<?php

namespace common\services;

use Aws\S3\S3Client;
use common\validators\FilePHP81Validator;
use GuzzleHttp\Psr7\Uri;
use yii\helpers\FileHelper;

class FileService
{
    /**
     * @var S3Client
     */
    private $_s3Client;

    /** @var string */
    private $_bucketName = 'ssorder';

    public function __construct(S3Client $s3Client)
    {
        $this->_s3Client = $s3Client;
    }

    public function getPublicFileUrl(string $key): string
    {
        $url = getenv('MINIO_PUBLIC_URL');
        $uri = new Uri($url);
        $uri = $uri->withPath($this->_bucketName . '/' . $key);
        return (string)$uri;
    }

    public function getFile(string $key): \Aws\Result
    {
        return $this->_s3Client->getObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
        ]);
    }

    public function storeFile(string  $key, string $filePath): void
    {
        $this->_s3Client->putObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
            'SourceFile' => $filePath,
            'ContentType' => FilePHP81Validator::getMimeType(
                $filePath,
                null,
                false
            )
        ]);
    }

    public function deleteFile(string $key): void
    {
        $this->_s3Client->deleteObject([
            'Bucket' => $this->_bucketName,
            'Key'    => $key,
        ]);
    }
}
