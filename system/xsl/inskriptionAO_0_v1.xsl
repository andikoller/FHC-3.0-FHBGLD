<<<<<<< HEAD
<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:fo="http://www.w3.org/1999/XSL/Format"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:output method="xml" version="1.0" indent="yes" />
	
	<xsl:template match="studenten">
		<fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">
			<fo:layout-master-set>
				<fo:simple-page-master page-height="297mm" page-width="210mm" margin="5mm 25mm 5mm 25mm" master-name="PageMaster">
					<fo:region-body margin="20mm 0mm 20mm 0mm"/>
				</fo:simple-page-master>
			</fo:layout-master-set>
			<xsl:apply-templates select="student"/>
		</fo:root>
	</xsl:template>
	
	<xsl:template match="student">					
			<fo:page-sequence master-reference="PageMaster">
				<fo:flow flow-name="xsl-region-body" >
	
					<fo:block-container position="absolute" top="40pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="14pt">
							Studienbestätigung außerordentliches Studium FH Technikum Wien
						</fo:block>
					</fo:block-container> 
									
					<fo:block-container position="absolute" top="60pt" left="30pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="140mm"/>
								<fo:table-body>
						            <fo:table-row line-height="30pt">
						                    <fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
											<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="6pt"> 
												<fo:inline vertical-align="super">
													Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)
												</fo:inline>
											</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container>

					<fo:block-container position="absolute" top="76pt" left="445pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt"> 
							<fo:inline vertical-align="super">
								Personenkennzeichen
							</fo:inline>
						</fo:block>
					</fo:block-container>

					<fo:block-container position="absolute" top="91pt" left="428pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="45mm"/>
								<fo:table-body>
						            <fo:table-row line-height="25pt">
										<fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
										<fo:block line-height="12pt" font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="center">
											<xsl:value-of select="matrikelnummer" />
										</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container> 


					<fo:block-container position="absolute" top="96pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="10pt">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="120pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
							ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
							als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
							im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="150pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="150pt" left="360pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="170pt" left="50pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </fo:block>
					</fo:block-container> 
<!-- Abschnitt 2  -->

					<fo:block-container position="absolute" top="190pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="14pt">
							Studienbestätigung außerordentliches Studium FH Technikum Wien
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="210pt" left="30pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="140mm"/>
								<fo:table-body>
						            <fo:table-row line-height="30pt">
						                    <fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
											<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="6pt"> 
												<fo:inline vertical-align="super">
													Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)
												</fo:inline>
											</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container>

					<fo:block-container position="absolute" top="226pt" left="445pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt"> 
							<fo:inline vertical-align="super">
								Personenkennzeichen
							</fo:inline>
						</fo:block>
					</fo:block-container>

					<fo:block-container position="absolute" top="241pt" left="428pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="45mm"/>
								<fo:table-body>
						            <fo:table-row line-height="25pt">
										<fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
										<fo:block line-height="12pt" font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="center">
											<xsl:value-of select="matrikelnummer" />
										</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container> 

					<fo:block-container position="absolute" top="246pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="10pt">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="270pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
							ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
							als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
							im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="300pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="300pt" left="360pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="320pt" left="50pt" height="30pt">
                            <fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
							</fo:block>
					</fo:block-container> 

<!-- Abschnitt 3  -->

					<fo:block-container position="absolute" top="340pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="14pt">
							Studienbestätigung außerordentliches Studium FH Technikum Wien
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="360pt" left="30pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="140mm"/>
								<fo:table-body>
						            <fo:table-row line-height="30pt">
						                    <fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
											<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="6pt"> 
												<fo:inline vertical-align="super">
													Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)
												</fo:inline>
											</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container>


					<fo:block-container position="absolute" top="376pt" left="445pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt"> 
							<fo:inline vertical-align="super">
								Personenkennzeichen
							</fo:inline>
						</fo:block>
					</fo:block-container>

					<fo:block-container position="absolute" top="391pt" left="428pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="45mm"/>
								<fo:table-body>
						            <fo:table-row line-height="25pt">
										<fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
										<fo:block line-height="12pt" font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="center">
											<xsl:value-of select="matrikelnummer" />
										</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container> 

					<fo:block-container position="absolute" top="396pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="10pt">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="420pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
							ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
							als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
							im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="450pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="450pt" left="360pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="470pt" left="50pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </fo:block>
					</fo:block-container> 

