<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:strip-space elements="*" />
  <xsl:output method="text"/>

  <xsl:template match="/xml" name="TestPropertyFieldDeclaration">
    /** @var <xsl:value-of select="class_name"/>  */
    private $<xsl:value-of select="class_instance_name"/>;
  </xsl:template>

  <xsl:template match="/xml" name="InitialiseTestPropertyWithMocks" xml:space="default" >
    <xsl:param name="ConstructorMockCode" select="''" />
        $this-><xsl:value-of select="class_instance_name"/> = new <xsl:value-of select="class_name"/>(<xsl:value-of
          select="$ConstructorMockCode"/>
        );</xsl:template>
</xsl:stylesheet>