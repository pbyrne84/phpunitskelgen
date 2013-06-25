<?php

namespace Skelgen\Autoload;


class SkelgenAutoload {
    const CLASS_NAME = __CLASS__;

    private $namespaceList = array( 'Skelgen', 'LocalSkelgenTestGeneration' );


    function __construct() {
        $this->addAutloaderPath( __DIR__ . '/../../' );
        $this->addAutloaderPath( __DIR__ . '/../../../internal/' );
        $this->addAutloaderPath( __DIR__ . '/../../../test/' );
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
            if ( !$autoload->isValidForThisAutoloader( $className ) ) {
                return;
            }

            $classFileName = $className . '.php';

            $autoLoadErrorHandler = function() use ($classFileName){
                $message = "Could not find $classFileName, tried \n" ;
                $triedPaths = explode( PATH_SEPARATOR, get_include_path() );
                foreach( $triedPaths as $triedPath){
                    $message .= realpath( $triedPath ) . '/' . $classFileName . "\n";
                }

                throw new CouldNotResolveAutoIncludeException( $message );
            };

            set_error_handler( $autoLoadErrorHandler );
            include_once $classFileName;
            restore_error_handler();
        } );
    }


    /**
     * @param string $className
     *
     * @return bool
     */
    public function isValidForThisAutoloader( $className ) {
        if( $className == 'Phockito' ){
            return true;
        }

        $parts = explode( '\\', $className );
        return in_array( $parts[0], $this->namespaceList );

    }
}
