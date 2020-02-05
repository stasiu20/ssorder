<?php

namespace console\controllers;

use Aws\S3\S3Client;
use common\enums\BucketEnum;
use yii\console\Controller;

class InitController extends Controller
{
    public function actionCreateBucket(): void
    {
        $bucket = 'ssorder';
        /** @var S3Client $s3Client */
        $s3Client = \Yii::$container->get(S3Client::class);
        $s3Client->createBucket(['Bucket' => $bucket]);

        $policyJson = <<<EOS
{
    "Version":"2012-10-17",
    "Statement":[
        {
            "Sid":"PublicRead",
            "Effect":"Allow",
            "Principal": "*",
            "Action":["s3:GetObject"],
            "Resource":["arn:aws:s3:::$bucket/*"]
        }
    ]
}
EOS;

        $s3Client->putBucketPolicy([
            'Bucket' => $bucket,
            'Policy' => $policyJson
        ]);
    }
}