<!-- Abschnitt 4  -->

					<fo:block-container position="absolute" top="490pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="14pt">
							Studienbestätigung außerordentliches Studium FH Technikum Wien
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="510pt" left="30pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="140mm"/>
								<fo:table-body>
						            <fo:table-row line-height="30pt">
						                    <fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
											<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="6pt"> 
												<fo:inline vertical-align="super">
													Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)
												</fo:inline>
											</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container>


					<fo:block-container position="absolute" top="526pt" left="445pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt"> 
							<fo:inline vertical-align="super">
								Personenkennzeichen
							</fo:inline>
						</fo:block>
					</fo:block-container>

					<fo:block-container position="absolute" top="541pt" left="428pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="45mm"/>
								<fo:table-body>
						            <fo:table-row line-height="25pt">
										<fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
										<fo:block line-height="12pt" font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="center">
											<xsl:value-of select="matrikelnummer" />
										</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container> 


					<fo:block-container position="absolute" top="546pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="10pt">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="570pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
							ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
							als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
							im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="600pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="600pt" left="360pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" />
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="620pt" left="50pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        </fo:block>
					</fo:block-container> 

<!-- Abschnitt 5  -->

					<fo:block-container position="absolute" top="640pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="14pt">
							Studienbestätigung außerordentliches Studium FH Technikum Wien
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="660pt" left="30pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="140mm"/>
								<fo:table-body>
						            <fo:table-row line-height="30pt">
						                    <fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
											<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="6pt"> 
												<fo:inline vertical-align="super">
													Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)
												</fo:inline>
											</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container>


					<fo:block-container position="absolute" top="676pt" left="445pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt"> 
							<fo:inline vertical-align="super">
								Personenkennzeichen
							</fo:inline>
						</fo:block>
					</fo:block-container>

					<fo:block-container position="absolute" top="691pt" left="428pt" height="20pt">
						<fo:table table-layout="fixed" border-collapse="separate">
						    <fo:table-column column-width="45mm"/>
								<fo:table-body>
						            <fo:table-row line-height="25pt">
										<fo:table-cell border-align="right" border-width="0.2mm" border-style="solid" >
										<fo:block line-height="12pt" font-family="sans-serif" font-size="10pt" content-width="45mm" text-align="center">
											<xsl:value-of select="matrikelnummer" />
										</fo:block>
									</fo:table-cell>
								</fo:table-row>      
							</fo:table-body>
						</fo:table>
					</fo:block-container> 


					<fo:block-container position="absolute" top="696pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="10pt">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="720pt" left="30pt" height="30pt">
						<fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
							geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
							ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
							als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
							im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
						</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="750pt" left="30pt" height="30pt">
                            <fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
								Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381
							</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="750pt" left="360pt" height="30pt">
                            <fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
								Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" />
							</fo:block>
					</fo:block-container> 

					<fo:block-container position="absolute" top="770pt" left="50pt" height="30pt">
                            <fo:block text-align="left" line-height="12pt" font-family="sans-serif" font-size="8pt">
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
							</fo:block>
					</fo:block-container> 
			</fo:flow>
		</fo:page-sequence>
	</xsl:template>
</xsl:stylesheet >
=======
<xsl:stylesheet xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0"
>

<xsl:output method="xml" version="1.0" indent="yes"/>
<xsl:template match="studenten">

