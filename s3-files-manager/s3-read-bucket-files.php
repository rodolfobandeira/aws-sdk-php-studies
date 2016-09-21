<?php

require '../vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'us-east-1'
]);

$result = $s3->listBuckets();

foreach ($result['Buckets'] as $bucket) {

    $iterator = $s3->getIterator('ListObjects', [
        'Bucket' => $bucket['Name']
    ]);

    foreach ($iterator as $object) {

        $s3FileObject = $s3->getCommand('GetObject', [
            'Bucket' => $bucket['Name'],
            'Key'    => $object['Key']
        ]);

        $request = $s3->createPresignedRequest($s3FileObject, '+3 minutes');
        $preSignedUrl = (string) $request->getUri();

        printf("Signed URL valid for 3 minutes: %s %s %s%s",
            PHP_EOL,
            $preSignedUrl,
            PHP_EOL,
            PHP_EOL
        );
    }
}
