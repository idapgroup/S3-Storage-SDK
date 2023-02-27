<?php

namespace IdapGroup\S3StorageSdk\Storage;

use Aws\S3\S3ClientInterface;
use IdapGroup\S3StorageSdk\File\S3FileInterface;
use IdapGroup\S3StorageSdk\File\S3PublicFile;
use IdapGroup\S3StorageSdk\File\UploadedFileInterface;
use const DIRECTORY_SEPARATOR;

/**
 * Class S3Storage
 * @package IdapGroup\S3StorageSdk\Storage
 */
class S3Storage implements S3StorageInterface
{
    /** @var string a name of a bucket which contains files */
    private string $bucket;

    /** @var string S3 region */
    private string $region;

    /** @var S3ClientInterface a client to interaction with S3 API */
    private S3ClientInterface $client;

    /**
     * S3Storage constructor.
     *
     * @param S3ClientInterface $client
     * @param string            $bucket a name of a bucket which contains files
     * @param string            $region
     */
    public function __construct(S3ClientInterface $client, string $bucket, string $region)
    {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->region = $region;
    }

    /** @inheritDoc */
    public function getBucket(): string
    {
        return $this->bucket;
    }

    /** @inheritDoc */
    public function getRegion(): string
    {
        return $this->region;
    }

    /** @inheritDoc */
    public function save(UploadedFileInterface $source, string $filename = null): void
    {
        if (empty($filename)) {
            $filename = $source->getBaseName();
        }

        $command = $this->client->getCommand('putObject', [
            'Bucket' => $this->bucket,
            'Key' => $filename,
            'SourceFile' => $source->getPathname(),
            'ContentType' => $source->getMimeType(),
            'ACL' => 'public-read'
        ]);

        $this->client->execute($command);
    }

    /** @inheritDoc */
    public function transfer(S3FileInterface $source, string $putPath = null): void
    {
        $filePath = $source->getFullPath() . DIRECTORY_SEPARATOR . $source->getBaseName();
        $putPath = $putPath ?? $filePath;
        $this->client->copy($source->getBucket(), $filePath, $this->bucket, $putPath);
        $this->client->deleteMatchingObjects($source->getBucket(), $filePath);
    }

    /** @inheritDoc */
    public function delete(string $filename): void
    {
        $this->client->deleteMatchingObjects($this->bucket, $filename);
    }

    /** @inheritDoc */
    public function has(string $filename): bool
    {
        return $this->client->doesObjectExist($this->bucket, $filename);
    }

    /** @inheritDoc */
    public function get(string $filename): S3FileInterface
    {
        $command = $this->client->getCommand('GetObject',[
            'Bucket' => $this->bucket,
            'Key' => $filename,
            'Body' => ''
        ]);

        $request = $this->client->createPresignedRequest($command, '+1 day');
        $url = (string)$request->getUri();

        return new S3PublicFile($url);
    }

    /** @inheritDoc */
    public function buildPutUrl(string $name): string
    {
        $command = $this->client->getCommand('PutObject',[
            'Bucket' => $this->bucket,
            'Key' => $name,
            'Body' => ''
        ]);

        $request = $this->client->createPresignedRequest($command, '+20 minutes');

        return (string)$request->getUri();
    }
}