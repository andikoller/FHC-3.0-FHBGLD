<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="xml" version="1.0" indent="yes"/>
	<xsl:template match="zeugnisse">
		<fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">
			<fo:layout-master-set>
				<fo:simple-page-master page-height="297mm" page-width="210mm" margin="5mm 25mm 5mm 25mm" master-name="PageMaster">
					<fo:region-body margin="20mm 0mm 20mm 0mm"/>
				</fo:simple-page-master>
			</fo:layout-master-set>
			<xsl:apply-templates select="zeugnis"/>
		</fo:root>
	</xsl:template>
	<xsl:template match="zeugnis">
		<fo:page-sequence master-reference="PageMaster">
			<fo:flow flow-name="xsl-region-body">
				<fo:block-container position="absolute" top="30mm" left="30mm" height="20mm">
					<fo:block text-align="left" line-height="18pt" font-family="sans-serif" font-size="16pt">
						<fo:inline font-weight="900">
							<xsl:text>Transcript of Records \n </xsl:text>
							<xsl:choose>
								<xsl:when test="string-length(semester_bezeichnung)=0">
									<xsl:value-of select="stsem"/>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="semester"/>
									<xsl:choose>
										<xsl:when test="semester=1">
											<xsl:text>st</xsl:text>
										</xsl:when>
										<xsl:when test="semester=2">
											<xsl:text>nd</xsl:text>
										</xsl:when>
										<xsl:when test="semester=3">
											<xsl:text>rd</xsl:text>
										</xsl:when>
										<xsl:otherwise>
											<xsl:text>th</xsl:text>
										</xsl:otherwise>
									</xsl:choose>
									<xsl:text> Semester (</xsl:text>
									<xsl:value-of select="stsem"/>
									<xsl:text>)</xsl:text>
								</xsl:otherwise>
							</xsl:choose>
						</fo:inline>
					</fo:block>
				</fo:block-container>
				<fo:block-container position="absolute" top="47mm" left="31.5mm" height="20mm">
					<fo:block text-align="left" line-height="18pt" font-family="sans-serif" font-size="16pt">
						<xsl:value-of select="studiengang_art"/> Degree Program
					</fo:block>
				</fo:block-container>
				<fo:block-container position="absolute" top="54mm" left="30mm" height="20mm">
					<fo:block text-align="left" line-height="18pt" font-family="sans-serif" font-size="16pt">
						<fo:inline font-weight="900">
							<xsl:value-of select="studiengang_englisch"/>
						</fo:inline>
					</fo:block>
				</fo:block-container>
				<fo:block-container position="absolute" top="75mm" left="158mm">
						<fo:block line-height="14pt" font-family="sans-serif" font-size="10pt">
							<xsl:text>Student ID: </xsl:text>
						</fo:block>
					</fo:block-container>
					<fo:block-container position="absolute" top="75mm" left="177mm">
						<fo:block content-width="80mm" line-height="14pt" font-family="sans-serif" font-size="10pt" font-weight="bold">
							<xsl:value-of select="matrikelnr" />
						</fo:block>
					</fo:block-container>
					<fo:block-container position="absolute" top="80mm" left="164mm">
						<fo:block line-height="14pt" font-family="sans-serif" font-size="10pt">
							<xsl:text>Program Code: </xsl:text>
						</fo:block>
					</fo:block-container>
					<fo:block-container position="absolute" top="80mm" left="189mm">
						<fo:block content-width="80mm" line-height="14pt" font-family="sans-serif" font-size="10pt" font-weight="bold">
							<xsl:value-of select="studiengang_kz" />
						</fo:block>
					</fo:block-container> 
				<fo:block-container position="absolute" top="100mm" left="30mm" height="10mm">
					<fo:table table-layout="fixed" border-collapse="collapse">
						<fo:table-column column-width="45mm"/>
						<fo:table-column column-width="100mm"/>
						<fo:table-body>
							<fo:table-row line-height="15pt">
								<fo:table-cell>
									<fo:block font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="left">
										<xsl:text>First Name/Last Name: </xsl:text>
									</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block font-family="sans-serif" font-size="12pt" content-width="150mm" text-align="left">
										<fo:inline font-weight="900">
											<xsl:value-of select="name"/>
										</fo:inline>
									</fo:block>
								</fo:table-cell>
							</fo:table-row>
							<fo:table-row line-height="15pt">
								<fo:table-cell>
									<fo:block font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="left">
										<xsl:text>Date of Birth: </xsl:text>
									</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="left">
										<xsl:text> </xsl:text>
										<xsl:value-of select="gebdatum"/>
									</fo:block>
								</fo:table-cell>
							</fo:table-row>
						</fo:table-body>
					</fo:table>
				</fo:block-container>
				<fo:block-container position="absolute" top="116mm" left="30mm">
					<fo:table table-layout="fixed" border-collapse="collapse" border-width="0.2pt" border-style="solid">
						<fo:table-column column-width="100mm"/>
						<fo:table-column column-width="20mm"/>
						<fo:table-column column-width="25mm"/>
						<fo:table-column column-width="20mm"/>
						<fo:table-body>
							<fo:table-row line-height="14pt">
								<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
									<fo:block font-size="12pt" font-weight="bold">
										 Subject\n
										 
										</fo:block>
								</fo:table-cell>
								<fo:table-cell border-width="0.2mm" border-style="solid"  display-align="center">
									<fo:block font-size="12pt" font-weight="bold" content-width="20mm" text-align="center">
										Grade\n
										
										</fo:block>
								</fo:table-cell>
								<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
									<fo:block font-size="10pt" font-weight="bold" content-width="25mm" text-align="center">
										Hours/Week/ Semester
										</fo:block>
								</fo:table-cell>
								<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
									<fo:block font-size="12pt" font-weight="bold" content-width="20mm" text-align="center">
										ECTS Points
										</fo:block>
								</fo:table-cell>
							</fo:table-row>
							<xsl:apply-templates select="unterrichtsfach"/>
							<!--<fo:table-row line-height="0pt">
									<fo:table-cell border-width="0.2mm" border-style="solid" ></fo:table-cell>
									<fo:table-cell border-width="0.2mm" border-style="solid" ></fo:table-cell>
									<fo:table-cell border-width="0.2mm" border-style="solid" ></fo:table-cell>
									<fo:table-cell border-width="0.2mm" border-style="solid" ></fo:table-cell>
								</fo:table-row>-->
							<xsl:apply-templates select="fussnote"/>
						</fo:table-body>
					</fo:table>
					<fo:block font-size="7pt">\n</fo:block>
					<fo:table>
						<fo:table-column column-width="20mm"/>
						<fo:table-column column-width="160mm"/>
							<fo:table-body>
								<fo:table-row>
									<fo:table-cell>
									<fo:block font-size="7pt">Grades: </fo:block>
									</fo:table-cell>
									<fo:table-cell>
									<fo:block font-size="7pt">excellent (1), very good (2), good (3), satisfactory (4), fail (5), not graded (nb), Credit based on previous experience/work (ar)</fo:block>
									</fo:table-cell>
								</fo:table-row>
								<fo:table-row>
									<fo:table-cell>
									<fo:block font-size="7pt"></fo:block>
									</fo:table-cell>
									<fo:table-cell>
									<fo:block font-size="7pt">non-credit participation (na), participated(t), passed (b), successfully completed (ea), not successfully completed (nea)</fo:block>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>
				</fo:block-container>
				<fo:block-container position="absolute" top="250mm" left="30mm" height="10mm">
					<fo:table table-layout="fixed" border-collapse="collapse">
						<fo:table-column column-width="75mm"/>
						<fo:table-column column-width="15mm"/>
						<fo:table-column column-width="75mm"/>
						<fo:table-body>
							<fo:table-row line-height="12pt">
								<fo:table-cell>
									<fo:block font-size="8pt" content-width="75mm" text-align="center">
										</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block>
										</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block font-size="10pt" content-width="75mm" text-align="center">
										Vienna, <xsl:value-of select="ort_datum"/>
									</fo:block>
								</fo:table-cell>
							</fo:table-row>
							<fo:table-row line-height="8pt">
								<fo:table-cell>
									<fo:block font-size="8pt" font-weight="bold" content-width="75mm" text-align="center">
											______________________________________
										</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block/>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block font-size="8pt" font-weight="bold" content-width="75mm" text-align="center">
											______________________________________
										</fo:block>
								</fo:table-cell>
							</fo:table-row>
							<fo:table-row line-height="10pt">
								<fo:table-cell>
									<fo:block font-size="8pt" content-width="75mm" text-align="center">
										<xsl:value-of select="studiengangsleiter"/>
										<xsl:text>\nHead of Study Programme</xsl:text>
									</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block>
										</fo:block>
								</fo:table-cell>
								<fo:table-cell>
									<fo:block font-size="8pt" content-width="75mm" text-align="center">
										Place, Date
										</fo:block>
								</fo:table-cell>
							</fo:table-row>
						</fo:table-body>
					</fo:table>
				</fo:block-container>
				<fo:block-container position="absolute" top="290mm" left="30mm" height="10mm">
					<fo:table table-layout="fixed" border-collapse="collapse">
						<fo:table-column column-width="185mm"/>
							<fo:table-body>
								<fo:table-row  line-height="10pt" >
									<fo:table-cell>
										<fo:block font-size="8pt" content-width="185mm" text-align="left">
											<xsl:text>Fachhochschule Technikum Wien, Hoechstaedtplatz 5, 1200 Vienna, AUSTRIA, ZVR-Nr.: 074476426, DVR-Nr.:0928381</xsl:text>
										</fo:block>
									</fo:table-cell>
								</fo:table-row>
							</fo:table-body>
						</fo:table>
				</fo:block-container>
			</fo:flow>
		</fo:page-sequence>
	</xsl:template>
	<xsl:template match="unterrichtsfach">
		<fo:table-row line-height="12pt">
			<fo:table-cell display-align="center" border-width="0.2mm" border-style="solid">
				<fo:block font-size="10pt" content-width="97mm">
					<xsl:text> </xsl:text>
					<xsl:choose>
						<xsl:when test="bisio_von">
					    International Semester Abroad: <xsl:value-of select="bisio_von"/>-<xsl:value-of select="bisio_bis"/>, at <xsl:value-of select="bisio_ort"/>, <xsl:value-of select="bisio_universitaet"/>
						\n All credits earned during the International Semester Abroad (ISA) are fully credited for the 
									<xsl:value-of select="../semester"/>
									<xsl:choose>
										<xsl:when test="../semester=1">
											<xsl:text>st</xsl:text>
										</xsl:when>
										<xsl:when test="../semester=2">
											<xsl:text>nd</xsl:text>
										</xsl:when>
										<xsl:when test="../semester=3">
											<xsl:text>rd</xsl:text>
										</xsl:when>
										<xsl:otherwise>
											<xsl:text>th</xsl:text>
										</xsl:otherwise>
									</xsl:choose>. semester at the UAS Fachhochschule Technikum Wien. (see Transcript of Records)
					  </xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="bezeichnung_englisch"/>
						</xsl:otherwise>
					</xsl:choose>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
				<fo:block font-size="10pt" content-width="20mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="note"/>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
				<fo:block font-size="10pt" content-width="25mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="sws"/>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid" display-align="center">
				<fo:block font-size="10pt" content-width="20mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="ects"/>
				</fo:block>
			</fo:table-cell>
		</fo:table-row>
	</xsl:template>
	<xsl:template match="fussnote">
		<fo:table-row line-height="11pt">
			<fo:table-cell border-width="0.2mm" border-style="solid">
				<fo:block font-size="9pt" content-width="95mm">
					<xsl:value-of select="fussnotenzeichen"/>
					<xsl:text> </xsl:text>
					<fo:inline font-weight="bold">
						<xsl:choose>
							<xsl:when test="themenbereich_bezeichnung='Themenbereich: '">
								<xsl:text>Subject Area:</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text></xsl:text>
							</xsl:otherwise>
						</xsl:choose>
						<xsl:text> </xsl:text>
					</fo:inline>
					<xsl:value-of select="themenbereich"/>
					<xsl:text> </xsl:text>
					<fo:inline font-weight="bold">
						<xsl:choose>
							<xsl:when test="titel_bezeichnung='Bachelorarbeit:'">
								<xsl:text>Bachelor Thesis:</xsl:text>
							</xsl:when>
							<xsl:when test="titel_bezeichnung='Diplomarbeit:'">
								<xsl:text>Diploma Thesis:</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text></xsl:text>
							</xsl:otherwise>
						</xsl:choose>
						<xsl:text> </xsl:text>
					</fo:inline>
					<xsl:value-of select="titel"/>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid">
				<fo:block font-size="9pt" content-width="20mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="note"/>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid">
				<fo:block font-size="9pt" content-width="25mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="sws"/>
				</fo:block>
			</fo:table-cell>
			<fo:table-cell border-width="0.2mm" border-style="solid">
				<fo:block font-size="9pt" content-width="20mm" text-align="center">
					<xsl:text> </xsl:text>
					<xsl:value-of select="ects"/>
				</fo:block>
			</fo:table-cell>
		</fo:table-row>
	</xsl:template>
</xsl:stylesheet>
