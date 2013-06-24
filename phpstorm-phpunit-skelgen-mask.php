<?php
//Phpstorm removed the internal way of hooking into the skelgen so we have to calculate the full qualified name.

use Skelgen\IDE\ExternalToolCallParser;

require_once __DIR__ . '/lib/Skelgen/IDE/ParsedExternalToolCall.php';
require_once __DIR__. '/lib/Skelgen/IDE/ExternalToolCallParser.php';

$fileLocation = $_SERVER[ 'argv' ][ 1 ];
$externalToolCallParser = new ExternalToolCallParser();
$externalToolCall = $externalToolCallParser->parseCall( $fileLocation );

$maskedPhpUnitSkelgenCall
        = __DIR__ . '/phpunit-skelgen.bat dummy dummy ' . $externalToolCall->getFqnClass() . ' ' . '"' . $fileLocation . '"';

echo exec( $maskedPhpUnitSkelgenCall, $output );


