<?php
namespace Skelgen\PhpStorm;

class NamespaceFolderRule {
    /**
     * @var string
     */
    private $regex;

    /**
     * @var int
     */
    private $namespaceRegexOffset;

    /**
     * @param int $namespaceRegexOffset
     * @param string $regex
     */
    function __construct( $namespaceRegexOffset, $regex  ) {
        $this->namespaceRegexOffset = $namespaceRegexOffset;
        $this->regex                = $regex;
    }

    /**
     * @return int
     */
    public function getNamespaceRegexOffset() {
        return $this->namespaceRegexOffset;
    }

    /**
     * @return string
     */
    public function getRegex() {
        return $this->regex;
    }


    function __toString() {
        return print_r( $this, true );
    }

}
