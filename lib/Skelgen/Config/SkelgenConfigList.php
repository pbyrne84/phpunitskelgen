<?php

namespace Skelgen\Config;


use Skelgen\File\VerifiedFileSystemResource;

class SkelgenConfigList extends \ArrayObject{
    const CLASS_NAME = __CLASS__;

    /**
     * @param \Skelgen\File\VerifiedFileSystemResource $verifiedFileSystemResource
     *
     * @return null|SkelgenConfig
     */
    public function matchProjectFileToConfig( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        /** @var $this SkelgenConfig[] */
        foreach ( $this as $skelgenConfig ) {
            if ( $skelgenConfig->isProject( $verifiedFileSystemResource ) ) {
                return $skelgenConfig;
            }
        }

        return null;
    }
}
