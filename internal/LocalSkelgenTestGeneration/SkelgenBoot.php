<?php
namespace LocalSkelgenTestGeneration;

use RuntimeException;
use Skelgen\Environment\InitialisationArgumentReader;

class SkelgenBoot {
    const CLASS_NAME = __CLASS__;


    public function bootAndRun() {
        $initialisationArgumentReader = new InitialisationArgumentReader();
        $initialisationConfig         = $initialisationArgumentReader->readInitialisation();
        $internalProjectConfigList    = new InternalSkelgenConfigList();
        $skelgenConfig                = $internalProjectConfigList->matchProjectFileToConfig( $initialisationConfig->getSourceFile() );

        if ( $skelgenConfig == null ) {
            throw new RuntimeException( "'" . $initialisationConfig->getSourceFile() . '" cannot be mapped to skelgen config' );
        }

        if ( $skelgenConfig->hasAutoLoader() ) {
            require_once $skelgenConfig->getAutoLoaderPath( $initialisationConfig->getSourceFile() );
        }

        require_once $initialisationConfig->getSourceFile();

        $JESkelgenRunner = new InternalSkelgenRunner();
        $JESkelgenRunner->runSkelgen( $initialisationConfig, $skelgenConfig );
    }
}
