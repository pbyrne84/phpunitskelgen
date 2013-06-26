<?php
namespace Skelgen\File;

use Skelgen\InternalBaseTestCase;

class ExistingDirectoryTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;


    public function getInvalidPaths() {
        return array(
            array( '', 'empty value throws exception' ),
            array( __FILE__, 'file throws exception' ),
            array( __DIR__ . '/snoofle/', 'invalid file throws exception' )
        );
    }


    /**
     * @dataProvider getInvalidPaths()
     *
     * @param string $invalidFilePath
     * @param string $testMessage
     */
    public function test_construct_invalidDirectoriesThrowException( $invalidFilePath, $testMessage ) {
        try {
            new ExistingDirectory( $invalidFilePath );
            $this->assertTrue( false, $testMessage );
        } catch ( DirectoryNotFoundException $e ) {
            $this->assertTrue( true );
        }
    }


    public function test_validConstruction() {
        $existingDirectory = new ExistingDirectory( __DIR__ . '/../../Skelgen/File/' );

        $this->assertEquals(
            __DIR__,
            $existingDirectory->getRealPath(),
            'Realpath returns folder '
        );

        $this->assertEquals(
            __DIR__,
            $existingDirectory . '',
            'Casting to string gives realpath'
        );
    }

}
  
