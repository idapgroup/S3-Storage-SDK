# Viber SDK

S3 Storage SDK for working with AWS S3 Storage.

## Documentation

The documentation for the AWS S3 Storage Api can be found [here](https://aws.amazon.com/sdk-for-php/).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require idapgroup/s3-storage-sdk
```

or add

```json
{
  "require": {
      "idapgroup/s3-storage-sdk": "^0.1.0"
  }
}
```

to the requirement section of your `composer.json` file.

## Quickstart

### Create a S3 Storage

```php
<?php

require 'vendor/autoload.php';

use IdapGroup\S3StorageSdk\Storage\S3Storage;

$s3Client = new S3Client([
            'region' => 'S3_REGION',
            'version' => 'S3_API_VERSION',
            'credentials' => [
                'key' => 'S3_KEY',
                'secret' => 'S3_SECRET'
            ],
        ]);

$readStorage = new S3Storage($s3Client, 'S3_READ_BUCKET', 'S3_REGION');
$writeStorage = new S3Storage($s3Client, 'S3_WRITE_BUCKET', 'S3_REGION');
```

### Examples

#### Save file

```php
//Create an instance of class that implements UploadedFileInterface
$file = new UploadedFile();
$readStorage->save($file, 'filename');
```

#### Transfer the file to the file storage

```php
//Create an instance of class that implements S3FileInterface or extends S3File
$imageFile = new S3File('file_path', $writeStorage->getBucket());
$readStorage->transfer($imageFile);
```

#### Delete the file form the file storage

```php
$readStorage->delete('file_path');
```

#### Check the existence of the file in the file storage

```php
$readStorage->has('file_path');
```

#### Get the file

```php
$readStorage->get('file_path');
```

#### Get the bucket name

```php
$bucketName = $readStorage->getBucket();
```

#### Get the bucket region

```php
$bucketRegion = $readStorage->getRegion();
```

#### Build URL to manual upload a file

```php
$bucketName = $writeStorage->buildPutUrl('filename');
```
