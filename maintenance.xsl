<?xml version="1.0"?>
<!--
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// A template to display a table of sold and faied items with a brief summary of total revemue and items at the end
 -->
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl">

    <xsl:output method="html"/>

    <xsl:template match="/">
        <html>
            <body>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Start price</th>
                    <th>Reserve price</th>
                    <th>Duration</th>
                    <th>Item number</th>
                    <th>Start time</th>
                    <th>Start date</th>
                    <th>Status</th>
                    <th>Bidder/buyer ID</th>
                    <th>Bid/buy price</th>
                    <th>Revenue</th>
                </tr>
                <xsl:variable name="inum" select="inum"/>
                <xsl:for-each select="items/item[stt='sold']">
                    <tr>
                        <td><xsl:value-of select="iname"/></td>
                        <td><xsl:value-of select="ctg"/></td>
                        <td><xsl:value-of select="sp"/></td>
                        <td><xsl:value-of select="rp"/></td>
                        <td><xsl:value-of select="durd"/> days <xsl:value-of select="durh"/> hours <xsl:value-of select="durm"/> minutes</td>
                        <td><xsl:value-of select="inum"/></td>
                        <td><xsl:value-of select="st"/></td>
                        <td><xsl:value-of select="sd"/></td>
                        <td><xsl:value-of select="stt"/></td>
                        <td><xsl:value-of select="bid"/></td>
                        <td><xsl:value-of select="bp"/></td>
                        <td><xsl:value-of select="php:functionString('getRev', inum )" /></td>
                    </tr>
                </xsl:for-each>
                <xsl:for-each select="items/item[stt='failed']">
                    <tr>
                        <td><xsl:value-of select="iname"/></td>
                        <td><xsl:value-of select="ctg"/></td>
                        <td><xsl:value-of select="sp"/></td>
                        <td><xsl:value-of select="rp"/></td>
                        <td><xsl:value-of select="durd"/> days <xsl:value-of select="durh"/> hours <xsl:value-of select="durm"/> minutes</td>
                        <td><xsl:value-of select="inum"/></td>
                        <td><xsl:value-of select="st"/></td>
                        <td><xsl:value-of select="sd"/></td>
                        <td><xsl:value-of select="stt"/></td>
                        <td><xsl:value-of select="bid"/></td>
                        <td><xsl:value-of select="bp"/></td>
                        <td><xsl:value-of select="php:functionString('getRev', inum )" /></td>
                    </tr>
                </xsl:for-each>
            </table>
            <div class="panel panel-default">
                <div class="panel-body">
                    <strong>Total revenue: </strong><xsl:value-of select="php:functionString('total', . )" /><br/>
                    <strong>Total number of sold and failed items: </strong><xsl:value-of select="count(/items/item[stt='sold']) + count(/items/item[stt='failed'])"/>
                </div>
            </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
