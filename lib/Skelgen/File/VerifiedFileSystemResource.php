<?php

namespace Skelgen\File;


/**
 * Class VerifiedFileSystemResourceMarker
 * @package Skelgen\File
 *
 * Interface to indicate that the resource is realpath safe and has been verified on construction.
 *
 */
interface VerifiedFileSystemResource {

    /**
     * Always returns a forward slashed variant of realpath for cross os comparative reasons
     *
     * @return string
     */
    public function getNormalisedRealPath();
}
