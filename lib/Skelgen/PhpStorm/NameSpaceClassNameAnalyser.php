<?php

namespace Skelgen\PhpStorm;

class NamespaceClassNameAnalyser {

    /**
     * @var array|NamespaceFolderRule[]
     */
    private $nameSpaceFolderRules;


    /**
     * @param array|\Skelgen\PhpStorm\NamespaceFolderRule[] $nameSpaceFolderRules
     */
    function __construct( array $nameSpaceFolderRules ) {
        $this->nameSpaceFolderRules = $nameSpaceFolderRules;
    }

    public function getNameSpacedClassName( $fileLocation ) {
        $fileLocation = str_replace( '\\', '/', $fileLocation );
        foreach ( $this->nameSpaceFolderRules as $nameSpaceFolderRule ) {
            preg_match( $nameSpaceFolderRule->getRegex(), $fileLocation, $matches );
            if ( array_key_exists( $nameSpaceFolderRule->getNamespaceRegexOffset(), $matches ) ) {
                return str_replace( '/', '\\', $matches[ $nameSpaceFolderRule->getNamespaceRegexOffset() ] );
            }
        }

        throw new \Exception( $fileLocation . " does not match of these rules :-\n"
            . implode( "\n", $this->nameSpaceFolderRules )
        );
    }
}
