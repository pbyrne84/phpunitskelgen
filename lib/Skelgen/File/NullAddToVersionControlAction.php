<?php

namespace Skelgen\File;


class NullAddToVersionControlAction implements AddToVersionControlAction {
    const CLASS_NAME = __CLASS__;


    public function addToVersionControl( ExistingDirectory $directory ) {
    }
}