<office:document-content xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0" xmlns:fo="urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:meta="urn:oa...(line truncated)...
	<office:scripts/>
	<office:font-face-decls>
		<style:font-face style:name="Mangal2" svg:font-family="Mangal"/>
        <style:font-face style:name="Mangal" svg:font-family="Mangal" style:font-family-generic="roman"/>
        <style:font-face style:name="Liberation Serif" svg:font-family="&apos;Liberation Serif&apos;" style:font-family-generic="roman" style:font-pitch="variable"/>
        <style:font-face style:name="Arial" svg:font-family="Arial" style:font-adornments="Standard" style:font-family-generic="swiss" style:font-pitch="variable"/>
        <style:font-face style:name="Liberation Sans" svg:font-family="&apos;Liberation Sans&apos;" style:font-family-generic="swiss" style:font-pitch="variable"/>
        <style:font-face style:name="Liberation Sans1" svg:font-family="&apos;Liberation Sans&apos;" style:font-family-generic="system" style:font-pitch="variable"/>
        <style:font-face style:name="Mangal1" svg:font-family="Mangal" style:font-family-generic="system" style:font-pitch="variable"/>
        <style:font-face style:name="Microsoft YaHei" svg:font-family="&apos;Microsoft YaHei&apos;" style:font-family-generic="system" style:font-pitch="variable"/>
        <style:font-face style:name="SimSun" svg:font-family="SimSun" style:font-family-generic="system" style:font-pitch="variable"/>
        <style:font-face style:name="Tahoma" svg:font-family="Tahoma" style:font-family-generic="system" style:font-pitch="variable"/>
	</office:font-face-decls>
	<office:automatic-styles>
		<style:style style:name="Tabelle1" style:family="table">
			<style:table-properties style:width="17.701cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle1.A" style:family="table-column">
			<style:table-column-properties style:column-width="12.991cm"/>
		</style:style>
		<style:style style:name="Tabelle1.B" style:family="table-column">
			<style:table-column-properties style:column-width="4.71cm"/>
		</style:style>
		<style:style style:name="Tabelle1.1" style:family="table-row">
			<style:table-row-properties style:min-row-height="1.100cm"/>
		</style:style>
		<style:style style:name="Tabelle1.2" style:family="table-row">
			<style:table-row-properties style:min-row-height="0.500cm"/>
		</style:style>
		<style:style style:name="Tabelle1.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle1.B1" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="bottom" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle1.A2" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="middle" style:min-row-height="0.600cm" fo:padding="0.0cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle1.B2" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle2" style:family="table">
			<style:table-properties style:width="17.7cm" fo:margin-left="0cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle2.A" style:family="table-column">
			<style:table-column-properties style:column-width="8,850cm"/>
		</style:style>
		<style:style style:name="Tabelle2.B" style:family="table-column">
			<style:table-column-properties style:column-width="8,851cm"/>
		</style:style>
		<style:style style:name="Tabelle2.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.0cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle3" style:family="table">
			<style:table-properties style:width="17.701cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle3.A" style:family="table-column">
			<style:table-column-properties style:column-width="12.991cm"/>
		</style:style>
		<style:style style:name="Tabelle3.B" style:family="table-column">
			<style:table-column-properties style:column-width="4.71cm"/>
		</style:style>
		<style:style style:name="Tabelle3.1" style:family="table-row">
			<style:table-row-properties style:min-row-height="1.005cm"/>
		</style:style>
		<style:style style:name="Tabelle3.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle3.B1" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="bottom" fo:padding="0.097cm" fo:border-left="0.05pt solid #000000" fo:border-right="none" fo:border-top="none" fo:border-bottom="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle3.A2" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="middle" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle4" style:family="table">
			<style:table-properties style:width="17.013cm" fo:margin-left="0cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle4.A" style:family="table-column">
			<style:table-column-properties style:column-width="7.911cm"/>
		</style:style>
		<style:style style:name="Tabelle4.B" style:family="table-column">
			<style:table-column-properties style:column-width="9.102cm"/>
		</style:style>
		<style:style style:name="Tabelle4.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle5" style:family="table">
			<style:table-properties style:width="17.701cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle5.A" style:family="table-column">
			<style:table-column-properties style:column-width="12.991cm"/>
		</style:style>
		<style:style style:name="Tabelle5.B" style:family="table-column">
			<style:table-column-properties style:column-width="4.71cm"/>
		</style:style>
		<style:style style:name="Tabelle5.1" style:family="table-row">
			<style:table-row-properties style:min-row-height="1.005cm"/>
		</style:style>
		<style:style style:name="Tabelle5.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle5.B1" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="bottom" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle5.A2" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="middle" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle6" style:family="table">
			<style:table-properties style:width="17.013cm" fo:margin-left="0cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle6.A" style:family="table-column">
			<style:table-column-properties style:column-width="7.911cm"/>
		</style:style>
		<style:style style:name="Tabelle6.B" style:family="table-column">
			<style:table-column-properties style:column-width="9.102cm"/>
		</style:style>
		<style:style style:name="Tabelle6.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle7" style:family="table">
			<style:table-properties style:width="17.701cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle7.A" style:family="table-column">
			<style:table-column-properties style:column-width="12.991cm"/>
		</style:style>
		<style:style style:name="Tabelle7.B" style:family="table-column">
			<style:table-column-properties style:column-width="4.71cm"/>
		</style:style>
		<style:style style:name="Tabelle7.1" style:family="table-row">
			<style:table-row-properties style:min-row-height="1.005cm"/>
		</style:style>
		<style:style style:name="Tabelle7.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle7.B1" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="bottom" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle7.A2" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="middle" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle8" style:family="table">
			<style:table-properties style:width="17.013cm" fo:margin-left="0cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle8.A" style:family="table-column">
			<style:table-column-properties style:column-width="7.911cm"/>
		</style:style>
		<style:style style:name="Tabelle8.B" style:family="table-column">
			<style:table-column-properties style:column-width="9.102cm"/>
		</style:style>
		<style:style style:name="Tabelle8.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle9" style:family="table">
			<style:table-properties style:width="17.701cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle9.A" style:family="table-column">
			<style:table-column-properties style:column-width="12.991cm"/>
		</style:style>
		<style:style style:name="Tabelle9.B" style:family="table-column">
			<style:table-column-properties style:column-width="4.71cm"/>
		</style:style>
		<style:style style:name="Tabelle9.1" style:family="table-row">
			<style:table-row-properties style:min-row-height="1.005cm"/>
		</style:style>
		<style:style style:name="Tabelle9.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="0.05pt solid #000000"/>
		</style:style>
		<style:style style:name="Tabelle9.B1" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="bottom" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle9.A2" style:family="table-cell">
			<style:table-cell-properties style:vertical-align="middle" fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="Tabelle10" style:family="table">
			<style:table-properties style:width="17.013cm" fo:margin-left="0cm" table:align="left"/>
		</style:style>
		<style:style style:name="Tabelle10.A" style:family="table-column">
			<style:table-column-properties style:column-width="7.911cm"/>
		</style:style>
		<style:style style:name="Tabelle10.B" style:family="table-column">
			<style:table-column-properties style:column-width="9.102cm"/>
		</style:style>
		<style:style style:name="Tabelle10.A1" style:family="table-cell">
			<style:table-cell-properties fo:padding="0.097cm" fo:border="none"/>
		</style:style>
		<style:style style:name="P1" style:family="paragraph" style:parent-style-name="Standard">
			<style:text-properties officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-name="Arial" fo:font-size="8pt" style:font-size-asian="8pt" style:font-size-complex="8pt"/>
		</style:style>
		<style:style style:name="P2" style:family="paragraph" style:parent-style-name="Standard">
			<style:paragraph-properties>
				<style:tab-stops/>
			</style:paragraph-properties>
			<style:text-properties style:font-name="Arial" fo:font-size="8pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="8pt" style:font-size-complex="8pt"/>
		</style:style>
		<style:style style:name="P3" style:family="paragraph" style:parent-style-name="Standard">
			<style:paragraph-properties fo:text-align="end" style:justify-single-word="false">
				<style:tab-stops/>
			</style:paragraph-properties>
			<style:text-properties style:font-name="Arial" fo:font-size="8pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="8pt" style:font-size-complex="8pt"/>
		</style:style>
		<style:style style:name="P4" style:family="paragraph" style:parent-style-name="Standard">
			<style:paragraph-properties fo:text-align="center" style:justify-single-word="false">
				<style:tab-stops/>
			</style:paragraph-properties>
			<style:text-properties style:font-name="Arial" fo:font-size="7pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="7pt" style:font-size-complex="7pt"/>
		</style:style>
		<style:style style:name="P5" style:family="paragraph" style:parent-style-name="Table_20_Contents">
			<style:text-properties style:font-name="Arial" fo:font-size="6pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="6pt" style:font-size-complex="6pt"/>
		</style:style>
		<style:style style:name="P6" style:family="paragraph" style:parent-style-name="Table_20_Contents">
			<style:paragraph-properties fo:text-align="center" style:justify-single-word="false"/>
			<style:text-properties style:font-name="Arial" fo:font-size="8pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="8pt" style:font-size-complex="8pt"/>
		</style:style>
		<style:style style:name="P7" style:family="paragraph" style:parent-style-name="Table_20_Contents">
			<style:paragraph-properties fo:text-align="center" style:justify-single-word="false"/>
			<style:text-properties style:font-name="Arial" fo:font-size="10pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="10pt" style:font-size-complex="10pt"/>
		</style:style>
		<style:style style:name="P8" style:family="paragraph" style:parent-style-name="Table_20_Contents">
			<style:text-properties style:font-name="Arial" fo:font-size="10pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="10pt" style:font-size-complex="10pt"/>
		</style:style>
		<style:style style:name="P9" style:family="paragraph" style:parent-style-name="Standard">
			<style:paragraph-properties fo:margin-top="0cm" fo:margin-bottom="0.101cm" loext:contextual-spacing="false"/>
			<style:text-properties style:font-name="Arial" fo:font-size="14pt" officeooo:rsid="00094cd9" officeooo:paragraph-rsid="000a79ac" style:font-size-asian="14pt" style:font-size-complex="14pt"/>
		</style:style>
		<style:style style:name="T1" style:family="text">
			<style:text-properties style:font-name="Arial" fo:font-size="8pt" style:font-size-asian="8pt" style:font-size-complex="8pt"/>
		</style:style>
	</office:automatic-styles>
	<office:body>
		<xsl:apply-templates select="student"/>
	</office:body>
