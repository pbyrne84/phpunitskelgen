<?php

spl_autoload_register( function ( $className ) {
    if( strpos( $className, 'Skelgen' ) === 0 )  {
        return require_once __DIR__ . '/lib/' . $className . '.php';
    }

    return require_once $className . '.php';

});