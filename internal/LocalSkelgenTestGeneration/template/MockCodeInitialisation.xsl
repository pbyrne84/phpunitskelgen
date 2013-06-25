<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/xml" name="InitialiseMockCode">
    <xsl:variable name="mockPropertyCount" select="count( constructor_injections/injection[@has_hint='1'] )"/>
    <xsl:if test="$mockPropertyCount > 0">

   <xsl:for-each select="constructor_injections/injection[@has_hint='1']">
        $this-><xsl:value-of select="name"/> = \mock( \<xsl:value-of select="type_hint"/>::CLASS_NAME );</xsl:for-each>
    </xsl:if>

  </xsl:template>


  <xsl:template match="/xml" name="GenerateConstructorMockCode">
    <xsl:variable name="mockPropertyCount" select="count( constructor_injections/injection[@has_hint='1'] )"/>
    <xsl:if test="$mockPropertyCount > 0">

   <xsl:for-each select="constructor_injections/injection[@has_hint='1']">
            $this-><xsl:value-of select="name"/> <xsl:if test="position() &lt; $mockPropertyCount">,</xsl:if>
   </xsl:for-each>
   </xsl:if>
  </xsl:template>

</xsl:stylesheet>