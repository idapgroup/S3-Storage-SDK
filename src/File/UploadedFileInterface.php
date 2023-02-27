<?php

namespace IdapGroup\S3StorageSdk\File;

/**
 * Interface UploadedFileInterface
 * @package IdapGroup\S3StorageSdk\File
 */
interface UploadedFileInterface
{
    /**
     * Gets the base name of the file
     *
     * @return string
     */
    public function getBaseName(): string;

    /**
     * Gets the path to the file
     *
     * @return string
     */
    public function getPathname(): string;

    /**
     * Get the mime type of the file
     *
     * @return string|null
     */
    public function getMimeType(): ?string;
}