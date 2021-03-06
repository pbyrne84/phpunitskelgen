<?php
namespace Skelgen\File;

/**
 * Class ExistingDirectory
 * @package Skelgen\File
 *
 * Used to remove problems of relative folder paths etc. in PHP. A decisive check is done on construction and then it is realpath safe
 * ( also casts to realpath in the __toString() method ).
 */
class ExistingDirectory extends \SplFileInfo implements VerifiedFileSystemResource{
    const CLASS_NAME = __CLASS__;


    public function __construct( $fileName ) {
        parent::__construct( $this->attemptRealPath( $fileName ) );
    }


    /**
     * @param string $fileName
     * @return string  - returns the file if it does exist
     * @throws DirectoryNotFoundException if not found
     */
    private function attemptRealPath( $fileName ) {
        if( !is_dir( $fileName )) {
            throw new DirectoryNotFoundException( $fileName );
        }

        return realpath( $fileName );
    }


    /**
     * @inheritdoc
     */
    public function getNormalisedRealPath() {
       return str_replace( '\\', '/', $this->getRealPath() );
    }
}
