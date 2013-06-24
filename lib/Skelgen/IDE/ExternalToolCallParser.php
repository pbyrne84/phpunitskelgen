<?php

namespace Skelgen\IDE;


class ExternalToolCallParser {
    const CLASS_NAME = __CLASS__;


    public function parseCall( $fileLocation ) {
        $classContents = file_get_contents( $fileLocation );

        preg_match( '~(\s*)namespace(\s+)(.*);~', $classContents, $matches );
        $nameSpace = $matches[ 3 ];

        preg_match( '~(\s*)class(\s+)([^\s|.]*)(.*){~i', $classContents, $matches );
        $className = $matches[ 3 ];

        $fqnClass = trim( $nameSpace ) . '\\' . trim( $className );

        return new ParsedExternalToolCall( $nameSpace, $fqnClass );
    }
}
