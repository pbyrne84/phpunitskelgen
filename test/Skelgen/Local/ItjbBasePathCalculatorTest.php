<?php
namespace Skelgen\Local;

class ItjbBasePathCalculatorTest extends \PHPUnit_Framework_TestCase {
    const CLASS_NAME = __CLASS__;


    /**
     * @var ItjbBasePathCalculator
     */
    private $itjbBasePathCalculator;


    protected function setUp() {
        $this->itjbBasePathCalculator = new ItjbBasePathCalculator();
    }


    public function test_calculateBasePath_isCalculatedForItjb() {
        $itjbPath = 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\modules\JE\SolrPhpClient\tests\Apache\Solr\Service\BalancerTest.php';
        $basePath = $this->itjbBasePathCalculator->calculateBasePath( new \Skelgen\File\ExistingFile( $itjbPath ) );
        $this->assertEquals( 'J:/inetpub/wwwroot/dev.itjb4.local/ITJB1/', $basePath );
    }

}
