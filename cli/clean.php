<?php
/**
 * Cleans up the converted hex dumps
 *
 * This file checks all added hex dumps to see whether they should be deleted.
 * By default all dumps which haven't been accessed for a week will be deleted.
 *
 * PHP version 5.4
 *
 * @category   HexDump
 * @package    Cli
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace HexDump\Cli;

require __DIR__ . '/../bootstrap.php';

$directoryIterator = new \DirectoryIterator(__DIR__ . '/../data');

foreach ($directoryIterator as $directory) {
    if ($directory->isDot() || !$directory->isDir()) {
        continue;
    }

    $cacheDirectoryIterator = new \DirectoryIterator($directory->getPathname());

    foreach ($cacheDirectoryIterator as $cachedFile) {
        if ($cachedFile->isDot() || !$cachedFile->isFile()) {
            continue;
        }

        $expirationTime = filemtime($cachedFile->getPathname()) + (60 * 60 * 24 * 7);
        if ($expirationTime < time()) {
            $storage->removeFile($cachedFile->getPathname());
        }
    }
}
