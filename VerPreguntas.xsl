<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" >
<xsl:template match="/">
<HTML>
	<BODY>
		<table border="1"> <thead><tr> <th> Pregunta </th> <th> Respuesta Correcta </th> <th> Respuestas Incorrectas </th> <th> Complejidad </th> <th> Tema </th> <th> Autor </th> </tr></thead><tbody>
		<xsl:for-each select="/assessmentItems/assessmentItem" >
			<tr> 
				<td align="center"> <xsl:value-of select="itemBody/p"/> </td> 
				<td align="center"> <xsl:value-of select="correctResponse/value"/> </td> 
				<td align="center">
				<xsl:for-each select="incorrectResponses/value" >
					<xsl:value-of select="."/> <br/>
				</xsl:for-each>
				</td> 
				<td align="center"> <xsl:value-of select="@complexity"/> </td>
				<td align="center"> <xsl:value-of select="@subject"/> </td>
				<td align="center"> <xsl:value-of select="@author"/> </td>
			</tr>
		</xsl:for-each>
		</tbody></table>
	</BODY>
</HTML>
</xsl:template>
</xsl:stylesheet>