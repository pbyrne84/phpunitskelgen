<?php

namespace Skelgen\Autoload;


class SkelgenAutoload {
    const CLASS_NAME = __CLASS__;

    private $namespaceList = array( 'Skelgen' );


    function __construct() {
        $jeSkelgenPath = get_include_path() . PATH_SEPARATOR . __DIR__ . '/../../';
        $this->addAutloaderPath( $jeSkelgenPath );
    }


    /**
     * @param string $jeSkelgenPath
     */
    private function addAutloaderPath( $jeSkelgenPath ) {
        set_include_path(
            get_include_path() . PATH_SEPARATOR .
            $jeSkelgenPath
        );
    }


    /**
     * @param string $nameSpace
     * @param string $rootDirectory
     */
    public function addNamespace( $nameSpace, $rootDirectory ) {
        $this->namespaceList[] = $nameSpace;
        $this->addAutloaderPath( $rootDirectory );
    }


    public function initSkelgenAutoLoad() {
        $autoload = $this;
        spl_autoload_register( function ( $className ) use ( $autoload ) {
            if ( !$autoload->nameSpaceMatches( $className ) ) {
                return;
            }

            if ( !include_once $className . '.php' ) {
                var_dump( get_include_path() );
            }
        } );
    }


    /**
     * @param string $className
     *
     * @return bool
     */
    public function nameSpaceMatches( $className ) {
        $parts = explode( '\\', $className );
        return in_array( $parts[0], $this->namespaceList );

    }
}
