<?php
namespace Skelgen\File;
/**
 * Class ExistingFile
 * @package Skelgen\File
 *
 * Used to remove problems of relative file paths etc. in PHP. A decisive check is done on construction and then it is realpath safe
 * ( also casts to realpath in the __toString() method ).
 */
class ExistingFile extends \SplFileInfo implements VerifiedFileSystemResource{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $absolutePath;


    public function __construct( $fileName ) {
        parent::__construct( $this->assertFileExists( $fileName ) );
        $this->absolutePath = $this->getRealPath();
    }


    /**
     * @param string $fileName
     * @return string  - returns the file if it does exist
     * @throws FileNotFoundException if not found
     */
    private function assertFileExists( $fileName ) {
        if( !is_file( $fileName )) {
            throw new FileNotFoundException( $fileName );
        }

        return $fileName;
    }


    public function __toString() {
        return $this->getRealPath();
    }


}
