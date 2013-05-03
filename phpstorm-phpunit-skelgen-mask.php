<?php

use Skelgen\PhpStorm\NamespaceFolderRule;

require_once __DIR__ . '/../Skelgen/lib/Skelgen/PhpStorm/NamespaceFolderRule.php';
require_once __DIR__ . '/../Skelgen/lib/Skelgen/PhpStorm/NamespaceClassNameAnalyser.php';


$fileLocation = $_SERVER[ 'argv' ][ 1 ];

$rules = array();
$rules[] = new NamespaceFolderRule( 2, '~J:/inetpub/wwwroot/dev\.jars4\.local/kryten(.*)/PHP/(Jars.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~J:/inetpub/wwwroot/dev\.jars4\.local/kryten(.*)/PHP/modules/(JE.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~C:/Program Files/eclipse/local_workspace/workspace(.*)/kryten/PHP/(Jars.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~C:/Program Files/eclipse/local_workspace/workspace(.*)/kryten/PHP/modules/(JE.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~J:/inetpub/wwwroot/dev\.jme\.local/jme(.*)/PHP/(JME.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~J:/inetpub/wwwroot/dev\.matchingservice\.local/matchingservice(.*)/PHP/modules/(.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~J:/inetpub/wwwroot/dev\.matchingservice\.local/matchingservice(.*)/PHP/(matchingservice.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~C:/Program Files/eclipse/local_workspace/workspace(.*)/itjb/PHP/(itjb.*)\.php~i' );
$rules[] = new NamespaceFolderRule( 2, '~C:/Program Files/eclipse/local_workspace/workspace(.*)/itjb/PHP/modules/(JE.*)\.php~i' );

$namesSpacedClassNameAnalyser = new \Skelgen\PhpStorm\NamespaceClassNameAnalyser( $rules );

$className    = $namesSpacedClassNameAnalyser->getNameSpacedClassName( $fileLocation );

$maskedPhpUnitSkelgenCall = __DIR__ . '/phpunit-skelgen.bat dummy dummy ' . $className . ' ' . '"' . $fileLocation . '"';

echo exec( $maskedPhpUnitSkelgenCall, $output );
var_dump( implode( "\n", $output ) );
