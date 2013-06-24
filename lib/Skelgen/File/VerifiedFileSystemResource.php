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
     * @return string
     */
    public function getRealPath();
}
