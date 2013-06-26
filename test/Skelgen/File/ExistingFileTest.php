<?php
namespace Skelgen\File;

use Skelgen\InternalBaseTestCase;

class ExistingFileTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;


    public function getInvalidPaths() {
        return array(
            array( '', 'empty value throws exception' ),
            array( __DIR__, 'directory throws exception' ),
            array( __DIR__ . '/invalid.txt', 'invalid file throws exception' )
        );
    }


    /**
     * @dataProvider getInvalidPaths()
     *
     * @param string $invalidFilePath
     * @param string $testMessage
     */
    public function test_construct_invalidFilesThrowException( $invalidFilePath, $testMessage ) {
        try {
            new ExistingFile( $invalidFilePath );
            $this->assertTrue( false, $testMessage );
        } catch ( FileNotFoundException $e ) {
            $this->assertTrue( true );
        }
    }


    public function test_validConstruction(){
        $existingFile = new ExistingFile( __DIR__ .'/../../'. __CLASS__ . '.php'  );

        $this->assertEquals(
            __FILE__,
            $existingFile->getRealPath() ,
            'Realpath returns file '
        );


        $this->assertEquals(
            __FILE__,
            $existingFile . '',
            'Casting to string gives realpath'
        );
    }

}
  
