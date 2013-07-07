<?php
/**
 * Caches converted input on the file system
 *
 * PHP version 5.4
 *
 * @category   HexDump
 * @package    FileSystem
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace HexDump\FileSystem;

/**
 * Caches converted input on the file system
 *
 * @category   HexDump
 * @package    FileSystem
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Storage
{
    /**
     * @var string The directory in which to store the cached output
     */
    private $dataDirectory;

    /**
     * Creates instance
     *
     * @param string $dataDirectory The directory in which to store the cached output
     */
    public function __construct($dataDirectory)
    {
        $this->dataDirectory = rtrim($dataDirectory, '/');
    }

    /**
     * Save the data to a file
     *
     * @param string $data The data to save
     *
     * @return string The hash of the data
     */
    public function save($data)
    {
        $hash = sha1($data);

        $fullDirectory = $this->dataDirectory . '/' . substr($hash, 0, 5) . '/';

        if (!is_dir($fullDirectory)) {
            mkdir($fullDirectory);
        }

        if (is_file($fullDirectory . '/' . $hash)) {
            return $hash;
        }

        file_put_contents($fullDirectory . '/' . $hash, $data);

        return $hash;
    }

    /**
     * Gets the cached data
     *
     * @param string $hash The sha1 hash of the cached data
     *
     * @return false|string False if the data is not cached
     */
    public function get($hash)
    {
        $filename = $this->dataDirectory . '/' . substr($hash, 0, 5) . '/' . $hash;

        if (!is_file($filename)) {
            return false;
        }

        touch($filename);

        return file_get_contents($filename);
    }

    /**
     * Removes a file from the file system
     *
     * If there are no files left in the directory the directory will also be removed
     *
     * @param $filename The file to remove
     */
    public function removeFile($filename)
    {
        @unlink($filename);

        $directoryIterator = new \DirectoryIterator(dirname($filename));
        foreach($directoryIterator as $file){
            if ($file->isDot()) {
                continue;
            }

            return;
        }

        @rmdir(dirname($filename));
    }
}
