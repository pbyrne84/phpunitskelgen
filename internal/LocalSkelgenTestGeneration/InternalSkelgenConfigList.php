<?php

namespace LocalSkelgenTestGeneration;


use Skelgen\Config\SkelgenConfigList;

class InternalSkelgenConfigList extends SkelgenConfigList{
    const CLASS_NAME = __CLASS__;


    function __construct() {
        parent::__construct( array( new InternalSkelgenConfig() ) );
    }


}