</office:document-content>
</xsl:template>

<xsl:template match="student">
        <office:text text:use-soft-page-breaks="true" xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0" xmlns:svg="urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0">
			<text:sequence-decls>
				<text:sequence-decl text:display-outline-level="0" text:name="Illustration"/>
				<text:sequence-decl text:display-outline-level="0" text:name="Table"/>
				<text:sequence-decl text:display-outline-level="0" text:name="Text"/>
				<text:sequence-decl text:display-outline-level="0" text:name="Drawing"/>
			</text:sequence-decls>
			<text:p text:style-name="P9">Studienbestätigung außerordentliches Studium FH Technikum Wien</text:p>
			<table:table table:name="Tabelle1" table:style-name="Tabelle1">
				<table:table-column table:style-name="Tabelle1.A"/>
				<table:table-column table:style-name="Tabelle1.B"/>
				<table:table-row table:style-name="Tabelle1.1">
					<table:table-cell table:style-name="Tabelle1.A1" office:value-type="string">
						<text:p text:style-name="P5">Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B1" office:value-type="string">
						<text:p text:style-name="P6">Personenkennzeichen</text:p>
					</table:table-cell>
				</table:table-row>
				<table:table-row table:style-name="Tabelle1.2">
					<table:table-cell table:style-name="Tabelle1.A2" office:value-type="string">
						<text:p text:style-name="P8">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B2" office:value-type="string">
						<text:p text:style-name="P7">
							<xsl:value-of select="matrikelnummer" />
						</text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p text:style-name="P1" />
			<text:p text:style-name="P1">
				geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
				ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
				als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
				<text:line-break />im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
			</text:p>
			<text:p text:style-name="P1"/>
			<table:table table:name="Tabelle2" table:style-name="Tabelle2">
				<table:table-column table:style-name="Tabelle2.A"/>
				<table:table-column table:style-name="Tabelle2.B"/>
				<table:table-row>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P2">Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P3">Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" /></text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p />
			<text:p text:style-name="P4">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</text:p>
			<text:p />
			<text:p text:style-name="P9">Studienbestätigung außerordentliches Studium FH Technikum Wien</text:p>
			<table:table table:name="Tabelle1" table:style-name="Tabelle1">
				<table:table-column table:style-name="Tabelle1.A"/>
				<table:table-column table:style-name="Tabelle1.B"/>
				<table:table-row table:style-name="Tabelle1.1">
					<table:table-cell table:style-name="Tabelle1.A1" office:value-type="string">
						<text:p text:style-name="P5">Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B1" office:value-type="string">
						<text:p text:style-name="P6">Personenkennzeichen</text:p>
					</table:table-cell>
				</table:table-row>
				<table:table-row table:style-name="Tabelle1.2">
					<table:table-cell table:style-name="Tabelle1.A2" office:value-type="string">
						<text:p text:style-name="P8">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
						</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B2" office:value-type="string">
						<text:p text:style-name="P7">
							<xsl:value-of select="matrikelnummer" />
						</text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p text:style-name="P1" />
			<text:p text:style-name="P1">
				geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
				ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
				als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
				<text:line-break />im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
			</text:p>
			<text:p text:style-name="P1"/>
			<table:table table:name="Tabelle2" table:style-name="Tabelle2">
				<table:table-column table:style-name="Tabelle2.A"/>
				<table:table-column table:style-name="Tabelle2.B"/>
				<table:table-row>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P2">Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P3">Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" /></text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p />
			<text:p text:style-name="P4">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</text:p>
			<text:p />
			<text:p text:style-name="P9">Studienbestätigung außerordentliches Studium FH Technikum Wien</text:p>
			<table:table table:name="Tabelle1" table:style-name="Tabelle1">
				<table:table-column table:style-name="Tabelle1.A"/>
				<table:table-column table:style-name="Tabelle1.B"/>
				<table:table-row table:style-name="Tabelle1.1">
					<table:table-cell table:style-name="Tabelle1.A1" office:value-type="string">
						<text:p text:style-name="P5">Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B1" office:value-type="string">
						<text:p text:style-name="P6">Personenkennzeichen</text:p>
					</table:table-cell>
				</table:table-row>
				<table:table-row table:style-name="Tabelle1.2">
					<table:table-cell table:style-name="Tabelle1.A2" office:value-type="string">
						<text:p text:style-name="P8">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
						</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B2" office:value-type="string">
						<text:p text:style-name="P7">
							<xsl:value-of select="matrikelnummer" />
						</text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p text:style-name="P1" />
			<text:p text:style-name="P1">
				geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
				ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
				als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
				<text:line-break />im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
			</text:p>
			<text:p text:style-name="P1"/>
			<table:table table:name="Tabelle2" table:style-name="Tabelle2">
				<table:table-column table:style-name="Tabelle2.A"/>
				<table:table-column table:style-name="Tabelle2.B"/>
				<table:table-row>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P2">Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P3">Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" /></text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p />
			<text:p text:style-name="P4">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</text:p>
			<text:p />
			<text:p text:style-name="P9">Studienbestätigung außerordentliches Studium FH Technikum Wien</text:p>
			<table:table table:name="Tabelle1" table:style-name="Tabelle1">
				<table:table-column table:style-name="Tabelle1.A"/>
				<table:table-column table:style-name="Tabelle1.B"/>
				<table:table-row table:style-name="Tabelle1.1">
					<table:table-cell table:style-name="Tabelle1.A1" office:value-type="string">
						<text:p text:style-name="P5">Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B1" office:value-type="string">
						<text:p text:style-name="P6">Personenkennzeichen</text:p>
					</table:table-cell>
				</table:table-row>
				<table:table-row table:style-name="Tabelle1.2">
					<table:table-cell table:style-name="Tabelle1.A2" office:value-type="string">
						<text:p text:style-name="P8">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B2" office:value-type="string">
						<text:p text:style-name="P7">
							<xsl:value-of select="matrikelnummer" />
						</text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p text:style-name="P1" />
			<text:p text:style-name="P1">
				geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
				ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
				als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
				<text:line-break />im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
			</text:p>
			<text:p text:style-name="P1"/>
			<table:table table:name="Tabelle2" table:style-name="Tabelle2">
				<table:table-column table:style-name="Tabelle2.A"/>
				<table:table-column table:style-name="Tabelle2.B"/>
				<table:table-row>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P2">Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P3">Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" /></text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p />
			<text:p text:style-name="P4">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</text:p>
			<text:p />
			<text:p text:style-name="P9">Studienbestätigung außerordentliches Studium FH Technikum Wien</text:p>
			<table:table table:name="Tabelle1" table:style-name="Tabelle1">
				<table:table-column table:style-name="Tabelle1.A"/>
				<table:table-column table:style-name="Tabelle1.B"/>
				<table:table-row table:style-name="Tabelle1.1">
					<table:table-cell table:style-name="Tabelle1.A1" office:value-type="string">
						<text:p text:style-name="P5">Zur Vorlage an (Stelle an der die Bestätigung vorgelegt wird und deren Bezugszahl, z.B. Sozialversicherungsnr.)</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B1" office:value-type="string">
						<text:p text:style-name="P6">Personenkennzeichen</text:p>
					</table:table-cell>
				</table:table-row>
				<table:table-row table:style-name="Tabelle1.2">
					<table:table-cell table:style-name="Tabelle1.A2" office:value-type="string">
						<text:p text:style-name="P8">
							<xsl:value-of select="titelpre" /><xsl:text> </xsl:text><xsl:value-of select="vorname" /><xsl:text> </xsl:text><xsl:value-of select="vornamen" /><xsl:text> </xsl:text><xsl:value-of select="nachname" /><xsl:text> </xsl:text><xsl:value-of select="titelpost" />
                        </text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle1.B2" office:value-type="string">
						<text:p text:style-name="P7">
							<xsl:value-of select="matrikelnummer" />
						</text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
			<text:p text:style-name="P1" />
			<text:p text:style-name="P1">
				geboren am<xsl:text> </xsl:text><xsl:value-of select="geburtsdatum" /><xsl:text> </xsl:text>
				ist im<xsl:text> </xsl:text><xsl:value-of select="studiensemester_aktuell" /><xsl:text> </xsl:text>(Beginn <xsl:text> </xsl:text><xsl:value-of select="studienbeginn_aktuell" />)
				als außerordentliche(r) Studierende(r) (Studienbeginn<xsl:text> </xsl:text><xsl:value-of select="studiensemester_beginn" />, Beginn<xsl:text> </xsl:text><xsl:value-of select="studienbeginn_beginn" />)
				<text:line-break />im FH-<xsl:value-of select="lv_studiengang_art" />-Studiengang<xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_kz" /><xsl:text> </xsl:text><xsl:value-of select="lv_studiengang_bezeichnung" /> gemeldet.
			</text:p>
			<text:p text:style-name="P1"/>
			<table:table table:name="Tabelle2" table:style-name="Tabelle2">
				<table:table-column table:style-name="Tabelle2.A"/>
				<table:table-column table:style-name="Tabelle2.B"/>
				<table:table-row>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P2">Datum:<xsl:text> </xsl:text><xsl:value-of select="tagesdatum" /><xsl:text> </xsl:text>DVR: 0928381</text:p>
					</table:table-cell>
					<table:table-cell table:style-name="Tabelle2.A1" office:value-type="string">
						<text:p text:style-name="P3">Rektor:<xsl:text> </xsl:text><xsl:value-of select="rektor" /></text:p>
					</table:table-cell>
				</table:table-row>
			</table:table>
		 </office:text>
</xsl:template>
</xsl:stylesheet>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
