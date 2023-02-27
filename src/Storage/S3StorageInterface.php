<?php

namespace IdapGroup\S3StorageSdk\Storage;

use Exception;
use IdapGroup\S3StorageSdk\File\S3FileInterface;
use IdapGroup\S3StorageSdk\File\UploadedFileInterface;

/**
 * Interface S3StorageInterface
 * @package IdapGroup\S3StorageSdk\Storage
 */
interface S3StorageInterface
{
    /**
     * Save the file to the file storage
     *
     * @param UploadedFileInterface $source   the source file
     * @param string|null           $filename the path to the file
     *
     * @throws Exception
     */
    public function save(UploadedFileInterface $source, string $filename = null): void;

    /**
     * Transfer the file to the file storage
     *
     * @param S3FileInterface $source  the source file
     * @param string|null     $putPath path for put file
     *
     * @throws Exception
     */
    public function transfer(S3FileInterface $source, string $putPath = null): void;

    /**
     * Delete the file form the file storage
     *
     * @param string $filename the path to the file
     */
    public function delete(string $filename): void;

    /**
     * Check the existence of the file in the file storage
     *
     * @param string $filename the path to the file
     *
     * @return bool true if the file exists or false if the file not exists
     */
    public function has(string $filename): bool;

    /**
     * Get the file
     *
     * @param string $filename the path to the file
     *
     * @return S3FileInterface the file
     */
    public function get(string $filename): S3FileInterface;

    /**
     * Get the bucket name
     *
     * @return string the bucket name
     */
    public function getBucket(): string;

    /**
     * Get the bucket region
     *
     * @return string the bucket region
     */
    public function getRegion(): string;

    /**
     * Build URL to manual upload a file
     *
     * @param string $name the filename
     *
     * @return string URL value
     */
    public function buildPutUrl(string $name): string;
}