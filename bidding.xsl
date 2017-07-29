<!--
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// A template to display the items on bidding page for customer to view

 -->
<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl">

    <xsl:output method="html"/>

    <xsl:template match="/">
        <html>
            <body>
                <xsl:for-each select="items/item">
                    <div class="col-xs-offset-1 col-xs-10 panel panel-default">
                        <div class="panel-body">

                            <div class="col-sm-offset-4">
                                <strong>Item No:</strong> <span id="inum">
                                    <xsl:value-of select="inum"/>
                                    <xsl:variable name="inum" select="inum"/></span>
                                <br/>
                                <strong>Item Name:</strong> <span id="iname">
                                    <xsl:value-of select="iname"/></span>
                                <br/>
                                <strong>Category:</strong> <span id="ctg">
                                    <xsl:value-of select="ctg"/></span>
                                <br/>
                                <strong>Description:</strong> <span id="desc">
                                    <xsl:value-of select="desc"/></span>
                                <br/>
                                <strong>Buy It Now Price:</strong> <span id="binp">
                                    <xsl:value-of select="binp"/></span>
                                <br/>
                                <strong>Bid Price:</strong> <span id="bp">
                                    <xsl:value-of select="bp"/></span>
                                <br/>

                                <div class="timeleft"><em>
                                    <xsl:value-of select="php:functionString('timeLeft', inum )" /></em></div>
                                <br/>
                            </div>
                            <button>
                                <xsl:attribute name="onclick">javascript: bid(
                                <xsl:value-of select="inum"/>) </xsl:attribute>
                                <xsl:attribute name="class">col-sm-offset-1 col-sm-5 btn btn-info</xsl:attribute>
                                Place Bid
                            </button>
                            <button>
                                <xsl:attribute name="onclick">javascript: buy(
                                <xsl:value-of select="inum"/>) </xsl:attribute>
                                <xsl:attribute name="class">col-sm-5 btn btn-warning</xsl:attribute>
                                <xsl:attribute name="style">margin-left:5px</xsl:attribute>
                                Buy It Now
                            </button>

                            <br/>
                        </div>
                    </div>
                </xsl:for-each>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
