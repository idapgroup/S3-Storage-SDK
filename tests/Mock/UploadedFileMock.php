<?php

declare(strict_types=1);

namespace IdapGroup\S3StorageSdk\Tests\Mock;

use IdapGroup\S3StorageSdk\File\UploadedFileInterface;

class UploadedFileMock implements UploadedFileInterface
{
    private string $fileName;

    private string $pathName;

    private string $mimeType;

    public function __construct(
        string $fileName = 'filename.txt',
        string $pathName = '/path/to/filename.txt',
        string $mimeType = 'text/plain'
    ) {
        $this->fileName = $fileName;
        $this->pathName = $pathName;
        $this->mimeType = $mimeType;
    }
    /**
     * @inheritDoc
     */
    public function getBaseName(): string
    {
        return $this->fileName;
    }

    /**
     * @inheritDoc
     */
    public function getPathname(): string
    {
        return $this->pathName;
    }

    /**
     * @inheritDoc
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }
}