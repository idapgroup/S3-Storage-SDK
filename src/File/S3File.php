<?php

namespace IdapGroup\S3StorageSdk\File;

/**
 * Abstraction for file that is transfer from write storage to read storage on S3
 *
 * @package IdapGroup\S3StorageSdk\File
 */
class S3File implements S3FileInterface
{
    /** @var string the filename */
    private string $filename;

    /** @var string the S3 bucket name */
    private string $bucket;

    /**
     * S3File constructor.
     * @param string $filename the filename
     * @param string $bucket S3 bucket name
     */
    public function __construct(string $filename, string $bucket)
    {
        $this->filename = $filename;
        $this->bucket = $bucket;
    }

    /** @inheritDoc */
    public function getBaseName(): string
    {
        return pathinfo($this->filename, PATHINFO_BASENAME);
    }

    /** @inheritDoc */
    public function getExtension(): string
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /** @inheritDoc */
    public function getFullPath(): string
    {
        return pathinfo($this->filename, PATHINFO_DIRNAME);
    }

    /** @inheritDoc */
    public function isPublished(): bool
    {
        return false;
    }

    /** @inheritDoc */
    public function getUrl(): string
    {
        return '';
    }

    public function getBucket(): string
    {
        return $this->bucket;
    }
}