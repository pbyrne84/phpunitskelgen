<?php

namespace Skelgen\File;


interface VerifiedFileSystemResourceMarker {

    /**
     * @return string
     */
    public function getRealPath();
}
