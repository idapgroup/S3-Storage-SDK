<?php

namespace IdapGroup\S3StorageSdk\Tests;

use IdapGroup\S3StorageSdk\File\S3PublicFile;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class S3PublicFileTest extends TestCase
{
    public const FILE_URL = 'https://s3.amazonaws.com/bucket/path/to/filename.txt';

    private string $filePath;
    private string $fileName;
    private string $fileExt;
    private string $fileUrl;

    public function setUp(): void
    {
        parent::setUp();
        $this->filePath = 'https://s3.amazonaws.com/bucket/path/to';
        $this->fileName = 'filename.txt';
        $this->fileExt = 'txt';
        $this->fileUrl = $this->filePath . '/' . $this->fileName;
    }

    public function testGetBaseName()
    {
        $s3File = new S3PublicFile($this->fileUrl);
        $this->assertEquals($this->fileName, $s3File->getBaseName());
    }

    public function testGetExtension()
    {
        $s3File = new S3PublicFile($this->fileUrl);
        $this->assertEquals($this->fileExt, $s3File->getExtension());
    }

    public function testGetFullPath()
    {
        $s3File = new S3PublicFile($this->fileUrl);
        $this->assertEquals($this->filePath, $s3File->getFullPath());
    }

    public function testIsPublished()
    {
        $s3File = new S3PublicFile($this->fileUrl);
        $this->assertTrue($s3File->isPublished());
    }

    public function testGetUrl()
    {
        $s3File = new S3PublicFile($this->fileUrl);
        $this->assertEquals($this->fileUrl, $s3File->getUrl());
    }

    public function testInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        new S3PublicFile('');
    }
}
