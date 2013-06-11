<?php
namespace Skelgen\Renderer;

use Skelgen\File\ExistingFile;

class DomXslTransformer {
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $targetEncoding = 'UTF-8';


    /**
     * @param string $sTargetEncoding
     */
    public function setTargetEncoding( $sTargetEncoding ) {
        $this->targetEncoding = $sTargetEncoding;
    }


    /**
     * @param ExistingFile $xslFileLocation
     * @param \DOMDocument $sourceXmlDomDocument
     *
     * @return string
     */
    public function transformDomDocument( ExistingFile $xslFileLocation, \DOMDocument $sourceXmlDomDocument ) {
        $xsltProcessor                 = $this->createXsltProcessor( $xslFileLocation );
        $transformedDocument           = $xsltProcessor->transformToDoc( $sourceXmlDomDocument );
        $transformedDocument->encoding = $this->targetEncoding;
        $saveHtml                      = $transformedDocument->saveHtml();

        return $saveHtml;
    }


    /**
     * @param ExistingFile $sXslFileLocation
     *
     * @return \XSLTProcessor
     */
    private function createXsltProcessor( ExistingFile $sXslFileLocation ) {
        $xslDocument    = $this->createXslDocument( $sXslFileLocation );
        $oXsltProcessor = new \XSLTProcessor();
        $oXsltProcessor->importStylesheet( $xslDocument );

        return $oXsltProcessor;
    }


    /**
     * @param ExistingFile $sXslFileLocation
     *
     * @return \DOMDocument
     */
    private function createXslDocument( ExistingFile $sXslFileLocation ) {
        $xslDocument = new \DOMDocument();
        $xslDocument->load( $sXslFileLocation->getRealPath() );

        return $xslDocument;
    }

}