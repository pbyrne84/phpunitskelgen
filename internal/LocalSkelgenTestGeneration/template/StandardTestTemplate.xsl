<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="text"/>
<xsl:include href="MockPropertyInitialisation.xsl"/>
<xsl:include href="MockCodeInitialisation.xsl"/>
  <xsl:include href="TestedPropertyInitialisation.xsl"/>

  <xsl:template match="/xml">&lt;?php
namespace <xsl:value-of select="namespace"/>;

use Skelgen\InternalBaseTestCase;

class <xsl:value-of select="test_class_name"/> extends InternalBaseTestCase{

    const CLASS_NAME = __CLASS__;
    <xsl:call-template name="InitialiseMockProperties"/>

    /** @var <xsl:value-of select="class_name"/>  */
    private $<xsl:value-of select="class_instance_name"/>;

    protected function setUp() {
        <xsl:call-template name="InitialiseMockCode"/>
        <xsl:call-template name="InitialiseTestPropertyWithMocks">
                <xsl:with-param name="ConstructorMockCode"><xsl:call-template name="GenerateConstructorMockCode"/></xsl:with-param>
        </xsl:call-template>
    }

    public function test_fail(){
        $this->assertTrue(false, 'Add tests' );
    }

}
  </xsl:template>
</xsl:stylesheet>