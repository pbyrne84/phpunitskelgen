<?php

spl_autoload_register( function ( $className ) {
    if( strpos( $className, 'Skelgen' ) === 0 )  {
        $className = str_replace( '\\', '/', $className );

        return require_once __DIR__ . '/lib/' . $className . '.php';
    }

    return false;
});