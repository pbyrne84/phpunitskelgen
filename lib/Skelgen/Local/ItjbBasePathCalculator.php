<?php
namespace Skelgen\Local;

use Skelgen\File\ExistingDirectory;

class ItjbBasePathCalculator implements \Skelgen\Project\BasePathCalculator {
    const CLASS_NAME = __CLASS__;


    /**
     * @param \Skelgen\File\ExistingFile $
     * @param $filePath
     * @throws \RuntimeException
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \Skelgen\File\ExistingFile $filePath ) {
        $absolutePath = str_replace( '\\', '/', $filePath->getRealPath()  );
        $regex = '~(\w):(.*)dev.itjb4.local/ITJB(\d|i)/~i';
        if( !preg_match( $regex, $absolutePath, $matches ) ){
            throw new \RuntimeException("cannot calculate base path using " . $regex . "in " . $absolutePath );
        }

        return new ExistingDirectory($matches[ 0 ] );
    }
}
