<?php
namespace Skelgen\PhpStorm;

use Skelgen\IDE\IdeFileOpener;

class PhpStormFileOpener implements IdeFileOpener{

    const PORT = 8091;
    const HOST = 'localhost'; // not changeable due to plugin limitation

    const CLASS_NAME = __CLASS__;


    /**
     * @param \SplFileInfo $filePath
     *
     * @throws \InvalidArgumentException
     */
    public function openFile( \SplFileInfo $filePath ){
        if( !$filePath->isFile() ){
            throw new \InvalidArgumentException( $filePath->getPathname() . ' is not a valid file');
        }

        $execCommand = 'PhpStorm "' . $filePath->getPathname() . '"';
        echo "Running $execCommand \n";
        exec( $execCommand, $output );
    }
}
