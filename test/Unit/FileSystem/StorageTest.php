<?php

namespace HexDumpTest\FileSystem;

use HexDump\FileSystem\Storage;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    private $dataDir;

    public function setUp()
    {
        $this->dataDir = __DIR__ . '/../../Data';
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::save
     */
    public function testSaveNoDirNoFile()
    {
        $storage = new Storage($this->dataDir);

        $this->assertSame('7cf184f4c67ad58283ecb19349720b0cae756829', $storage->save('H'));
        $this->assertTrue(is_file($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829'));

        @unlink($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829');
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::save
     */
    public function testSaveDirNoFile()
    {
        $storage = new Storage($this->dataDir);

        $this->assertSame('7cf184f4c67ad58283ecb19349720b0cae756829', $storage->save('H'));
        $this->assertTrue(is_file($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829'));
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::save
     */
    public function testSaveDirFile()
    {
        $storage = new Storage($this->dataDir);

        $this->assertSame('7cf184f4c67ad58283ecb19349720b0cae756829', $storage->save('H'));
        $this->assertTrue(is_file($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829'));
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::get
     */
    public function testGetExists()
    {
        $storage = new Storage($this->dataDir);

        $this->assertSame('H', $storage->get('7cf184f4c67ad58283ecb19349720b0cae756829'));
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::get
     */
    public function testGetNotExists()
    {
        $storage = new Storage($this->dataDir);

        $this->assertFalse($storage->get('7cf184f4c67ad58283ecb19349720b0cae756829x'));
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::removeFile
     */
    public function testRemoveFileKeepDirectory()
    {
        $storage = new Storage($this->dataDir);

        touch($this->dataDir . '/7cf18/dummy');

        $this->assertTrue(is_file($this->dataDir . '/7cf18/dummy'));

        $storage->removeFile($this->dataDir . '/7cf18/dummy');

        $this->assertTrue(is_file($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829'));
        $this->assertFalse(is_file($this->dataDir . '/7cf18/dummy'));
        $this->assertTrue(is_dir($this->dataDir . '/7cf18'));
    }

    /**
     * @covers HexDump\FileSystem\Storage::__construct
     * @covers HexDump\FileSystem\Storage::removeFile
     */
    public function testRemoveFileAndDirectory()
    {
        $storage = new Storage($this->dataDir);

        $storage->removeFile($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829');

        $this->assertFalse(is_file($this->dataDir . '/7cf18/7cf184f4c67ad58283ecb19349720b0cae756829'));
        $this->assertFalse(is_dir($this->dataDir . '/7cf18'));
        $this->assertTrue(is_dir($this->dataDir));
    }
}
