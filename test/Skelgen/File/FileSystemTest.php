<?php
namespace Skelgen\File;

use Skelgen\InternalBaseTestCase;

class FileSystemTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;

    /** @var FileSystem */
    private $fileSystem;


    protected function setUp() {
        $this->fileSystem = new FileSystem();
    }


    public function test_getDirectory() {
        $existingDirectory = $this->fileSystem->getDirectory( __DIR__ );
        $this->assertInstanceOf( ExistingDirectory::CLASS_NAME, $existingDirectory );

        $this->assertEquals( __DIR__, $existingDirectory->getRealPath() );
    }


    public function test_getFile() {
        $existingFile = $this->fileSystem->getFile( __FILE__ );
        $this->assertInstanceOf( ExistingFile::CLASS_NAME, $existingFile );

        $this->assertEquals( __FILE__, $existingFile->getRealPath() );
    }

}
  
