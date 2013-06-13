<?php
namespace Skelgen\File;

class ExistingDirectory extends \SplFileInfo implements VerifiedFileSystemResourceMarker{
    const CLASS_NAME = __CLASS__;


    public function __construct( $fileName ) {
        parent::__construct( $this->assertDirectoryExists( $fileName ) );
    }


    /**
     * @param string $fileName
     * @return string  - returns the file if it does exist
     * @throws DirectoryNotFoundException if not found
     */
    private function assertDirectoryExists( $fileName ) {
        if( !is_dir( $fileName )) {
            throw new DirectoryNotFoundException( $fileName );
        }

        return $fileName;
    }


    public function __toString() {
        return $this->getRealPath();
    }


}
