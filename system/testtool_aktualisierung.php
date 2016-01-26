<?php
/* Copyright (C) 2009 Technikum-Wien
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
 *
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at>,
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at> and
 *			Gerald Simane-Sequens <gerald.simane-sequens@technikum-wien.at>
 ******************************************************************************
 * Beschreibung:
 * Dieses Skript aktualisiert die Datenbank fuer das neue Testtool
 */

require_once('../vilesci/config.inc.php');

$user='oesi';
// Datenbank Verbindung
if (!$conn = pg_pconnect("host=theseus.technikum-wien.at dbname= user=$user password="))
//if (!$conn = pg_pconnect(CONN_STRING))
   	die('Es konnte keine Verbindung zum Server aufgebaut werden!'.pg_last_error($conn));

// ************** campus.tbl_paabgabetyp **************************************************

if(!@pg_query($conn, 'SELECT * FROM testtool.tbl_frage_sprache LIMIT 1;'))
{
	$error=false;
	$affected=0;
	$sql =" 
	BEGIN;
	
	--tbl_studiengang neue spalte sprache
	ALTER TABLE public.tbl_studiengang ADD COLUMN sprache varchar(16);
	UPDATE public.tbl_studiengang SET sprache='German';
	ALTER TABLE public.tbl_studiengang ADD FOREIGN KEY (sprache) REFERENCES public.tbl_sprache (sprache) on update cascade on delete restrict;
	ALTER TABLE public.tbl_studiengang ADD COLUMN testtool_sprachwahl boolean;
	UPDATE public.tbl_studiengang SET testtool_sprachwahl=false;
	
	DROP VIEW public.vw_prestudent;
	
	-- tbl_prestudent punkte umbenenen in rt_gesamtpunkte und neue spalte rt_punkte1 und rt_punkte2
	ALTER TABLE public.tbl_prestudent RENAME COLUMN punkte TO rt_gesamtpunkte;
	ALTER TABLE public.tbl_prestudent ALTER COLUMN rt_gesamtpunkte TYPE numeric(8,4);
	ALTER TABLE public.tbl_prestudent ADD COLUMN rt_punkte1 numeric(8,4);
	ALTER TABLE public.tbl_prestudent ADD COLUMN rt_punkte2 numeric(8,4);
	
	CREATE OR REPLACE VIEW public.vw_prestudent AS
	SELECT tbl_prestudent.prestudent_id, tbl_person.person_id, tbl_prestudent.reihungstest_id, tbl_person.staatsbuergerschaft, tbl_person.geburtsnation, tbl_person.sprache, tbl_person.anrede, tbl_person.titelpost, tbl_person.titelpre, tbl_person.nachname, tbl_person.vorname, tbl_person.vornamen, tbl_person.gebdatum, tbl_person.gebort, tbl_person.gebzeit, tbl_person.foto, tbl_person.anmerkung AS anmerkungen, tbl_person.homepage, tbl_person.svnr, tbl_person.ersatzkennzeichen, tbl_person.familienstand, tbl_person.geschlecht, tbl_person.anzahlkinder, tbl_person.aktiv, tbl_prestudent.aufmerksamdurch_kurzbz, tbl_prestudent.studiengang_kz, tbl_prestudent.berufstaetigkeit_code, tbl_prestudent.ausbildungcode, tbl_prestudent.zgv_code, tbl_prestudent.zgvort, tbl_prestudent.zgvdatum, tbl_prestudent.zgvmas_code, tbl_prestudent.zgvmaort, tbl_prestudent.zgvmadatum, tbl_prestudent.aufnahmeschluessel, tbl_prestudent.facheinschlberuf, tbl_prestudent.anmeldungreihungstest, tbl_prestudent.reihungstestangetreten, tbl_prestudent.rt_gesamtpunkte as punkte, tbl_prestudent.rt_punkte1, tbl_prestudent.rt_punkte2, tbl_prestudent.bismelden, tbl_reihungstest.studiengang_kz AS rt_studiengang_kz, tbl_reihungstest.ort_kurzbz AS rt_ort, tbl_reihungstest.datum AS rt_datum, tbl_reihungstest.uhrzeit AS rt_uhrzeit, tbl_prestudent.updateamum, tbl_prestudent.updatevon, tbl_prestudent.insertamum, tbl_prestudent.insertvon, tbl_prestudent.ext_id
	FROM tbl_person
	JOIN tbl_prestudent USING (person_id)
	JOIN tbl_reihungstest USING (reihungstest_id);
	
	GRANT SELECT ON public.vw_prestudent to group admin;
	GRANT SELECT ON public.vw_prestudent to group web;
   
	-- tbl_ablauf.ablauf_id neuer PK und insert und update felder
	ALTER TABLE testtool.tbl_ablauf OWNER to $user;
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN ablauf_id serial NOT NULL;
	ALTER TABLE testtool.tbl_ablauf DROP CONSTRAINT pk_ablauf;
	ALTER TABLE testtool.tbl_ablauf ADD PRIMARY KEY (ablauf_id);
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN insertamum timestamp;
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN insertvon varchar(32);
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN updateamum timestamp;
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN updatevon varchar(32);
	ALTER TABLE testtool.tbl_ablauf ADD COLUMN semester smallint;
	
	UPDATE testtool.tbl_ablauf SET semester=1;
	
	-- tbl_antwort vorschlag_id hinzufuegen
	ALTER TABLE testtool.tbl_antwort ADD COLUMN vorschlag_id integer;
	ALTER TABLE testtool.tbl_antwort ADD FOREIGN KEY (vorschlag_id) REFERENCES testtool.tbl_vorschlag (vorschlag_id) on update cascade on delete restrict;	
	
	-- tbl_antwort.vorschlag_id setzen
	UPDATE testtool.tbl_antwort SET vorschlag_id=(SELECT vorschlag_id FROM testtool.tbl_vorschlag WHERE frage_id=tbl_antwort.frage_id AND antwort=tbl_antwort.antwort);

	ALTER TABLE testtool.tbl_antwort ADD CONSTRAINT vorschlag_antwort FOREIGN KEY (vorschlag_id) references testtool.tbl_vorschlag (vorschlag_id) on update cascade on delete restrict;

	DROP VIEW testtool.vw_auswertung_kategorie;
	DROP VIEW testtool.vw_auswertung;	
	DROP VIEW testtool.vw_anz_richtig;
	DROP VIEW testtool.vw_anz_antwort;
	DROP VIEW testtool.vw_allefragen;
	DROP VIEW testtool.vw_antwort;
	DROP VIEW testtool.vw_frage;
	DROP VIEW testtool.vw_gebiet;
	DROP VIEW testtool.vw_pruefling;
		
	CREATE TABLE testtool.tbl_pruefling_frage
	(
		prueflingfrage_id Serial NOT NULL,
		pruefling_id integer NOT NULL,
		frage_id integer NOT NULL,
		nummer Smallint,
		begintime Timestamp,
		endtime Timestamp,
		constraint pk_tbl_pruefling_frage primary key (prueflingfrage_id)
	);
	
	-- tbl_pruefling_frage fuellen
	INSERT INTO testtool.tbl_pruefling_frage(pruefling_id, frage_id, nummer, begintime, endtime) 
	SELECT tbl_antwort.pruefling_id, tbl_frage.frage_id, tbl_frage.nummer, tbl_antwort.begintime, tbl_antwort.endtime
	FROM testtool.tbl_antwort JOIN testtool.tbl_frage USING(frage_id) WHERE tbl_antwort.pruefling_id is not null;

	-- tbl_antwort.frage_id loeschen
	ALTER TABLE testtool.tbl_antwort DROP COLUMN frage_id;
	
	-- NULL werte in tbl_antwort loeschen und NN setzen
	DELETE FROM testtool.tbl_antwort WHERE pruefling_id is null;
	ALTER TABLE testtool.tbl_antwort ALTER COLUMN pruefling_id SET NOT NULL;
	
	ALTER TABLE testtool.tbl_pruefling_frage ADD CONSTRAINT frage_prueflingfrage FOREIGN KEY (frage_id) references testtool.tbl_frage (frage_id) on update cascade on delete restrict;
	ALTER TABLE testtool.tbl_pruefling_frage ADD CONSTRAINT pruefling_prueflingfrage FOREIGN KEY (pruefling_id) references testtool.tbl_pruefling (pruefling_id) on update cascade on delete restrict;

	-- begintime und endtime aus tbl_antwort loeschen
	ALTER TABLE testtool.tbl_antwort DROP COLUMN begintime;
	ALTER TABLE testtool.tbl_antwort DROP COLUMN endtime;
	
	-- tbl_vorschlag aktualisieren
	ALTER TABLE testtool.tbl_vorschlag ADD COLUMN punkte numeric(8,4);
	ALTER TABLE testtool.tbl_vorschlag ADD COLUMN insertamum timestamp;
	ALTER TABLE testtool.tbl_vorschlag ADD COLUMN insertvon varchar(32);
	ALTER TABLE testtool.tbl_vorschlag ADD COLUMN updateamum timestamp;
	ALTER TABLE testtool.tbl_vorschlag ADD COLUMN updatevon varchar(32);
	
	-- tbl_vorschlag punkte fuer loesung vergeben
	UPDATE testtool.tbl_vorschlag SET punkte=1 WHERE antwort=(SELECT loesung FROM testtool.tbl_frage WHERE frage_id=tbl_vorschlag.frage_id);
	UPDATE testtool.tbl_vorschlag SET punkte=(SELECT abzug FROM testtool.tbl_gebiet JOIN testtool.tbl_frage USING(gebiet_id) WHERE frage_id=tbl_vorschlag.frage_id) WHERE antwort<>(SELECT loesung FROM testtool.tbl_frage WHERE frage_id=tbl_vorschlag.frage_id);
	
	-- tbl_vorschlag_sprache anlegen und fuellen
	CREATE TABLE testtool.tbl_vorschlag_sprache
	(
		vorschlag_id integer NOT NULL,
		sprache Varchar(16) NOT NULL,
		text Text,
		bild Text,
		audio Text,
		insertamum Timestamp,
		insertvon Varchar(32),
		updateamum Timestamp,
		updatevon Varchar(32),
		constraint pk_tbl_vorschlag_sprache primary key (vorschlag_id, sprache)
	);
	-- text mit der Antwort befuellen bei vorschlaegen ohne text und bild
	UPDATE testtool.tbl_vorschlag SET text=antwort WHERE (text is null OR text='') AND (bild is null OR bild='');
	
	INSERT INTO testtool.tbl_vorschlag_sprache(vorschlag_id, sprache, text, bild, audio)
	SELECT vorschlag_id, 'German', text, bild, null FROM testtool.tbl_vorschlag;

	ALTER TABLE testtool.tbl_vorschlag_sprache ADD CONSTRAINT sprache_vorschlagsprache FOREIGN KEY (sprache) references public.tbl_sprache (sprache) on update cascade on delete restrict;
	ALTER TABLE testtool.tbl_vorschlag_sprache ADD CONSTRAINT vorschlage_vorschlagsprache FOREIGN KEY (vorschlag_id) references testtool.tbl_vorschlag (vorschlag_id) on update cascade on delete restrict;
		
	-- neue Spalten in tbl_frage
	ALTER TABLE testtool.tbl_frage ADD COLUMN level smallint;
	ALTER TABLE testtool.tbl_frage ADD COLUMN insertamum timestamp;
	ALTER TABLE testtool.tbl_frage ADD COLUMN insertvon varchar(32);
	ALTER TABLE testtool.tbl_frage ADD COLUMN updateamum timestamp;
	ALTER TABLE testtool.tbl_frage ADD COLUMN updatevon varchar(32);
	
	UPDATE testtool.tbl_frage SET level=1;
	
	ALTER TABLE testtool.tbl_frage ADD CONSTRAINT tbl_frage_level CHECK (level<=5 AND level>=1);
	
	Comment on column testtool.tbl_frage.level Is 'Schwierigkeitsgrad:  1=Leicht  5=Schwer';

	-- neue Tabelle tbl_frage_sprache anlegen und Daten kopieren
	CREATE TABLE testtool.tbl_frage_sprache
	(
		frage_id integer NOT NULL,
		sprache Varchar(16) NOT NULL,
		text Text,
		bild Text,
		audio Text,
		insertamum Timestamp,
		insertvon Varchar(32),
		updateamum Timestamp,
		updatevon Varchar(32),
		constraint pk_tbl_frage_sprache primary key (frage_id,sprache)
	);
	
	-- Umlautprobleme etc entfernen
	UPDATE testtool.tbl_frage SET text=replace(replace(replace( text, 'ö', 'oe'),'Ì','ue'),'À','ae');
	UPDATE testtool.tbl_vorschlag SET text=null WHERE text='';
	UPDATE testtool.tbl_vorschlag SET bild=null WHERE bild='';
	
	-- eintraege kopieren
	INSERT INTO testtool.tbl_frage_sprache(frage_id, sprache, text, bild)
	SELECT frage_id, 'German', text, bild FROM testtool.tbl_frage;
	
	ALTER TABLE testtool.tbl_frage_sprache ADD CONSTRAINT sprache_fragesprache FOREIGN KEY (sprache) references public.tbl_sprache (sprache) on update cascade on delete restrict;
	ALTER TABLE testtool.tbl_frage_sprache ADD CONSTRAINT frage_fragesprache FOREIGN KEY (frage_id) references testtool.tbl_frage (frage_id) on update cascade on delete restrict;
		
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN multipleresponse boolean NOT NULL DEFAULT false;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN maxfragen smallint;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN zufallfrage boolean NOT NULL DEFAULT false;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN zufallvorschlag boolean NOT NULL DEFAULT true;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN level_start smallint;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN level_sprung_auf smallint;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN level_sprung_ab smallint;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN levelgleichverteilung boolean;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN maxpunkte smallint;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN insertamum timestamp;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN insertvon varchar(32);
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN updateamum timestamp;
	ALTER TABLE testtool.tbl_gebiet ADD COLUMN updatevon varchar(32);
	
	UPDATE testtool.tbl_gebiet SET multipleresponse=false, maxfragen=null;
	
	ALTER TABLE testtool.tbl_gebiet DROP COLUMN abzug;
	
	Comment on column testtool.tbl_gebiet.multipleresponse Is 'Wenn TRUE dann Checkboxen bei den moeglichen Antworten. Wenn FALSE dann RadioButtons.';
	Comment on column testtool.tbl_gebiet.maxfragen Is 'Anzahl der Fragen aus dem Pool. Wenn NULL dann alle Fragen.';
	Comment on column testtool.tbl_gebiet.zufallfrage Is 'Wenn TRUE ist die Reihenfolge der Fragen zufaellig.';
	Comment on column testtool.tbl_gebiet.zufallvorschlag Is 'Wenn TRUE ist die Reihenfolge der moeglichen Antworten zufaellig.';
	Comment on column testtool.tbl_gebiet.level_start Is 'Wenn NULL werden die Levels nicht beruecksichtigt. NOT NULL bestimmt den Startlevel.';
	Comment on column testtool.tbl_gebiet.level_sprung_auf Is 'Wieviele richtige Antworten sind notwendig um einen Level nach open zu springen.';
	Comment on column testtool.tbl_gebiet.level_sprung_ab Is 'Wieviele falsche Antworten sind notwendig um einen Level nach unten zu springen.'; 
	Comment on column testtool.tbl_gebiet.levelgleichverteilung Is 'Wenn TRUE gibt es fuer jeden Level gleich viele Fragen.\r\nWenn FALSE haengt die Anzahl der Fragen pro Level von der Gesamtzahl pro Level ab.';
	Comment on column testtool.tbl_gebiet.maxpunkte Is 'Ab wievielen Punkten hat man 100%';

	ALTER TABLE testtool.tbl_pruefling DROP COLUMN gruppe_kurzbz;
	ALTER TABLE testtool.tbl_pruefling ADD COLUMN semester smallint;
	UPDATE testtool.tbl_pruefling SET semester=1;
	
	
	Create unique index unq_idx_ablauf_gebiet_studiengang_semester on testtool.tbl_ablauf using btree (gebiet_id, studiengang_kz, semester);

	GRANT SELECT ON testtool.tbl_pruefling_frage TO GROUP admin;
	GRANT UPDATE ON testtool.tbl_pruefling_frage TO GROUP admin;
	GRANT INSERT ON testtool.tbl_pruefling_frage TO GROUP admin;
	GRANT DELETE ON testtool.tbl_pruefling_frage TO GROUP admin;
	GRANT SELECT ON testtool.tbl_pruefling_frage TO GROUP web;
	GRANT UPDATE ON testtool.tbl_pruefling_frage TO GROUP web;
	GRANT INSERT ON testtool.tbl_pruefling_frage TO GROUP web;
	GRANT DELETE ON testtool.tbl_pruefling_frage TO GROUP web;
	GRANT SELECT ON testtool.tbl_vorschlag_sprache TO GROUP admin;
	GRANT UPDATE ON testtool.tbl_vorschlag_sprache TO GROUP admin;
	GRANT INSERT ON testtool.tbl_vorschlag_sprache TO GROUP admin;
	GRANT DELETE ON testtool.tbl_vorschlag_sprache TO GROUP admin;
	GRANT SELECT ON testtool.tbl_vorschlag_sprache TO GROUP web;
	GRANT UPDATE ON testtool.tbl_vorschlag_sprache TO GROUP web;
	GRANT INSERT ON testtool.tbl_vorschlag_sprache TO GROUP web;
	GRANT DELETE ON testtool.tbl_vorschlag_sprache TO GROUP web;
	GRANT SELECT ON testtool.tbl_frage_sprache TO GROUP admin;
	GRANT UPDATE ON testtool.tbl_frage_sprache TO GROUP admin;
	GRANT INSERT ON testtool.tbl_frage_sprache TO GROUP admin;
	GRANT DELETE ON testtool.tbl_frage_sprache TO GROUP admin;
	GRANT SELECT ON testtool.tbl_frage_sprache TO GROUP web;
	GRANT UPDATE ON testtool.tbl_frage_sprache TO GROUP web;
	GRANT INSERT ON testtool.tbl_frage_sprache TO GROUP web;
	GRANT DELETE ON testtool.tbl_frage_sprache TO GROUP web;
	GRANT UPDATE ON testtool.tbl_gebiet TO GROUP web;
		
	";
	//$sql="BEGIN;SELECT 1;";
	if($result = pg_query($conn, $sql))
	{
		
		// Fragen der Gruppe B loeschen und die Antworten auf die der Gruppe A haengen
	
		//Alle Vorschlaege der Gruppe B holen
		$qry =" SELECT 
					tbl_vorschlag.vorschlag_id, tbl_vorschlag.text, tbl_vorschlag.bild, tbl_vorschlag.frage_id,
					tbl_frage.gebiet_id, tbl_frage.nummer, tbl_frage.text as fragetext, tbl_frage.bild as fragebild
				FROM testtool.tbl_frage JOIN testtool.tbl_vorschlag USING(frage_id)
				WHERE gruppe_kurzbz='B'";
		if($result = pg_query($conn, $qry))
		{
			while($row = pg_fetch_object($result))
			{
				//Passenden Vorschlag der Frage der Gruppe A holen
				$qry = "SELECT tbl_vorschlag.vorschlag_id, tbl_frage.frage_id
						FROM testtool.tbl_frage JOIN testtool.tbl_vorschlag USING(frage_id) 
						WHERE gruppe_kurzbz='A' AND tbl_frage.text='".addslashes($row->fragetext)."' AND ";
				if($row->fragebild=='')
					$qry.="tbl_frage.bild is null AND";
				else 
					$qry.="tbl_frage.bild='".addslashes($row->fragebild)."' AND";
								
				if($row->text=='')
					$qry.=" tbl_vorschlag.text is null";
				else
					$qry.=" tbl_vorschlag.text='".addslashes($row->text)."'";
				
				if($row->bild=='')
					$qry.=" AND tbl_vorschlag.bild is null";
				else 
					$qry.=" AND tbl_vorschlag.bild='".addslashes($row->bild)."'";
				if($result_a=pg_query($conn, $qry))
				{
					if($row_a = pg_fetch_object($result_a))
					{
						//Vorschlaege umhaengen
						$qry = "UPDATE testtool.tbl_antwort SET vorschlag_id='$row_a->vorschlag_id' WHERE vorschlag_id='$row->vorschlag_id'";
						if(!$result_update=pg_query($conn, $qry))
						{
							echo '<br>Fehler:'.pg_last_error($conn);
							$error=true;
						}
						else 
						{
							$affected+=pg_affected_rows($result_update);
						}
						
						//Eintrag in der Tabelle tbl_pruefling_frage aktualisieren
						$qry = "UPDATE testtool.tbl_pruefling_frage SET frage_id='$row_a->frage_id' WHERE frage_id='$row->frage_id'";
						if(!pg_query($conn, $qry))
						{
							echo '<br>Fehler: Update von tbl_pruefling_frage fehlgeschlagen:'.$qry;
							$error = true;							
						}
					}
					else 
					{
						echo "<br>Keine passenden Vorschlaege zur Frage Gruppe A/Nummer $row->nummer/Gebiet $row->gebiet_id";
						//$error = true;
					}
				}
				else 
				{
					echo '<br>Fehler:'.pg_last_error($conn);
					$error=true;
				}
			}
			echo '<br>Aktualisierte Antworten: '.$affected;
		}
		else 
		{
			echo '<br>Fehler:'.pg_last_error($conn);
			$error=true;
		}
		
		$qry = "
		-- Spalten in tbl_vorschlag entfernen
		ALTER TABLE testtool.tbl_vorschlag DROP COLUMN text;
		ALTER TABLE testtool.tbl_vorschlag DROP COLUMN bild;
					
		CREATE OR REPLACE VIEW testtool.vw_pruefling AS
		SELECT tbl_pruefling.prestudent_id, tbl_pruefling.pruefling_id, tbl_pruefling.studiengang_kz, tbl_person.nachname, tbl_person.vorname, tbl_person.gebdatum, tbl_person.geschlecht, tbl_pruefling.idnachweis, tbl_pruefling.registriert, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.bezeichnung AS stg_bez
		FROM testtool.tbl_pruefling
		JOIN public.tbl_studiengang USING (studiengang_kz)
		JOIN public.tbl_prestudent USING (prestudent_id)
		JOIN public.tbl_person USING (person_id);
		
		GRANT SELECT ON testtool.vw_pruefling TO GROUP web;
		GRANT SELECT ON testtool.vw_pruefling TO GROUP admin;
		
		-- alle Fragen die keinen Spracheintrag haben, loeschen
		DELETE FROM testtool.tbl_pruefling_frage WHERE frage_id IN(SELECT frage_id FROM testtool.tbl_frage WHERE NOT EXISTS(SELECT frage_id FROM testtool.tbl_frage_sprache WHERE frage_id=tbl_frage.frage_id));
		DELETE FROM testtool.tbl_frage WHERE NOT EXISTS(SELECT frage_id FROM testtool.tbl_frage_sprache WHERE frage_id=tbl_frage.frage_id);

		DELETE FROM testtool.tbl_vorschlag_sprache WHERE vorschlag_id in
			(
				SELECT vorschlag_id FROM testtool.tbl_vorschlag WHERE frage_id in
					(
						SELECT frage_id FROM testtool.tbl_frage WHERE gruppe_kurzbz='B'
					)
			) 
			AND NOT EXISTS
			(
				SELECT vorschlag_id FROM testtool.tbl_antwort WHERE vorschlag_id=tbl_vorschlag_sprache.vorschlag_id
			);
		
		DELETE FROM testtool.tbl_vorschlag WHERE frage_id in
			(
				SELECT frage_id FROM testtool.tbl_frage WHERE gruppe_kurzbz='B'
			)
			AND NOT EXISTS
			(
				SELECT vorschlag_id FROM testtool.tbl_antwort WHERE vorschlag_id=tbl_vorschlag.vorschlag_id
			);
		
		DELETE FROM testtool.tbl_frage_sprache WHERE frage_id in
			(
				SELECT frage_id FROM testtool.tbl_frage WHERE gruppe_kurzbz='B' AND NOT EXISTS (SELECT frage_id FROM testtool.tbl_vorschlag WHERE frage_id=tbl_frage_sprache.frage_id)
			);
		DELETE FROM testtool.tbl_frage WHERE gruppe_kurzbz='B' AND NOT EXISTS (SELECT frage_id FROM testtool.tbl_vorschlag WHERE frage_id=tbl_frage.frage_id UNION SELECT frage_id FROM testtool.tbl_pruefling_frage WHERE frage_id=tbl_frage.frage_id);
		
		-- Fragen der Gruppe B die nicht zugeordnet werden hinten anreihen
		UPDATE testtool.tbl_frage SET nummer=(SELECT max(nummer)+1 FROM testtool.tbl_frage WHERE gebiet_id=tbl_frage.gebiet_id AND gruppe_kurzbz='A') WHERE gruppe_kurzbz='B';
		
		ALTER TABLE testtool.tbl_vorschlag DROP COLUMN antwort;
		ALTER TABLE testtool.tbl_antwort DROP COLUMN antwort;
		ALTER TABLE testtool.tbl_frage DROP COLUMN loesung;
		ALTER TABLE testtool.tbl_frage DROP COLUMN gruppe_kurzbz;
		DROP TABLE testtool.tbl_gruppe;
		
		ALTER TABLE testtool.tbl_frage DROP COLUMN text;
		ALTER TABLE testtool.tbl_frage DROP COLUMN bild;
		
		CREATE OR REPLACE VIEW testtool.vw_auswertung AS
		SELECT 
			tbl_gebiet.gebiet_id, 
			tbl_gebiet.bezeichnung AS gebiet, 
			tbl_gebiet.maxpunkte, tbl_pruefling.pruefling_id, 
			tbl_pruefling.prestudent_id, 
			tbl_person.vorname, 
			tbl_person.nachname, 
			tbl_person.gebdatum, 
			tbl_person.geschlecht, 
		 	tbl_pruefling.semester, 
		 	UPPER(tbl_studiengang.typ::character varying(1)::text || tbl_studiengang.kurzbz::text) AS stg_kurzbz, 
			tbl_studiengang.bezeichnung AS stg_bez, 
			tbl_pruefling.registriert, 
			tbl_pruefling.idnachweis, 
		 	( SELECT sum(tbl_vorschlag.punkte) AS sum
			  FROM 
			  	testtool.tbl_vorschlag
		      	JOIN testtool.tbl_antwort USING (vorschlag_id)
		   		JOIN testtool.tbl_frage USING (frage_id)
			  WHERE 
		  		tbl_antwort.pruefling_id = tbl_pruefling.pruefling_id 
		  		AND tbl_frage.gebiet_id = tbl_gebiet.gebiet_id
		  	) AS punkte,
		  	tbl_prestudent.reihungstest_id,
  			tbl_ablauf.gewicht
		FROM 
			testtool.tbl_pruefling
			JOIN testtool.tbl_ablauf ON (tbl_ablauf.studiengang_kz = tbl_pruefling.studiengang_kz AND tbl_ablauf.semesteR=tbl_pruefling.semester)
			JOIN testtool.tbl_gebiet USING (gebiet_id)
			JOIN public.tbl_prestudent USING (prestudent_id)
			JOIN public.tbl_person USING (person_id)
			JOIN public.tbl_studiengang ON (tbl_prestudent.studiengang_kz = tbl_studiengang.studiengang_kz)
		WHERE
			gebiet_id NOT IN (SELECT gebiet_id FROM testtool.tbl_kategorie);
		
		GRANT SELECT ON testtool.vw_auswertung TO GROUP web;
		GRANT SELECT ON testtool.vw_auswertung TO GROUP admin;
		
		DROP VIEW testtool.vw_ablauf;
		
		CREATE OR REPLACE VIEW testtool.vw_ablauf AS
		SELECT 
			tbl_ablauf.studiengang_kz, 
			tbl_ablauf.gebiet_id, 
			tbl_ablauf.reihung, 
			tbl_ablauf.gewicht, 
			tbl_ablauf.semester,
			tbl_studiengang.kurzbzlang AS stg_kurzbz, 
			tbl_studiengang.bezeichnung AS stg_bez, 
			tbl_gebiet.kurzbz AS gebiet_kurzbz, 
			tbl_gebiet.bezeichnung AS gebiet_bez
		FROM testtool.tbl_ablauf
		JOIN testtool.tbl_gebiet USING (gebiet_id)
		JOIN public.tbl_studiengang USING (studiengang_kz);
		
		GRANT SELECT ON testtool.vw_ablauf TO GROUP web;
		
		GRANT SELECT ON SEQUENCE testtool.tbl_pruefling_frage_prueflingfrage_id_seq TO GROUP web;
		GRANT UPDATE ON SEQUENCE testtool.tbl_pruefling_frage_prueflingfrage_id_seq TO GROUP web;
		GRANT SELECT ON SEQUENCE testtool.tbl_pruefling_frage_prueflingfrage_id_seq TO GROUP admin;
		GRANT UPDATE ON SEQUENCE testtool.tbl_pruefling_frage_prueflingfrage_id_seq TO GROUP admin;
		GRANT UPDATE ON SEQUENCE testtool.tbl_frage_frage_id_seq TO GROUP web;
		GRANT SELECT ON SEQUENCE testtool.tbl_frage_frage_id_seq TO GROUP web;
		
		-- maxpunkte fuer die Gebiete berechnen
		UPDATE testtool.tbl_gebiet SET maxpunkte=
		(
		SELECT sum(punkte) as max 
		FROM testtool.tbl_vorschlag JOIN testtool.tbl_frage USING(frage_id)
		WHERE gebiet_id=tbl_gebiet.gebiet_id AND punkte>0 AND NOT demo
		);
		
		-- Frage Sequence richtig setzen
		SELECT setval('testtool.tbl_frage_frage_id_seq', (SELECT max(frage_id) FROM testtool.tbl_frage));
		
		-- vw_auswertung_kategorie anlegen
		CREATE OR REPLACE VIEW testtool.vw_auswertung_kategorie AS
		SELECT
			tbl_kategorie.kategorie_kurzbz,
			tbl_person.vorname, 
			tbl_person.nachname, 
			tbl_person.gebdatum, 
			tbl_person.geschlecht, 
		 	tbl_prestudent.prestudent_id, 
		 	tbl_prestudent.reihungstest_id,
		 	tbl_gebiet.gebiet_id,
		 	UPPER(tbl_studiengang.typ::character varying(1)::text || tbl_studiengang.kurzbz::text) AS stg_kurzbz, 
			tbl_studiengang.bezeichnung AS stg_bez, 
			tbl_pruefling.registriert, 
			tbl_pruefling.idnachweis, 
			tbl_pruefling.semester,
		 	tbl_pruefling.pruefling_id,
			( SELECT sum(tbl_vorschlag.punkte) AS sum
			  FROM 
			  	testtool.tbl_vorschlag
		      	JOIN testtool.tbl_antwort USING (vorschlag_id)
		   		JOIN testtool.tbl_frage USING (frage_id)
			  WHERE 
		  		tbl_antwort.pruefling_id = tbl_pruefling.pruefling_id 
		  		AND tbl_frage.gebiet_id = tbl_gebiet.gebiet_id
		  		AND kategorie_kurzbz=tbl_kategorie.kategorie_kurzbz
		  	) AS punkte
		  	
		FROM
			testtool.tbl_pruefling
			JOIN testtool.tbl_ablauf ON (tbl_ablauf.studiengang_kz = tbl_pruefling.studiengang_kz AND tbl_ablauf.semester=tbl_pruefling.semester)
			JOIN testtool.tbl_gebiet USING (gebiet_id)
			JOIN testtool.tbl_kategorie USING(gebiet_id)
			JOIN public.tbl_prestudent USING (prestudent_id)
			JOIN public.tbl_person USING (person_id)
			JOIN public.tbl_studiengang ON (tbl_prestudent.studiengang_kz = tbl_studiengang.studiengang_kz);
			
		GRANT SELECT ON testtool.vw_auswertung_kategorie TO GROUP web;
		GRANT SELECT ON testtool.vw_auswertung_kategorie TO GROUP admin;
		
		CREATE INDEX idx_pruefling_vorschlag ON testtool.tbl_antwort USING btree (pruefling_id, vorschlag_id);
		
		DELETE FROM testtool.tbl_antwort WHERE vorschlag_id is null;
		ALTER TABLE testtool.tbl_antwort ALTER COLUMN vorschlag_id SET NOT NULL;
		";
		
		if(!pg_query($conn, $qry))
		{
			echo '<br>Fehler bei den letzten ALTER TABLES';
			$error = true;
		}
		
	}
	else 
	{
		$error = true;
	}
	
	if($error)
	{
		pg_query($conn, 'ROLLBACK;');
		echo 'FEHLER: '.pg_last_error($conn);
	}
	else 
	{
		pg_query($conn, 'COMMIT;');
		echo 'Testtool wurde erfolgreich aktualisiert';
	}
}

?>
