<?php
namespace Skelgen\Local;

use Skelgen\File\ExistingDirectory;

class ItjbBasePathCalculator implements \Skelgen\Project\BasePathCalculator {
    const CLASS_NAME = __CLASS__;


    /**
     * @param \SplFileInfo $classPath
     *
     * @throws \RuntimeException
     * @internal param $ \Skelgen\File\ExistingFile $
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \SplFileInfo $classPath ) {
        $absolutePath = str_replace( '\\', '/', $classPath->getRealPath()  );
        $regex = '~(\w):(.*)dev.itjb4.local/ITJB(\d|i)/~i';
        if( !preg_match( $regex, $absolutePath, $matches ) ){
            throw new \RuntimeException("cannot calculate base path using " . $regex . "in " . $absolutePath );
        }

        return new ExistingDirectory($matches[ 0 ] );
    }
}
