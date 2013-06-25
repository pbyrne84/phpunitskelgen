<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/xml" name="InitialiseMockProperties">
    <xsl:variable name="mockPropertyCount" select="count( constructor_injections/injection[@has_hint='1'] )"/>
    <xsl:if test="$mockPropertyCount > 0">

    <xsl:for-each select="constructor_injections/injection[@has_hint='1']">
    /** @var \<xsl:value-of select="type_hint"/> */
    private  $<xsl:value-of select="name"/>;
    </xsl:for-each>
    </xsl:if>

  </xsl:template>

</xsl:stylesheet>