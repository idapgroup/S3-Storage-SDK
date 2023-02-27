<?php

namespace IdapGroup\S3StorageSdk\Tests;

use Aws\CommandInterface;
use Aws\S3\S3ClientInterface;
use IdapGroup\S3StorageSdk\File\S3File;
use IdapGroup\S3StorageSdk\File\S3PublicFile;
use IdapGroup\S3StorageSdk\Storage\S3Storage;
use IdapGroup\S3StorageSdk\Tests\Mock\UploadedFileMock;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class S3StorageTest extends TestCase
{
    /** @var S3Storage */
    private S3Storage $storage;

    /** @var S3ClientInterface */
    private S3ClientInterface $client;

    /** @var S3File */
    private S3File $s3File;

    /** @var string */
    private string $bucket;

    /** @var string */
    private string $region;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createMock(S3ClientInterface::class);
        $this->bucket = 'bucket';
        $this->region = 'region';
        $this->storage = new S3Storage($this->client, $this->bucket, $this->region);
        $this->s3File = new S3File('/path/to/filename.txt', $this->bucket);
    }

    public function testGetBucket(): void
    {
        $this->assertEquals($this->bucket, $this->storage->getBucket());
    }

    public function testGetRegion(): void
    {
        $this->assertEquals($this->region, $this->storage->getRegion());
    }

    public function testSave(): void
    {
        $source = new UploadedFileMock();

        $command = $this->createMock(CommandInterface::class);
        $this->client->expects($this->once())
            ->method('getCommand')
            ->with('putObject', [
                'Bucket' => $this->bucket,
                'Key' => $source->getBaseName(),
                'SourceFile' => $source->getPathname(),
                'ContentType' => $source->getMimeType(),
                'ACL' => 'public-read'
            ])
            ->willReturn($command);

        $this->client->expects($this->once())
            ->method('execute')
            ->with($command);

        $this->storage->save($source);
    }

    public function testTransferWithPutPath()
    {
        $filePath = '/path/to/filename.txt';
        $putPath = '/path/to/put/file.filename.txt';

        $this->client->expects($this->once())
            ->method('copy')
            ->with(
                $this->bucket,
                $filePath,
                $this->bucket,
                $putPath
            );

        $this->client->expects($this->once())
            ->method('deleteMatchingObjects')
            ->with($this->bucket, $filePath);

        $this->storage->transfer($this->s3File, $putPath);
    }

    public function testTransferWithoutPutPath()
    {
        $filePath = '/path/to/filename.txt';

        $this->client->expects($this->once())
            ->method('copy')
            ->with(
                $this->bucket,
                $filePath,
                $this->bucket,
                $filePath
            );

        $this->client->expects($this->once())
            ->method('deleteMatchingObjects')
            ->with($this->bucket, $filePath);

        $this->storage->transfer($this->s3File);
    }

    public function testDelete()
    {
        $filePath = '/path/to/filename.txt';

        $this->client->expects($this->once())
            ->method('deleteMatchingObjects')
            ->with($this->bucket, $filePath);

        $this->storage->delete($filePath);
    }

    public function testHas()
    {
        $filePath = '/path/to/filename.txt';

        $this->client->expects($this->once())
            ->method('doesObjectExist')
            ->with($this->bucket, $filePath)
        ->willReturn(true);

        $this->storage->has($filePath);
    }

    public function testGet(): void
    {
        $filePath = '/path/to/filename.txt';
        $command = $this->createMock(CommandInterface::class);
        $this->client->expects($this->once())
            ->method('getCommand')
            ->with('GetObject', [
                'Bucket' => $this->bucket,
                'Key' => $filePath,
                'Body' => ''
            ])
            ->willReturn($command);

        $request = $this->createMock(RequestInterface::class);
        $this->client->expects($this->once())
            ->method('createPresignedRequest')
            ->with($command, '+1 day')
            ->willReturn($request);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($filePath);

        $s3File = $this->storage->get($filePath);
        $this->assertInstanceOf(S3PublicFile::class, $s3File);
        $this->assertEquals($filePath, $s3File->getUrl());
    }

    public function testBuildPutUrl(): void
    {
        $filePath = '/path/to/filename.txt';
        $command = $this->createMock(CommandInterface::class);
        $this->client->expects($this->once())
            ->method('getCommand')
            ->with('PutObject', [
                'Bucket' => $this->bucket,
                'Key' => $filePath,
                'Body' => ''
            ])
            ->willReturn($command);

        $request = $this->createMock(RequestInterface::class);
        $this->client->expects($this->once())
            ->method('createPresignedRequest')
            ->with($command, '+20 minutes')
            ->willReturn($request);

        $request->expects($this->once())
            ->method('getUri')
            ->willReturn($filePath);

        $url = $this->storage->buildPutUrl($filePath);
        $this->assertEquals($filePath, $url);
    }
}
