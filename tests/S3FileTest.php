<?php

namespace IdapGroup\S3StorageSdk\Tests;

use IdapGroup\S3StorageSdk\File\S3File;
use PHPUnit\Framework\TestCase;

class S3FileTest extends TestCase
{
    public function testGetBaseName()
    {
        $s3File = new S3File('/path/to/filename.txt', 'bucket');
        $this->assertEquals('filename.txt', $s3File->getBaseName());
    }

    public function testGetExtension()
    {
        $s3File = new S3File('/path/to/filename.txt', 'bucket');
        $this->assertEquals('txt', $s3File->getExtension());
    }

    public function testGetFullPath()
    {
        $s3File = new S3File('/path/to/filename.txt', 'bucket');
        $this->assertEquals('/path/to', $s3File->getFullPath());
    }

    public function testIsPublished()
    {
        $s3File = new S3File('/path/to/filename.txt', 'bucket');
        $this->assertFalse($s3File->isPublished());
    }

    public function testGetUrl()
    {
        $s3File = new S3File('/path/to/filename.txt', 'bucket');
        $this->assertEquals('', $s3File->getUrl());
    }

    public function testGetBucket()
    {
        $s3File = new S3File('filename.txt', 'bucket');
        $this->assertEquals('bucket', $s3File->getBucket());
    }
}
