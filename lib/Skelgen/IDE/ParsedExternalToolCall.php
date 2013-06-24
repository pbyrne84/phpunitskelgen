<?php

namespace Skelgen\IDE;


class ParsedExternalToolCall {
    const CLASS_NAME = __CLASS__;

    /** @var string */
    private $nameSpace;

    /** @var string */
    private $fqnClass;


    /**
     * @param $nameSpace
     * @param $fqnClass
     */
    function __construct( $nameSpace, $fqnClass ) {
        $this->nameSpace = $nameSpace;
        $this->fqnClass  = $fqnClass;
    }


    /**
     * @return string
     */
    public function getNameSpace() {
        return $this->nameSpace;
    }


    /**
     * @return string
     */
    public function getFqnClass() {
        return $this->fqnClass;
    }

}
