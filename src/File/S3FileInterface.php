<?php

namespace IdapGroup\S3StorageSdk\File;

/**
 * Interface FileInterface
 * @package IdapGroup\S3StorageSdk\File
 */
interface S3FileInterface
{
    /**
     * Get a base name of the file
     *
     * @return string the file name
     */
    public function getBaseName(): string;

    /**
     * Get an extension of the file
     *
     * @return string the extension
     */
    public function getExtension(): string;

    /**
     * Get a full path of the file
     *
     * @return string the full path
     */
    public function getFullPath(): string;

    /**
     * Get the publishing status of the file
     *
     * @return bool true if the file is published or false if the file isn't published
     */
    public function isPublished(): bool;

    /**
     * Get a public URL to the file
     *
     * @return string the public URL
     */
    public function getUrl(): string;
}