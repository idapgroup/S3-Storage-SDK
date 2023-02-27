<?php

namespace IdapGroup\S3StorageSdk\File;

use InvalidArgumentException;

/**
 * Abstraction for file that is get from s3
 *
 * @package IdapGroup\S3StorageSdk\File
 */
class S3PublicFile implements S3FileInterface
{
    /** @var string a link to the file on S3 */
    protected string $url;

    /**
     * S3File constructor.
     *
     * @param string $url a link to the file on S3
     */
    public function __construct(string $url)
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Url must be set');
        }
        $this->url = $url;
    }

    /** @inheritDoc */
    public function getBaseName(): string
    {
        return pathinfo($this->url, PATHINFO_BASENAME);
    }

    /** @inheritDoc */
    public function getExtension(): string
    {
        return pathinfo($this->url, PATHINFO_EXTENSION);
    }

    /** @inheritDoc */
    public function getFullPath(): string
    {
        return pathinfo($this->url, PATHINFO_DIRNAME);
    }

    /** @inheritDoc */
    public function isPublished(): bool
    {
        return true;
    }

    /** @inheritDoc */
    public function getUrl(): string
    {
        return $this->url;
    }
}