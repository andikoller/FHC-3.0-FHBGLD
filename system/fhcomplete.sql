/*
Created		03.07.2004
Modified		12.11.2007
Project		Datenbankintegration
Model			WebPortal
Company		Technikum Wien
Author		Christian Paminger
Version		2.1
Database		PostgreSQL 7.3 
*/


Grant all on schema public to group "admin";
Grant usage on schema public to group "web";

CREATE SCHEMA campus;
Grant all on schema campus to group "admin";
Grant usage on schema campus to group "web";

CREATE SCHEMA lehre;
Grant all on schema lehre to group "admin";
Grant usage on schema lehre to group "web";

CREATE SCHEMA bis;
Grant all on schema bis to group "admin";
Grant usage on schema bis to group "web";

CREATE SCHEMA kommune;
Grant all on schema kommune to group "admin";
Grant usage on schema kommune to group "web";

CREATE SCHEMA fue;
Grant all on schema fue to group "admin";
Grant usage on schema fue to group "web";

CREATE SCHEMA sync;
Grant all on schema sync to group "admin";

CREATE SCHEMA testtool;
Grant all on schema testtool to group "admin";
Grant usage on schema testtool to group "web";



Create table "lehre"."tbl_lehreinheit"
(
	"lehreinheit_id" Serial NOT NULL,
	"lehrveranstaltung_id" integer NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"lehrfach_id" integer NOT NULL,
	"lehrform_kurzbz" Varchar(8) NOT NULL,
	"stundenblockung" Smallint NOT NULL Default 1 Check (stundenblockung>=0),
	"wochenrythmus" Smallint NOT NULL Check (wochenrythmus>=0),
	"start_kw" Smallint Check (start_kw>0 AND start_kw<=53),
	"raumtyp" Varchar(8) NOT NULL,
	"raumtypalternativ" Varchar(8) NOT NULL,
	"sprache" Varchar(16) NOT NULL,
	"lehre" Boolean Default TRUE,
	"anmerkung" Varchar(255),
	"unr" Bigint,
	"lvnr" Bigint,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehreinheit" primary key ("lehreinheit_id")
);

Create table "public"."tbl_gruppe"
(
	"gruppe_kurzbz" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint,
	"bezeichnung" Varchar(32),
	"beschreibung" Varchar(128),
	"sichtbar" Boolean NOT NULL Default TRUE,
	"lehre" Boolean,
	"aktiv" Boolean NOT NULL Default TRUE,
	"sort" Smallint,
	"mailgrp" Boolean NOT NULL Default TRUE,
	"generiert" Boolean NOT NULL Default FALSE,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_gruppe" primary key ("gruppe_kurzbz")
);

Create table "public"."tbl_funktion"
(
	"funktion_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(64),
	"aktiv" Boolean NOT NULL Default true,
constraint "pk_tbl_funktion" primary key ("funktion_kurzbz")
);

Create table "lehre"."tbl_lehrfach"
(
	"lehrfach_id" Serial NOT NULL,
	"studiengang_kz" integer NOT NULL Default 0,
	"fachbereich_kurzbz" Varchar(16) NOT NULL,
	"kurzbz" Varchar(12) NOT NULL,
	"bezeichnung" Varchar(255),
	"farbe" Char(6),
	"aktiv" Boolean Default TRUE,
	"semester" Smallint,
	"sprache" Varchar(16) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehrfach" primary key ("lehrfach_id")
);

Create table "public"."tbl_mitarbeiter"
(
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"personalnummer" Serial NOT NULL UNIQUE,
	"telefonklappe" Varchar(8),
	"kurzbz" Varchar(8) UNIQUE,
	"lektor" Boolean NOT NULL Default 'true',
	"fixangestellt" Boolean NOT NULL Default 'false',
	"bismelden" Boolean NOT NULL Default TRUE,
	"stundensatz" Numeric(6,2),
	"ausbildungcode" integer,
	"ort_kurzbz" Varchar(8),
	"standort_kurzbz" Varchar(16),
	"anmerkung" Text,
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"updateamum" Timestamp Default now(),
	"updatevon" Varchar(16) Default 'auto',
	"ext_id" Bigint,
constraint "pk_tbl_mitarbeiter" primary key ("mitarbeiter_uid")
);

Create table "public"."tbl_ort"
(
	"ort_kurzbz" Varchar(8) NOT NULL,
	"bezeichnung" Varchar(30),
	"planbezeichnung" Varchar(5),
	"max_person" integer,
	"lehre" Boolean NOT NULL Default TRUE,
	"reservieren" Boolean NOT NULL Default FALSE,
	"aktiv" Boolean NOT NULL Default TRUE,
	"lageplan" Text,
	"dislozierung" Smallint,
	"kosten" Numeric(8,2),
	"ausstattung" Text,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_ort" primary key ("ort_kurzbz")
);

Create table "public"."tbl_benutzer"
(
	"uid" Varchar(16) NOT NULL,
	"person_id" integer NOT NULL,
	"aktiv" Boolean NOT NULL Default TRUE,
	"alias" Varchar(256) UNIQUE,
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_benutzer" primary key ("uid")
);

Create table "public"."tbl_benutzerfunktion"
(
	"benutzerfunktion_id" Serial NOT NULL,
	"fachbereich_kurzbz" Varchar(16),
	"uid" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"funktion_kurzbz" Varchar(16) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_benutzerfunktion" primary key ("benutzerfunktion_id")
);

Create table "public"."tbl_benutzergruppe"
(
	"uid" Varchar(16) NOT NULL,
	"gruppe_kurzbz" Varchar(16) NOT NULL,
	"studiensemester_kurzbz" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_benutzergruppe" primary key ("uid","gruppe_kurzbz")
);

Create table "public"."tbl_student"
(
	"student_uid" Varchar(16) NOT NULL,
	"matrikelnr" Char(15) NOT NULL Constraint "matrikelnr_student_key" UNIQUE,
	"prestudent_id" integer,
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint NOT NULL,
	"verband" Char(1) NOT NULL,
	"gruppe" Char(1) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_student" primary key ("student_uid")
);

Create table "public"."tbl_studiengang"
(
	"studiengang_kz" integer NOT NULL,
	"kurzbz" Varchar(3) NOT NULL,
	"kurzbzlang" Varchar(8) UNIQUE,
	"typ" Char(1) Default 'b' Check (typ='b' OR typ='d' OR typ='m' OR typ='l' OR typ='e'),
	"bezeichnung" Varchar(128) NOT NULL,
	"english" Varchar(128),
	"farbe" Char(6),
	"email" Varchar(64),
	"telefon" Varchar(32),
	"max_semester" Smallint Default 8 Check (max_semester >=0),
	"max_verband" Char(1) Default 'B' Check (max_verband>='A' AND max_verband<='Z'),
	"max_gruppe" Char(1) Default '2' Check (max_gruppe>='1' AND max_gruppe<='9'),
	"erhalter_kz" Smallint NOT NULL,
	"bescheid" Varchar(256),
	"bescheidbgbl1" Varchar(16),
	"bescheidbgbl2" Varchar(16),
	"bescheidgz" Varchar(16),
	"bescheidvom" Date,
	"orgform_kurzbz" Varchar(3) NOT NULL,
	"titelbescheidvom" Date,
	"aktiv" Boolean Default TRUE,
	"ext_id" Bigint,
constraint "pk_tbl_studiengang" primary key ("studiengang_kz")
);

Create table "lehre"."tbl_stunde"
(
	"stunde" Smallint NOT NULL,
	"beginn" Time,
	"ende" Time,
constraint "pk_tbl_stunde" primary key ("stunde")
);

Create table "lehre"."tbl_stundenplan"
(
	"stundenplan_id" Serial NOT NULL,
	"unr" Bigint NOT NULL Default 0,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"datum" Date,
	"stunde" Smallint NOT NULL,
	"ort_kurzbz" Varchar(8) NOT NULL,
	"gruppe_kurzbz" Varchar(16),
	"titel" Varchar(32),
	"anmerkung" Varchar(256),
	"lehreinheit_id" integer,
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint NOT NULL,
	"verband" Char(1) NOT NULL,
	"gruppe" Char(1) NOT NULL,
	"fix" Boolean Default FALSE,
	"updateamum" Timestamp Default now(),
	"updatevon" Varchar(32),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_stundenplan" primary key ("stundenplan_id")
);

Create table "campus"."tbl_zeitwunsch"
(
	"stunde" Smallint NOT NULL,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"tag" Smallint NOT NULL,
	"gewicht" Smallint NOT NULL Default -2,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_zeitwunsch" primary key ("stunde","mitarbeiter_uid","tag")
);

Create table "public"."tbl_fachbereich"
(
	"fachbereich_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(128),
	"farbe" Char(6),
	"studiengang_kz" integer NOT NULL,
	"aktiv" Boolean NOT NULL Default TRUE,
	"ext_id" Bigint,
constraint "pk_tbl_fachbereich" primary key ("fachbereich_kurzbz")
);

Create table "campus"."tbl_zeitsperre"
(
	"zeitsperre_id" Serial NOT NULL,
	"zeitsperretyp_kurzbz" Varchar(8) NOT NULL,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(32),
	"vondatum" Date NOT NULL,
	"vonstunde" Smallint,
	"bisdatum" Date NOT NULL,
	"bisstunde" Smallint,
	"vertretung_uid" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"erreichbarkeit_kurzbz" Varchar(8) NOT NULL,
constraint "pk_tbl_zeitsperre" primary key ("zeitsperre_id")
);

Create table "public"."tbl_adresse"
(
	"adresse_id" Serial NOT NULL,
	"person_id" integer,
	"name" Varchar(256),
	"strasse" Varchar(256),
	"plz" Varchar(16),
	"ort" Varchar(256),
	"gemeinde" Varchar(256),
	"nation" Varchar(3),
	"typ" Char(1),
	"heimatadresse" Boolean NOT NULL Default false,
	"zustelladresse" Boolean NOT NULL Default false,
	"firma_id" integer,
	"updateamum" Timestamp Default now(),
	"updatevon" Varchar(32) Default 'auto',
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_adresse" primary key ("adresse_id")
);

Create table "campus"."tbl_reservierung"
(
	"reservierung_id" Serial NOT NULL,
	"ort_kurzbz" Varchar(8) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"stunde" Smallint NOT NULL,
	"datum" Date NOT NULL,
	"titel" Varchar(10),
	"beschreibung" Varchar(32),
	"semester" Smallint Default 0,
	"verband" Char(1),
	"gruppe" Char(1),
	"gruppe_kurzbz" Varchar(16),
constraint "pk_tbl_reservierung" primary key ("reservierung_id")
);

Create table "public"."tbl_raumtyp"
(
	"raumtyp_kurzbz" Varchar(8) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_raumtyp" primary key ("raumtyp_kurzbz")
);

Create table "lehre"."tbl_lehrform"
(
	"lehrform_kurzbz" Varchar(8) NOT NULL,
	"bezeichnung" Varchar(256),
	"verplanen" Boolean Default TRUE,
constraint "pk_tbl_lehrform" primary key ("lehrform_kurzbz")
);

Create table "public"."tbl_berechtigung"
(
	"berechtigung_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_berechtigung" primary key ("berechtigung_kurzbz")
);

Create table "public"."tbl_benutzerberechtigung"
(
	"benutzerberechtigung_id" Serial NOT NULL,
	"art" Varchar(5) NOT NULL Default 'r',
	"fachbereich_kurzbz" Varchar(16),
	"studiengang_kz" integer,
	"berechtigung_kurzbz" Varchar(16) NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"studiensemester_kurzbz" Varchar(16),
	"start" Date,
	"ende" Date,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_benutzerberechtigung" primary key ("benutzerberechtigung_id")
);

Create table "public"."tbl_studiensemester"
(
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(32),
	"start" Date,
	"ende" Date,
	"ext_id" Bigint,
constraint "pk_tbl_studiensemester" primary key ("studiensemester_kurzbz")
);

Create table "lehre"."tbl_stundenplandev"
(
	"stundenplandev_id" Serial NOT NULL,
	"lehreinheit_id" integer,
	"unr" Bigint NOT NULL Default 0,
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint NOT NULL,
	"verband" Char(1) NOT NULL,
	"gruppe" Char(1) NOT NULL,
	"gruppe_kurzbz" Varchar(16),
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"ort_kurzbz" Varchar(8) NOT NULL,
	"datum" Date,
	"stunde" Smallint NOT NULL,
	"titel" Varchar(32),
	"anmerkung" Varchar(256),
	"fix" Boolean Default FALSE,
	"updateamum" Timestamp Default now(),
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_stundenplandev" primary key ("stundenplandev_id")
);

Create table "public"."tbl_betriebsmittelperson"
(
	"betriebsmittel_id" integer NOT NULL,
	"person_id" integer NOT NULL,
	"anmerkung" Varchar(256),
	"kaution" Numeric(6,2),
	"ausgegebenam" Date,
	"retouram" Date,
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_betriebsmittelperson" primary key ("betriebsmittel_id","person_id")
);

Create table "campus"."tbl_bmreservierung"
(
	"bmreservierung_id" Serial NOT NULL,
	"betriebsmittel_id" integer NOT NULL,
	"person_id" integer NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"datum" Date NOT NULL,
	"stunde" Smallint NOT NULL,
	"titel" Varchar(10),
	"beschreibung" Varchar(32),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_bmreservierung" primary key ("bmreservierung_id")
);

Create table "lehre"."tbl_ferien"
(
	"bezeichnung" Varchar(64) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"vondatum" Date,
	"bisdatum" Date,
constraint "pk_tbl_ferien" primary key ("bezeichnung","studiengang_kz")
);

Create table "public"."tbl_ortraumtyp"
(
	"ort_kurzbz" Varchar(8) NOT NULL,
	"hierarchie" Smallint NOT NULL,
	"raumtyp_kurzbz" Varchar(8) NOT NULL,
constraint "pk_tbl_ortraumtyp" primary key ("ort_kurzbz","hierarchie")
);

Create table "lehre"."tbl_zeitfenster"
(
	"wochentag" Smallint NOT NULL Default 0 Check (wochentag>=0 AND wochentag<=7),
	"stunde" Smallint NOT NULL,
	"ort_kurzbz" Varchar(8) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"gewicht" Smallint NOT NULL Check (gewicht>=(-1)),
constraint "pk_tbl_zeitfenster" primary key ("wochentag","stunde","ort_kurzbz","studiengang_kz")
);

Create table "public"."tbl_variable"
(
	"name" Varchar(64) NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"wert" Varchar(64),
constraint "pk_tbl_variable" primary key ("name","uid")
);

Create table "public"."tbl_sprache"
(
	"sprache" Varchar(16) NOT NULL UNIQUE,
constraint "pk_tbl_sprache" primary key ("sprache")
);

Create table "campus"."tbl_lvinfo"
(
	"lehrveranstaltung_id" integer NOT NULL,
	"sprache" Varchar(16) NOT NULL,
	"titel" Varchar(256),
	"lehrziele" Text,
	"lehrinhalte" Text,
	"methodik" Text,
	"voraussetzungen" Text,
	"unterlagen" Text,
	"pruefungsordnung" Text,
	"anmerkung" Text,
	"kurzbeschreibung" Text,
	"genehmigt" Boolean NOT NULL Default FALSE,
	"aktiv" Boolean NOT NULL Default TRUE,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_lvinfo" primary key ("lehrveranstaltung_id","sprache")
);

Create table "campus"."tbl_feedback"
(
	"feedback_id" Serial NOT NULL,
	"betreff" Varchar(128),
	"text" Text,
	"datum" Date NOT NULL Default now(),
	"uid" Varchar(16) NOT NULL,
	"lehrveranstaltung_id" integer NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_feedback" primary key ("feedback_id")
);

Create table "campus"."tbl_news"
(
	"news_id" Serial NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"fachbereich_kurzbz" Varchar(16),
	"semester" Smallint,
	"betreff" Varchar(128),
	"text" Text,
	"datum" Date Default now(),
	"verfasser" Varchar(64),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_news" primary key ("news_id")
);

Create table "campus"."tbl_benutzerlvstudiensemester"
(
	"uid" Varchar(16) NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"lehrveranstaltung_id" integer NOT NULL,
constraint "pk_tbl_benutzerlvstudiensemester" primary key ("uid","studiensemester_kurzbz","lehrveranstaltung_id")
);

Create table "public"."tbl_person"
(
	"person_id" Serial NOT NULL,
	"staatsbuergerschaft" Varchar(3),
	"geburtsnation" Varchar(3),
	"sprache" Varchar(16),
	"anrede" Varchar(16),
	"titelpost" Varchar(32),
	"titelpre" Varchar(64),
	"nachname" Varchar(64) NOT NULL,
	"vorname" Varchar(32),
	"vornamen" Varchar(128),
	"gebdatum" Date Default date('now'::text),
	"gebort" Varchar(128),
	"gebzeit" Time,
	"foto" Text,
	"anmerkung" Text,
	"homepage" Varchar(256),
	"svnr" Char(10) UNIQUE,
	"ersatzkennzeichen" Char(10) UNIQUE,
	"familienstand" Char(1),
	"geschlecht" Char(1) NOT NULL Default 'm' Check (geschlecht='m' OR geschlecht='w'),
	"anzahlkinder" Smallint,
	"aktiv" Boolean NOT NULL Default TRUE,
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_person" primary key ("person_id")
);

Create table "public"."tbl_erhalter"
(
	"erhalter_kz" Smallint NOT NULL,
	"kurzbz" Varchar(5),
	"bezeichnung" Varchar(255),
	"dvr" Varchar(8),
	"logo" Text,
	"zvr" Varchar(16),
constraint "pk_tbl_erhalter" primary key ("erhalter_kz")
);

Create table "public"."tbl_lehrverband"
(
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint NOT NULL,
	"verband" Char(1) NOT NULL,
	"gruppe" Char(1) NOT NULL,
	"aktiv" Boolean Default TRUE,
	"bezeichnung" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehrverband" primary key ("studiengang_kz","semester","verband","gruppe")
);

Create table "bis"."tbl_gemeinde"
(
	"gemeinde_id" Serial NOT NULL,
	"plz" Smallint,
	"name" Varchar(64),
	"ortschaftskennziffer" integer,
	"ortschaftsname" Varchar(64),
	"bulacode" integer,
	"bulabez" Varchar(5),
	"kennziffer" integer,
constraint "pk_tbl_gemeinde" primary key ("gemeinde_id")
);

Create table "public"."tbl_log"
(
	"log_id" Serial NOT NULL,
	"executetime" Timestamp NOT NULL Default now(),
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"beschreibung" Varchar(64),
	"sql" Text NOT NULL,
	"sqlundo" Text,
constraint "pk_tbl_log" primary key ("log_id")
);

Create table "public"."tbl_konto"
(
	"buchungsnr" Serial NOT NULL,
	"person_id" integer NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"buchungstyp_kurzbz" Varchar(32) NOT NULL,
	"buchungsnr_verweis" integer,
	"betrag" Numeric(8,2),
	"buchungsdatum" Date,
	"buchungstext" Varchar(256),
	"mahnspanne" Smallint,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_konto" primary key ("buchungsnr")
);

Create table "campus"."tbl_uebung"
(
	"uebung_id" Serial NOT NULL,
	"gewicht" Smallint Default 1,
	"punkte" Numeric(6,2),
	"angabedatei" Varchar(256),
	"freigabevon" Timestamp,
	"freigabebis" Timestamp,
	"abgabe" Boolean,
	"beispiele" Boolean,
	"statistik" Boolean NOT NULL Default FALSE,
	"bezeichnung" Varchar(32),
	"positiv" Boolean Default false,
	"defaultbemerkung" Text,
	"lehreinheit_id" integer NOT NULL,
	"maxstd" Smallint,
	"maxbsp" Smallint,
	"liste_id" integer,
	"prozent" Boolean NOT NULL Default TRUE,
	"nummer" Smallint,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_uebung" primary key ("uebung_id")
);

Create table "campus"."tbl_studentuebung"
(
	"student_uid" Varchar(16) NOT NULL,
	"mitarbeiter_uid" Varchar(16),
	"abgabe_id" integer,
	"uebung_id" integer NOT NULL,
	"note" Smallint,
	"mitarbeitspunkte" Numeric(6,2),
	"punkte" Numeric(6,2),
	"anmerkung" Text,
	"benotungsdatum" Timestamp,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_studentuebung" primary key ("student_uid","uebung_id")
);

Create table "lehre"."tbl_lehrveranstaltung"
(
	"lehrveranstaltung_id" Serial NOT NULL,
	"kurzbz" Varchar(16),
	"bezeichnung" Varchar(128),
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint,
	"sprache" Varchar(16) NOT NULL,
	"ects" Numeric(5,2),
	"semesterstunden" Smallint,
	"anmerkung" Varchar(64),
	"lehre" Boolean,
	"lehreverzeichnis" Varchar(16),
	"aktiv" Boolean NOT NULL Default true,
	"planfaktor" Numeric(3,2),
	"planlektoren" Smallint,
	"planpersonalkosten" Numeric(7,2),
	"plankostenprolektor" Numeric(6,2),
	"koordinator" Varchar(16),
	"sort" Smallint Default 0,
	"zeugnis" Boolean Default true,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehrveranstaltung" primary key ("lehrveranstaltung_id")
);

Create table "lehre"."tbl_lehreinheitgruppe"
(
	"lehreinheitgruppe_id" Serial NOT NULL,
	"lehreinheit_id" integer NOT NULL,
	"studiengang_kz" integer,
	"semester" Smallint,
	"verband" Char(1),
	"gruppe" Char(1),
	"gruppe_kurzbz" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehreinheitgruppe" primary key ("lehreinheitgruppe_id")
);

Create table "campus"."tbl_beispiel"
(
	"beispiel_id" Serial NOT NULL,
	"uebung_id" integer NOT NULL,
	"nummer" Smallint,
	"bezeichnung" Varchar(32),
	"punkte" Numeric(6,2),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_beispiel" primary key ("beispiel_id")
);

Create table "campus"."tbl_studentbeispiel"
(
	"student_uid" Varchar(16) NOT NULL,
	"beispiel_id" integer NOT NULL,
	"vorbereitet" Boolean Default false,
	"probleme" Boolean Default false,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
constraint "pk_tbl_studentbeispiel" primary key ("student_uid","beispiel_id")
);

Create table "campus"."tbl_notenschluessel"
(
	"lehreinheit_id" integer NOT NULL,
	"note" Smallint NOT NULL,
	"punkte" Numeric(6,2) NOT NULL Default 0,
constraint "pk_tbl_notenschluessel" primary key ("lehreinheit_id","note")
);

Create table "campus"."tbl_legesamtnote"
(
	"student_uid" Varchar(16) NOT NULL,
	"lehreinheit_id" integer NOT NULL,
	"note" Smallint,
	"benotungsdatum" Date,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_legesamtnote" primary key ("student_uid","lehreinheit_id")
);

Create table "public"."tbl_status"
(
	"status_kurzbz" Varchar(20) NOT NULL,
	"beschreibung" Varchar(20),
	"anmerkung" Varchar(20),
	"ext_id" Bigint,
constraint "pk_tbl_status" primary key ("status_kurzbz")
);

Create table "public"."tbl_prestudentstatus"
(
	"prestudent_id" integer NOT NULL,
	"status_kurzbz" Varchar(20) NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"ausbildungssemester" Smallint NOT NULL Default 1,
	"datum" Date,
	"orgform_kurzbz" Varchar(3),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_prestudentstatus" primary key ("prestudent_id","status_kurzbz","studiensemester_kurzbz","ausbildungssemester")
);

Create table "public"."tbl_prestudent"
(
	"prestudent_id" Serial NOT NULL,
	"aufmerksamdurch_kurzbz" Varchar(16) NOT NULL,
	"person_id" integer NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"berufstaetigkeit_code" integer,
	"ausbildungcode" integer,
	"zgv_code" integer,
	"zgvort" Varchar(64),
	"zgvdatum" Date,
	"zgvmas_code" integer,
	"zgvmaort" Varchar(64),
	"zgvmadatum" Date,
	"aufnahmeschluessel" Varchar(16),
	"facheinschlberuf" Boolean,
	"reihungstest_id" integer,
	"anmeldungreihungstest" Date,
	"reihungstestangetreten" Boolean NOT NULL Default FALSE,
	"punkte" Numeric(6,2),
	"bismelden" Boolean NOT NULL Default TRUE,
	"anmerkung" Text,
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_prestudent" primary key ("prestudent_id")
);

Create table "bis"."tbl_bisfunktion"
(
	"bisverwendung_id" integer NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"sws" Numeric(5,2),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_bisfunktion" primary key ("bisverwendung_id","studiengang_kz")
);

Create table "bis"."tbl_bisverwendung"
(
	"bisverwendung_id" Serial NOT NULL,
	"ba1code" integer NOT NULL,
	"ba2code" integer NOT NULL,
	"vertragsstunden" Numeric(5,2),
	"beschausmasscode" integer NOT NULL,
	"verwendung_code" Smallint NOT NULL,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"hauptberufcode" integer,
	"hauptberuflich" Boolean,
	"habilitation" Boolean,
	"beginn" Date,
	"ende" Date,
	"updateamum" Timestamp Default now(),
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_bisverwendung" primary key ("bisverwendung_id")
);

Create table "bis"."tbl_hauptberuf"
(
	"hauptberufcode" integer NOT NULL,
	"bezeichnung" Varchar(64),
constraint "pk_tbl_hauptberuf" primary key ("hauptberufcode")
);

Create table "bis"."tbl_besqual"
(
	"besqualcode" integer NOT NULL,
	"besqualbez" Varchar(64),
constraint "pk_tbl_besqual" primary key ("besqualcode")
);

Create table "bis"."tbl_beschaeftigungsart1"
(
	"ba1code" integer NOT NULL,
	"ba1bez" Varchar(128),
	"ba1kurzbz" Varchar(32),
constraint "pk_tbl_beschaeftigungsart1" primary key ("ba1code")
);

Create table "bis"."tbl_beschaeftigungsart2"
(
	"ba2code" integer NOT NULL,
	"ba2bez" Varchar(16),
constraint "pk_tbl_beschaeftigungsart2" primary key ("ba2code")
);

Create table "bis"."tbl_beschaeftigungsausmass"
(
	"beschausmasscode" integer NOT NULL,
	"beschausmassbez" Varchar(32),
	"min" Smallint,
	"max" Smallint,
constraint "pk_tbl_beschaeftigungsausmass" primary key ("beschausmasscode")
);

Create table "bis"."tbl_verwendung"
(
	"verwendung_code" Smallint NOT NULL,
	"verwendungbez" Varchar(128),
constraint "pk_tbl_verwendung" primary key ("verwendung_code")
);

Create table "bis"."tbl_ausbildung"
(
	"ausbildungcode" integer NOT NULL,
	"ausbildungbez" Varchar(32),
	"ausbildungbeschreibung" Varchar(512),
constraint "pk_tbl_ausbildung" primary key ("ausbildungcode")
);

Create table "public"."tbl_kontakt"
(
	"kontakt_id" Serial NOT NULL,
	"person_id" integer,
	"firma_id" integer,
	"kontakttyp" Varchar(32) NOT NULL,
	"anmerkung" Varchar(64),
	"kontakt" Varchar(128) NOT NULL,
	"zustellung" Boolean Default false,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_kontakt" primary key ("kontakt_id")
);

Create table "public"."tbl_kontakttyp"
(
	"kontakttyp" Varchar(32) NOT NULL,
	"beschreibung" Varchar(128),
constraint "pk_tbl_kontakttyp" primary key ("kontakttyp")
);

Create table "public"."tbl_firma"
(
	"firma_id" Serial NOT NULL,
	"name" Varchar(128),
	"adresse" Varchar(256),
	"email" Varchar(128),
	"telefon" Varchar(32),
	"fax" Varchar(32),
	"anmerkung" Varchar(256),
	"firmentyp_kurzbz" Varchar(32) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_firma" primary key ("firma_id")
);

Create table "bis"."tbl_zgv"
(
	"zgv_code" integer NOT NULL,
	"zgv_bez" Varchar(64),
	"zgv_kurzbz" Varchar(16),
constraint "pk_tbl_zgv" primary key ("zgv_code")
);

Create table "bis"."tbl_berufstaetigkeit"
(
	"berufstaetigkeit_code" integer NOT NULL,
	"berufstaetigkeit_bez" Varchar(128),
	"berufstaetigkeit_kurzbz" Varchar(16),
constraint "pk_tbl_berufstaetigkeit" primary key ("berufstaetigkeit_code")
);

Create table "bis"."tbl_zgvmaster"
(
	"zgvmas_code" integer NOT NULL,
	"zgvmas_bez" Varchar(64),
	"zgvmas_kurzbz" Varchar(16),
constraint "pk_tbl_zgvmaster" primary key ("zgvmas_code")
);

Create table "public"."tbl_aufmerksamdurch"
(
	"aufmerksamdurch_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(64),
	"ext_id" Bigint,
constraint "pk_tbl_aufmerksamdurch" primary key ("aufmerksamdurch_kurzbz")
);

Create table "public"."tbl_aufnahmeschluessel"
(
	"aufnahmeschluessel" Varchar(16) NOT NULL,
constraint "pk_tbl_aufnahmeschluessel" primary key ("aufnahmeschluessel")
);

Create table "public"."tbl_reihungstest"
(
	"reihungstest_id" Serial NOT NULL,
	"studiengang_kz" integer,
	"ort_kurzbz" Varchar(8),
	"anmerkung" Varchar(64),
	"datum" Date,
	"uhrzeit" Time,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_reihungstest" primary key ("reihungstest_id")
);

Create table "public"."tbl_betriebsmittel"
(
	"betriebsmittel_id" Serial NOT NULL,
	"beschreibung" Varchar(256),
	"betriebsmitteltyp" Varchar(16) NOT NULL,
	"nummer" Varchar(32),
	"nummerintern" Varchar(32),
	"reservieren" Boolean Default FALSE,
	"ort_kurzbz" Varchar(8),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_betriebsmittel" primary key ("betriebsmittel_id")
);

Create table "lehre"."tbl_lehreinheitmitarbeiter"
(
	"lehreinheit_id" integer NOT NULL,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"lehrfunktion_kurzbz" Varchar(16) NOT NULL,
	"semesterstunden" Numeric(5,2),
	"planstunden" Smallint,
	"stundensatz" Numeric(6,2),
	"faktor" Numeric(3,2),
	"anmerkung" Varchar(256),
	"bismelden" Boolean NOT NULL Default TRUE,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_lehreinheitmitarbeiter" primary key ("lehreinheit_id","mitarbeiter_uid")
);

Create table "campus"."tbl_abgabe"
(
	"abgabe_id" Serial NOT NULL,
	"abgabedatei" Varchar(128),
	"abgabezeit" Timestamp,
	"anmerkung" Text,
constraint "pk_tbl_abgabe" primary key ("abgabe_id")
);

Create table "campus"."tbl_lvgesamtnote"
(
	"lehrveranstaltung_id" integer NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"note" Smallint,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"benotungsdatum" Timestamp,
	"freigabedatum" Timestamp,
	"freigabevon_uid" Varchar(16),
	"bemerkung" Text,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_lvgesamtnote" primary key ("lehrveranstaltung_id","studiensemester_kurzbz","student_uid")
);

Create table "lehre"."tbl_zeugnisnote"
(
	"lehrveranstaltung_id" integer NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"note" Smallint,
	"uebernahmedatum" Timestamp,
	"benotungsdatum" Timestamp,
	"bemerkung" Text,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_zeugnisnote" primary key ("lehrveranstaltung_id","student_uid","studiensemester_kurzbz")
);

Create table "lehre"."tbl_zeugnis"
(
	"zeugnis_id" Serial NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"zeugnis" Text,
	"erstelltam" Date Default now(),
	"gedruckt" Boolean Default TRUE,
	"titel" Varchar(32),
	"bezeichnung" Varchar(32),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_zeugnis" primary key ("zeugnis_id")
);

Create table "lehre"."tbl_projektarbeit"
(
	"projektarbeit_id" Serial NOT NULL,
	"projekttyp_kurzbz" Varchar(16) NOT NULL,
	"titel" Varchar(256),
	"lehreinheit_id" integer NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"firma_id" integer,
	"note" Smallint,
	"punkte" Numeric(6,2),
	"beginn" Date,
	"ende" Date,
	"faktor" Numeric(3,2),
	"freigegeben" Boolean,
	"gesperrtbis" Date,
	"stundensatz" Numeric(6,2),
	"gesamtstunden" Numeric(8,4) Default 3,
	"themenbereich" Varchar(64),
	"anmerkung" Varchar(256),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_projektarbeit" primary key ("projektarbeit_id")
);

Create table "lehre"."tbl_note"
(
	"note" Smallint NOT NULL,
	"bezeichnung" Varchar(32),
	"anmerkung" Varchar(256),
	"farbe" Char(6),
constraint "pk_tbl_note" primary key ("note")
);

Create table "lehre"."tbl_projekttyp"
(
	"projekttyp_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(128),
constraint "pk_tbl_projekttyp" primary key ("projekttyp_kurzbz")
);

Create table "lehre"."tbl_projektbetreuer"
(
	"person_id" integer NOT NULL,
	"projektarbeit_id" integer NOT NULL,
	"betreuerart_kurzbz" Varchar(16) NOT NULL,
	"note" Smallint,
	"faktor" Numeric(3,2),
	"name" Varchar(32),
	"punkte" Numeric(6,2),
	"stunden" Numeric(8,4),
	"stundensatz" Numeric(6,2),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_projektbetreuer" primary key ("person_id","projektarbeit_id","betreuerart_kurzbz")
);

Create table "public"."tbl_betriebsmitteltyp"
(
	"betriebsmitteltyp" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
	"anzahl" Smallint,
	"kaution" Numeric(6,2),
constraint "pk_tbl_betriebsmitteltyp" primary key ("betriebsmitteltyp")
);

Create table "bis"."tbl_nation"
(
	"nation_code" Varchar(3) NOT NULL,
	"entwicklungsstand" Char(1),
	"eu" Boolean,
	"ewr" Boolean,
	"kontinent" Varchar(2),
	"kurztext" Varchar(32),
	"langtext" Varchar(32),
	"engltext" Varchar(32),
	"sperre" Boolean,
constraint "pk_tbl_nation" primary key ("nation_code")
);

Create table "lehre"."tbl_abschlussbeurteilung"
(
	"abschlussbeurteilung_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(64),
constraint "pk_tbl_abschlussbeurteilung" primary key ("abschlussbeurteilung_kurzbz")
);

Create table "lehre"."tbl_abschlusspruefung"
(
	"abschlusspruefung_id" Serial NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"vorsitz" Varchar(16),
	"pruefer1" integer,
	"pruefer2" integer,
	"pruefer3" integer,
	"abschlussbeurteilung_kurzbz" Varchar(16),
	"akadgrad_id" integer NOT NULL,
	"pruefungstyp_kurzbz" Varchar(16) NOT NULL,
	"datum" Date,
	"sponsion" Date,
	"anmerkung" Varchar(256),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_abschlusspruefung" primary key ("abschlusspruefung_id")
);

Create table "lehre"."tbl_akadgrad"
(
	"akadgrad_id" Serial NOT NULL,
	"akadgrad_kurzbz" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"titel" Varchar(64),
	"geschlecht" Char(1) Default 'm',
constraint "pk_tbl_akadgrad" primary key ("akadgrad_id")
);

Create table "public"."tbl_bankverbindung"
(
	"bankverbindung_id" Serial NOT NULL,
	"person_id" integer NOT NULL,
	"name" Varchar(64),
	"anschrift" Varchar(128),
	"bic" Varchar(16),
	"blz" Varchar(16),
	"iban" Varchar(32),
	"kontonr" Varchar(16),
	"typ" Char(1),
	"verrechnung" Boolean NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_bankverbindung" primary key ("bankverbindung_id")
);

Create table "public"."tbl_semesterwochen"
(
	"semester" Smallint NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"wochen" Smallint,
constraint "pk_tbl_semesterwochen" primary key ("semester","studiengang_kz")
);

Create table "bis"."tbl_entwicklungsteam"
(
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"besqualcode" integer NOT NULL,
	"beginn" Date,
	"ende" Date,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_entwicklungsteam" primary key ("mitarbeiter_uid","studiengang_kz")
);

Create table "public"."tbl_dokument"
(
	"dokument_kurzbz" Varchar(8) NOT NULL,
	"bezeichnung" Varchar(128),
	"ext_id" Bigint,
constraint "pk_tbl_dokument" primary key ("dokument_kurzbz")
);

Create table "public"."tbl_dokumentstudiengang"
(
	"dokument_kurzbz" Varchar(8) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"ext_id" Bigint,
constraint "pk_tbl_dokumentstudiengang" primary key ("dokument_kurzbz","studiengang_kz")
);

Create table "public"."tbl_dokumentprestudent"
(
	"dokument_kurzbz" Varchar(8) NOT NULL,
	"prestudent_id" integer NOT NULL,
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"datum" Date,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_dokumentprestudent" primary key ("dokument_kurzbz","prestudent_id")
);

Create table "bis"."tbl_mobilitaetsprogramm"
(
	"mobilitaetsprogramm_code" integer NOT NULL,
	"kurzbz" Varchar(16) UNIQUE,
	"beschreibung" Varchar(128),
constraint "pk_tbl_mobilitaetsprogramm" primary key ("mobilitaetsprogramm_code")
);

Create table "bis"."tbl_zweck"
(
	"zweck_code" Varchar(20) NOT NULL,
	"kurzbz" Varchar(3) UNIQUE,
	"bezeichnung" Varchar(32),
constraint "pk_tbl_zweck" primary key ("zweck_code")
);

Create table "bis"."tbl_bisio"
(
	"bisio_id" Serial NOT NULL,
	"mobilitaetsprogramm_code" integer NOT NULL,
	"nation_code" Varchar(3) NOT NULL,
	"von" Date,
	"bis" Date,
	"zweck_code" Varchar(20) NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_bisio" primary key ("bisio_id")
);

Create table "campus"."tbl_zeitsperretyp"
(
	"zeitsperretyp_kurzbz" Varchar(8) NOT NULL,
	"beschreibung" Varchar(128),
	"farbe" Varchar(6),
constraint "pk_tbl_zeitsperretyp" primary key ("zeitsperretyp_kurzbz")
);

Create table "public"."tbl_firmentyp"
(
	"firmentyp_kurzbz" Varchar(32) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_firmentyp" primary key ("firmentyp_kurzbz")
);

Create table "lehre"."tbl_lehrfunktion"
(
	"lehrfunktion_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
	"standardfaktor" Numeric(3,2),
constraint "pk_tbl_lehrfunktion" primary key ("lehrfunktion_kurzbz")
);

Create table "lehre"."tbl_pruefung"
(
	"pruefung_id" Serial NOT NULL,
	"lehreinheit_id" integer NOT NULL,
	"student_uid" Varchar(16) NOT NULL,
	"mitarbeiter_uid" Varchar(16),
	"note" Smallint NOT NULL,
	"pruefungstyp_kurzbz" Varchar(16) NOT NULL,
	"datum" Date,
	"anmerkung" Varchar(256),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_pruefung" primary key ("pruefung_id")
);

Create table "lehre"."tbl_pruefungstyp"
(
	"pruefungstyp_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_pruefungstyp" primary key ("pruefungstyp_kurzbz")
);

Create table "public"."tbl_studentlehrverband"
(
	"student_uid" Varchar(16) NOT NULL,
	"studiensemester_kurzbz" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"semester" Smallint NOT NULL,
	"verband" Char(1) NOT NULL,
	"gruppe" Char(1) NOT NULL,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Varchar(20),
constraint "pk_tbl_studentlehrverband" primary key ("student_uid","studiensemester_kurzbz")
);

Create table "campus"."tbl_newssprache"
(
	"sprache" Varchar(16) NOT NULL,
	"news_id" integer NOT NULL,
	"betreff" Varchar(128),
	"text" Text,
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_newssprache" primary key ("sprache","news_id")
);

Create table "public"."tbl_standort"
(
	"standort_kurzbz" Varchar(16) NOT NULL,
	"adresse_id" integer NOT NULL,
constraint "pk_tbl_standort" primary key ("standort_kurzbz")
);

Create table "campus"."tbl_erreichbarkeit"
(
	"erreichbarkeit_kurzbz" Varchar(8) NOT NULL,
	"beschreibung" Varchar(256),
	"farbe" Varchar(6),
constraint "pk_tbl_erreichbarkeit" primary key ("erreichbarkeit_kurzbz")
);

Create table "campus"."tbl_notenschluesseluebung"
(
	"uebung_id" integer NOT NULL,
	"note" Smallint NOT NULL,
	"punkte" Numeric(6,2) NOT NULL Default 0,
constraint "pk_tbl_notenschluesseluebung" primary key ("uebung_id","note")
);

Create table "public"."tbl_vorlage"
(
	"vorlage_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(64),
	"anmerkung" Text,
constraint "pk_tbl_vorlage" primary key ("vorlage_kurzbz")
);

Create table "public"."tbl_vorlagestudiengang"
(
	"vorlage_kurzbz" Varchar(16) NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"version" Smallint NOT NULL,
	"text" Text,
constraint "pk_tbl_vorlagestudiengang" primary key ("vorlage_kurzbz","studiengang_kz","version")
);

Create table "lehre"."tbl_betreuerart"
(
	"betreuerart_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_betreuerart" primary key ("betreuerart_kurzbz")
);

Create table "public"."tbl_akte"
(
	"akte_id" Serial NOT NULL,
	"person_id" integer NOT NULL,
	"dokument_kurzbz" Varchar(8) NOT NULL,
	"uid" Varchar(16),
	"inhalt" Text,
	"mimetype" Varchar(128),
	"erstelltam" Date Default now(),
	"gedruckt" Boolean Default TRUE,
	"titel" Varchar(32),
	"bezeichnung" Varchar(32),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp Default now(),
	"insertvon" Varchar(16),
	"ext_id" Bigint,
constraint "pk_tbl_akte" primary key ("akte_id")
);

Create table "public"."tbl_buchungstyp"
(
	"buchungstyp_kurzbz" Varchar(32) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_buchungstyp" primary key ("buchungstyp_kurzbz")
);

Create table "campus"."tbl_resturlaub"
(
	"mitarbeiter_uid" Varchar(16) NOT NULL,
	"resturlaubstage" Smallint,
	"mehrarbeitsstunden" Numeric(6,2),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
constraint "pk_tbl_resturlaub" primary key ("mitarbeiter_uid")
);

Create table "sync"."tbl_zutrittskarte"
(
	"key" integer NOT NULL,
	"name" Varchar(32),
	"firstname" Varchar(32),
	"groupe" Varchar(32),
	"logaswnumber" Varchar(32),
	"physaswnumber" Varchar(32),
	"validstart" Date,
	"validend" Date,
	"text1" Varchar(64),
	"text2" Varchar(64),
	"text3" Varchar(64),
	"text4" Varchar(64),
	"text5" Varchar(64),
	"text6" Varchar(64),
	"pin" Varchar(64),
constraint "pk_tbl_zutrittskarte" primary key ("key")
);

Create table "bis"."tbl_orgform"
(
	"orgform_kurzbz" Varchar(3) NOT NULL UNIQUE,
	"code" Smallint UNIQUE,
	"bezeichnung" Varchar(64),
constraint "pk_tbl_orgform" primary key ("orgform_kurzbz")
);

Create table "testtool"."tbl_ablauf"
(
	"gebiet_id" integer NOT NULL Default nextval('testtool.tbl_gebiet_gebiet_id_seq'::text),
	"studiengang_kz" integer NOT NULL,
	"reihung" Smallint NOT NULL,
	"gewicht" Real NOT NULL Default 1,
constraint "pk_ablauf" primary key ("gebiet_id","studiengang_kz")
);

Create table "testtool"."tbl_antwort"
(
	"antwort_id" integer NOT NULL Default nextval('testtool.tbl_antwort_antwort_id_seq'::text),
	"frage_id" integer NOT NULL Default nextval('testtool.tbl_frage_frage_id_seq'::text),
	"pruefling_id" integer NOT NULL Default nextval('testtool.tbl_pruefling_pruefling_id_seq'::text),
	"antwort" Char(1) Constraint "tbl_antwort_antwort" Check ((ascii((antwort)::text) >= 65) AND (ascii((antwort)::text) <= 90)),
	"begintime" Timestamp Default now(),
	"endtime" Timestamp,
constraint "tbl_antwort_pkey" primary key ("antwort_id")
);

Create table "testtool"."tbl_frage"
(
	"frage_id" integer NOT NULL Default nextval('testtool.tbl_frage_frage_id_seq'::text),
	"kategorie_kurzbz" Varchar(16) NOT NULL,
	"gebiet_id" integer NOT NULL Default nextval('testtool.tbl_gebiet_gebiet_id_seq'::text),
	"gruppe_kurzbz" Char(1) NOT NULL,
	"loesung" Char(1) Constraint "tbl_frage_loesung" Check ((ascii((loesung)::text) >= 65) AND (ascii((loesung)::text) <= 90)),
	"nummer" Smallint NOT NULL,
	"demo" Boolean NOT NULL Default false,
	"text" Text,
	"bild" Text,
constraint "tbl_frage_pkey" primary key ("frage_id")
);

Create table "testtool"."tbl_gebiet"
(
	"gebiet_id" integer NOT NULL Default nextval('testtool.tbl_gebiet_gebiet_id_seq'::text),
	"kurzbz" Varchar(10) NOT NULL Constraint "tbl_gebiet_kurzbz_key" UNIQUE,
	"bezeichnung" Varchar(50),
	"beschreibung" Text,
	"zeit" Time NOT NULL,
	"abzug" Real,
	"kategorien" Boolean NOT NULL Default false,
constraint "tbl_gebiet_pkey" primary key ("gebiet_id")
);

Create table "testtool"."tbl_kategorie"
(
	"kategorie_kurzbz" Varchar(16) NOT NULL,
	"gebiet_id" integer NOT NULL Default nextval('testtool.tbl_gebiet_gebiet_id_seq'::text),
constraint "tbl_kategorie_pkey" primary key ("kategorie_kurzbz")
);

Create table "testtool"."tbl_kriterien"
(
	"gebiet_id" integer NOT NULL Default nextval('testtool.tbl_gebiet_gebiet_id_seq'::text),
	"kategorie_kurzbz" Varchar(16) NOT NULL,
	"punkte" integer NOT NULL,
	"typ" Varchar(16) NOT NULL,
 primary key ("gebiet_id","kategorie_kurzbz","punkte")
);

Create table "testtool"."tbl_pruefling"
(
	"pruefling_id" integer NOT NULL Default nextval('testtool.tbl_pruefling_pruefling_id_seq'::text),
	"prestudent_id" integer NOT NULL,
	"studiengang_kz" integer NOT NULL,
	"idnachweis" Varchar(50) Constraint "tbl_pruefling_idnachweis_key" UNIQUE,
	"registriert" Timestamp NOT NULL Default now(),
	"gruppe_kurzbz" Char(1),
constraint "tbl_pruefling_pkey" primary key ("pruefling_id")
);

Create table "testtool"."tbl_vorschlag"
(
	"vorschlag_id" integer NOT NULL Default nextval('testtool."tbl_vorschlag_vorschlagID_seq"'::text),
	"frage_id" integer NOT NULL Default nextval('testtool.tbl_frage_frage_id_seq'::text),
	"nummer" Smallint NOT NULL,
	"antwort" Char(1) Default 'A' Constraint "tbl_vorschlag_antwort" Check ((ascii((antwort)::text) >= 65) AND (ascii((antwort)::text) <= 90)),
	"text" Text,
	"bild" Text,
constraint "tbl_vorschlag_pkey" primary key ("vorschlag_id")
);

Create table "testtool"."tbl_gruppe"
(
	"gruppe_kurzbz" Char(1) NOT NULL Constraint "chk_gruppe_kurzbz" Check ((ascii((gruppe_kurzbz)::text) >= 65) AND (ascii((gruppe_kurzbz)::text) <= 90)),
constraint "pk_gruppe" primary key ("gruppe_kurzbz")
);

Create table "campus"."tbl_zeitaufzeichnung"
(
	"zeitaufzeichnung_id" Serial NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"aktivitaet_kurzbz" Varchar(16) NOT NULL,
	"projekt_kurzbz" Varchar(16) NOT NULL,
	"start" Timestamp NOT NULL,
	"ende" Timestamp,
	"beschreibung" Varchar(256),
	"studiengang_kz" integer,
	"fachbereich_kurzbz" Varchar(16),
	"insertamum" Timestamp,
	"insertvon" Varchar(16),
	"updateamum" Timestamp,
	"updatevon" Varchar(16),
constraint "pk_tbl_zeitaufzeichnung" primary key ("zeitaufzeichnung_id")
);

Create table "fue"."tbl_projekt"
(
	"projekt_kurzbz" Varchar(16) NOT NULL,
	"nummer" Char(8),
	"titel" Varchar(256),
	"beschreibung" Text,
	"beginn" Date,
	"ende" Date,
constraint "pk_tbl_projekt" primary key ("projekt_kurzbz")
);

Create table "fue"."tbl_aktivitaet"
(
	"aktivitaet_kurzbz" Varchar(16) NOT NULL,
	"beschreibung" Varchar(256),
constraint "pk_tbl_aktivitaet" primary key ("aktivitaet_kurzbz")
);

Create table "public"."tbl_personfunktionfirma"
(
	"personfunktionfirma_id" Serial NOT NULL,
	"funktion_kurzbz" Varchar(16) NOT NULL,
	"person_id" integer NOT NULL,
	"firma_id" integer NOT NULL,
	"position" Varchar(256),
	"anrede" Varchar(128),
constraint "pk_tbl_personfunktionfirma" primary key ("personfunktionfirma_id")
);

Create table "fue"."tbl_projektbenutzer"
(
	"projektbenutzer_id" Serial NOT NULL,
	"uid" Varchar(16) NOT NULL,
	"funktion_kurzbz" Varchar(16) NOT NULL,
	"projekt_kurzbz" Varchar(16) NOT NULL,
constraint "pk_tbl_projektbenutzer" primary key ("projektbenutzer_id")
);

Create table "kommune"."tbl_team"
(
	"team_kurzbz" Varchar(16) NOT NULL,
	"bezeichnung" Varchar(128),
	"beschreibung" Text,
	"logo" Text,
constraint "pk_tbl_team" primary key ("team_kurzbz")
);

Create table "kommune"."tbl_teambenutzer"
(
	"uid" Varchar(16) NOT NULL,
	"team_kurzbz" Varchar(16) NOT NULL,
constraint "pk_tbl_teambenutzer" primary key ("uid","team_kurzbz")
);

Create table "kommune"."tbl_wettbewerb"
(
	"wettbewerb_kurzbz" Varchar(16) NOT NULL,
	"regeln" Text,
	"forderungstage" Smallint,
	"einzel" Boolean NOT NULL Default TRUE,
constraint "pk_tbl_wettbewerb" primary key ("wettbewerb_kurzbz")
);

Create table "kommune"."tbl_wettbewerbteam"
(
	"team_kurzbz" Varchar(16) NOT NULL,
	"wettbewerb_kurzbz" Varchar(16) NOT NULL,
	"rang" Smallint,
	"punkte" Numeric(8,2),
constraint "pk_tbl_wettbewerbteam" primary key ("team_kurzbz","wettbewerb_kurzbz")
);

Create table "kommune"."tbl_match"
(
	"match_id" Varchar(20) NOT NULL,
	"team_sieger" Varchar(16),
	"wettbewerb_kurzbz" Varchar(16) NOT NULL,
	"team_gefordert" Varchar(16) NOT NULL,
	"team_forderer" Varchar(16) NOT NULL,
	"gefordertvon" Varchar(16) NOT NULL,
	"gefordertam" Varchar(20),
	"matchdatumzeit" Timestamp,
	"matchort" Varchar(32),
	"ergebniss" Varchar(16),
	"bestaetigtvon" Varchar(16),
	"bestaetigtamum" Timestamp,
constraint "pk_tbl_match" primary key ("match_id")
);


Comment on table "public"."tbl_gruppe" Is 'Beschreibung der Gruppen von Personen (optional auch MailGruppen)';
Comment on table "lehre"."tbl_lehrfach" Is 'Lehrfachverteilung';
Comment on table "public"."tbl_mitarbeiter" Is 'Alle Mitarbeiter des Technikum';
Comment on table "public"."tbl_ort" Is 'Orte des Technikum';
Comment on table "public"."tbl_benutzer" Is 'Tabelle aller internen Personen mit Account.';
Comment on table "public"."tbl_benutzerfunktion" Is 'Hier werden Personen nach ihren Funktionen eingeteilt.';
Comment on table "public"."tbl_student" Is 'Tabelle aller Studenten';
Comment on table "public"."tbl_studiengang" Is 'Informationen zu den Studiengaengen';
Comment on table "lehre"."tbl_stunde" Is 'Stundentafel';
Comment on table "lehre"."tbl_stundenplan" Is 'Abbildung des Stundenplans in Kalenderform. Einheitenplan wird hier nicht abgebildet -> extra Tabelle';
Comment on table "campus"."tbl_zeitwunsch" Is 'Zeitwuensche der Lektoren';
Comment on table "lehre"."tbl_stundenplandev" Is 'Abbildung des Stundenplans in Kalenderform. Einheitenplan wird hier nicht abgebildet -> extra Tabelle';
Comment on table "campus"."tbl_news" Is 'Studiengang=0 und Semester=NULL -> allgemeine News\r\nStudiengang=0 und Semester=0 -> Freifaecher\r\nStudiengang=0 und Semester>0 -> News fuer bestimmtes Semester in allen Studiengaengen\r\nStudiengang>0 und (Semester=NULL oder Semester=0) -> Alle Semester im Studiengang\r\nStudiengang>0 und Semester>0 -> News fuer bestimmtes Semester im Studiengang';
Comment on table "campus"."tbl_benutzerlvstudiensemester" Is 'Zur Anmeldung fuer die Freifaecher.';
Comment on table "public"."tbl_person" Is 'Supertabelle aller Personen';
Comment on table "testtool"."tbl_ablauf" Is 'Jeder Studiengang hat eine andere Reihenfolge der Tests';
Comment on table "testtool"."tbl_antwort" Is 'Antworten des Prueflings';
Comment on table "testtool"."tbl_frage" Is 'Fragen zu den Wissengebieten';
Comment on table "testtool"."tbl_gebiet" Is 'Die verschiedenen Wissensgebiete';
Comment on table "testtool"."tbl_pruefling" Is 'Personen die zur Pruefung antreten';
Comment on table "testtool"."tbl_vorschlag" Is 'Alle moglichen Antworten zu einer Frage';
Comment on table "testtool"."tbl_gruppe" Is 'Bei manchen Tests gibts verschiede Gruppen damit man nicht vom Nachbar abschreiben kann';



Comment on column "lehre"."tbl_lehreinheit"."stundenblockung" Is 'Wie wird der Unterricht geblockt? 1 fuer Einzelstunden, 2 fuer Doppelstunden, ....';
Comment on column "lehre"."tbl_lehreinheit"."wochenrythmus" Is 'Wiederholung des Unterrichts. 1 fuer jede Woche, 2 fuer jede 2. Woche, ... 0 steht fuer sonstiges, zb eine Blockveranstaltung am Wochenende.';
Comment on column "lehre"."tbl_lehreinheit"."start_kw" Is 'In welcher Kalenderwoche wird die erste Einheit der Lehrveranstung abgehalten.';
Comment on column "lehre"."tbl_lehreinheit"."lehre" Is 'Wird fuer eLearning verwendet?';
Comment on column "lehre"."tbl_lehreinheit"."unr" Is 'Unterrichtsnummer aus Untis. Bei Partizipierungen ist diese Nummer gleich.';
Comment on column "lehre"."tbl_lehreinheit"."ext_id" Is 'ID in einer externen Datenbank';
Comment on column "public"."tbl_ort"."lehre" Is 'Wird der Raum fuer die Lehre verwendet?';
Comment on column "public"."tbl_ort"."reservieren" Is 'Kann man den Raum reservieren?';
Comment on column "public"."tbl_ort"."dislozierung" Is 'Dislozierung der Raeume. Jedes Stockwerk bekommt eine hundererter Stelle. Also erster Stock beginnt bei 100 usw. externe Gebaeude bekommen eine tausender Stelle vorangestellt. Grundsaetzlich sollte die Dislozierungszahl die Entfernung zwischen den Orten abbilden.';
Comment on column "public"."tbl_ort"."kosten" Is 'Kosten eines Raumes pro Lehr-Einheit in Euro.';
Comment on column "public"."tbl_studiengang"."studiengang_kz" Is 'Nationale Kennzahl des Studiengangs';
Comment on column "public"."tbl_studiengang"."typ" Is 'b..Bak, d..Dipl, m..Master';
Comment on column "public"."tbl_studiengang"."email" Is 'email der Administration des Studiengangs';
Comment on column "lehre"."tbl_stunde"."beginn" Is 'Beginn der Unterrichts-Stunde';
Comment on column "lehre"."tbl_stunde"."ende" Is 'Ende der Unterrichtsstunde';
Comment on column "lehre"."tbl_stundenplan"."unr" Is 'Unterrichtsnummer';
Comment on column "public"."tbl_adresse"."typ" Is 'h=hauptwohnsitz, n=nebenwohnsitz, f=firma';
Comment on column "lehre"."tbl_stundenplandev"."unr" Is 'Unterrichtsnummer';
Comment on column "public"."tbl_ortraumtyp"."hierarchie" Is 'Die Hierarchie startet bei 1 und gibt an, als welcher Raumtyp ein Ort in erster Linie benutzt wird.';
Comment on column "lehre"."tbl_zeitfenster"."wochentag" Is '0..Alle Tage\r\n1..Montag\r\n2..Dienstag';
Comment on column "lehre"."tbl_zeitfenster"."gewicht" Is 'Prioritaet\r\n-1..nicht erlaubt.\r\n0..normal (Standard)\r\n>1..je mehr desto wichtiger';
Comment on column "public"."tbl_person"."sprache" Is 'Muttersprache';
Comment on column "public"."tbl_person"."familienstand" Is 'v=verheiratet, l=ledig, g=geschieden, w=verwitwert';
Comment on column "public"."tbl_person"."geschlecht" Is 'm=maennlich, w=weiblich';
Comment on column "campus"."tbl_uebung"."statistik" Is 'Statistik fuer Studenten sichtbar?';
Comment on column "campus"."tbl_uebung"."maxstd" Is 'Maximale Studenten pro Beispiel';
Comment on column "campus"."tbl_uebung"."maxbsp" Is 'Maximale Beispiele pro Student';
Comment on column "lehre"."tbl_lehrveranstaltung"."sprache" Is 'Sprache in der Unterrichtet wird.';
Comment on column "lehre"."tbl_lehrveranstaltung"."lehre" Is 'CIS?';
Comment on column "lehre"."tbl_lehrveranstaltung"."koordinator" Is 'Koordinator';
Comment on column "campus"."tbl_notenschluessel"."punkte" Is 'Mindestpunkte fuer die jeweilige Note.';
Comment on column "public"."tbl_prestudentstatus"."studiensemester_kurzbz" Is 'Wann will der Student beginnen?';
Comment on column "public"."tbl_prestudent"."ausbildungcode" Is 'letzte abgeschlossene Ausbildung';
Comment on column "bis"."tbl_bisfunktion"."sws" Is 'Semesterwochenstunden';
Comment on column "bis"."tbl_bisverwendung"."hauptberuflich" Is 'Hauptberuflich in der Lehre taetig?';
Comment on column "lehre"."tbl_lehreinheitmitarbeiter"."semesterstunden" Is 'Zu bezahlende Stunden';
Comment on column "lehre"."tbl_lehreinheitmitarbeiter"."planstunden" Is 'Zu verplanende Stunden';
Comment on column "lehre"."tbl_zeugnis"."zeugnis" Is 'HexKodiertes PDF';
Comment on column "lehre"."tbl_pruefung"."mitarbeiter_uid" Is 'Notengebender Lektor';
Comment on column "campus"."tbl_notenschluesseluebung"."punkte" Is 'Mindestpunkte fuer die jeweilige Note.';
Comment on column "testtool"."tbl_ablauf"."reihung" Is 'Welches Gebiet kommt wann (Reihenfolge der Gebiete)';
Comment on column "testtool"."tbl_ablauf"."gewicht" Is 'Wie wichtig ist welchem Studiengang welches Wissensgebiet (normal 1)';
Comment on column "testtool"."tbl_antwort"."antwort" Is 'Buchstabe der abgegebenen Antwort';
Comment on column "testtool"."tbl_antwort"."begintime" Is 'Zeit der erstmaligen Ansicht der jeweiligen Frage';
Comment on column "testtool"."tbl_antwort"."endtime" Is 'Zeit der letzten Aenderung';
Comment on column "testtool"."tbl_frage"."loesung" Is 'richtige Loesung';
Comment on column "testtool"."tbl_frage"."nummer" Is 'Nummerierung der Fragen fuer die Reihenfolge';
Comment on column "testtool"."tbl_frage"."demo" Is 'liefert True wenn es sich um ein Demobeispiel zum Probieren handelt';
Comment on column "testtool"."tbl_gebiet"."zeit" Is 'Maximale Zeit fuer dieses Gebiet';
Comment on column "testtool"."tbl_gebiet"."abzug" Is 'Bei falscher Antwort gibt es Punkteabzug';
Comment on column "testtool"."tbl_gebiet"."kategorien" Is 'Werden hier kategorien verwendet?';
Comment on column "testtool"."tbl_pruefling"."idnachweis" Is 'SVNr, Reisepassnr, Personalausweis, etc.';
Comment on column "testtool"."tbl_pruefling"."registriert" Is 'Timestamp beim ersten Login';
Comment on column "testtool"."tbl_vorschlag"."nummer" Is 'Reihenfolge der moeglichen Antworten';
Comment on column "testtool"."tbl_vorschlag"."antwort" Is 'Buchstabe dieser moeglichen Antwort';
Comment on column "testtool"."tbl_vorschlag"."text" Is 'Text zu dieser moeglichen Antwort';
Comment on column "testtool"."tbl_gruppe"."gruppe_kurzbz" Is 'Gruppenbuchstabe (meistens A und B)';



Create index "idx_lehreinheit_lehrfach_id" on "lehre"."tbl_lehreinheit" using btree ("lehrfach_id");
Create index "idx_lehreinheit_raumtyp" on "lehre"."tbl_lehreinheit" using btree ("raumtyp");
Create index "idx_lehreinheit_raumtypalternativ" on "lehre"."tbl_lehreinheit" using btree ("raumtypalternativ");
Create index "idx_lehreinheit_studiensemester_kurzbz" on "lehre"."tbl_lehreinheit" using btree ("studiensemester_kurzbz");
Create index "idx_benutzerfunktion_funktion_kurzbz" on "public"."tbl_benutzerfunktion" using btree ("funktion_kurzbz");
Create index "idx_stundenplan_datum" on "lehre"."tbl_stundenplan" using btree ("datum");
Create index "idx_stundenplan_lektor" on "lehre"."tbl_stundenplan" using btree ("mitarbeiter_uid");
Create index "idx_stundenplan_stunde" on "lehre"."tbl_stundenplan" using btree ("stunde");
Create index "idx_stundenplan_ort_kurzbz" on "lehre"."tbl_stundenplan" using btree ("ort_kurzbz");
Create index "idx_stundenplan_einheit_kurzbz" on "lehre"."tbl_stundenplan" using btree ("gruppe_kurzbz");
Create index "idx_stundenplan_datum_lektor" on "lehre"."tbl_stundenplan" using btree ("datum","mitarbeiter_uid");
Create index "idx_stundenplan_datum_gruppe" on "lehre"."tbl_stundenplan" using btree ("datum","gruppe_kurzbz");
Create index "idx_stundenplan_datum_ort" on "lehre"."tbl_stundenplan" using btree ("datum","ort_kurzbz");
Create index "idx_stundenplan_datum_stgsemvergrp" on "lehre"."tbl_stundenplan" using btree ("datum","semester","studiengang_kz","verband","gruppe");
Create index "idx_stundenplan_datum_stgsemver" on "lehre"."tbl_stundenplan" using btree ("datum","semester","studiengang_kz","verband");
Create index "idx_stundenplan_datum_stgsem" on "lehre"."tbl_stundenplan" using btree ("datum","studiengang_kz","semester");
Create index "idx_stundenplan_datum_stg" on "lehre"."tbl_stundenplan" using btree ("datum","studiengang_kz");
Create index "idx_zeitwunsch_uid" on "campus"."tbl_zeitwunsch" using btree ("mitarbeiter_uid");
Create index "idx_zeitsperre_uid" on "campus"."tbl_zeitsperre" using btree ("mitarbeiter_uid");
Create index "idx_adresse_person" on "public"."tbl_adresse" using btree ("person_id");
Create index "idx_userberechtigung_uid" on "public"."tbl_benutzerberechtigung" using btree ("uid");
Create index "idx_stundenplandev_datum" on "lehre"."tbl_stundenplandev" using btree ("datum");
Create index "idx_stundenplandev_lektor" on "lehre"."tbl_stundenplandev" using btree ("mitarbeiter_uid");
Create index "idx_stundenplandev_stunde" on "lehre"."tbl_stundenplandev" using btree ("stunde");
Create index "idx_stundenplandev_ort_kurzbz" on "lehre"."tbl_stundenplandev" using btree ("ort_kurzbz");
Create index "idx_stundenplandev_einheit_kurzbz" on "lehre"."tbl_stundenplandev" using btree ("gruppe_kurzbz");
Create index "idx_stundenplandev_datum_stgsemvergrp" on "lehre"."tbl_stundenplandev" using btree ("datum","studiengang_kz","semester","verband","gruppe");
Create index "idx_stundenplandev_datum_stgsemver" on "lehre"."tbl_stundenplandev" using btree ("datum","studiengang_kz","semester","verband");
Create index "idx_stundenplandev_datum_stgsem" on "lehre"."tbl_stundenplandev" using btree ("datum","studiengang_kz","semester");
Create index "idx_stundenplandev_datum_stg" on "lehre"."tbl_stundenplandev" using btree ("datum","studiengang_kz");
Create index "idx_stundenplandev_datum_lektor" on "lehre"."tbl_stundenplandev" using btree ("datum","mitarbeiter_uid");
Create index "idx_stundenplandev_datum_ort" on "lehre"."tbl_stundenplandev" using btree ("datum","ort_kurzbz");
Create index "idx_stundenplandev_datum_gruppe" on "lehre"."tbl_stundenplandev" using btree ("datum","gruppe_kurzbz");
Create index "idx_betriebsmittelperson_person_id" on "public"."tbl_betriebsmittelperson" using btree ("person_id");
Create index "idx_betriebsmittelperson_betriebsmittel_id" on "public"."tbl_betriebsmittelperson" using btree ("betriebsmittel_id");
Create index "idx_ortraumtyp_raumtypkurzbz" on "public"."tbl_ortraumtyp" using btree ("raumtyp_kurzbz");
Create index "idx_person_nachname" on "public"."tbl_person" using btree ("nachname");
Create index "idx_konto_person_id" on "public"."tbl_konto" using btree ("person_id");
Create unique index "uidx_lehreinheitgruppe_lehreinheitid_studiengangkz_semester_ver" on "lehre"."tbl_lehreinheitgruppe" using btree ("lehreinheit_id","studiengang_kz","semester","verband","gruppe","gruppe_kurzbz");
Create index "idx_lehreinheitgruppe_lehreinheit_id" on "lehre"."tbl_lehreinheitgruppe" using btree ("lehreinheit_id");
Create unique index "uidx_beispiel_bezeichnunguebungid" on "campus"."tbl_beispiel" using btree ("uebung_id","bezeichnung");
Create index "idx_kontakt_person" on "public"."tbl_kontakt" using btree ("person_id");
Create index "idx_lehreinheitmitarbeiter_mitarbeiter_uid" on "lehre"."tbl_lehreinheitmitarbeiter" using btree ("mitarbeiter_uid");
Create index "idx_abschlusspruefung_student_uid" on "lehre"."tbl_abschlusspruefung" using btree ("student_uid");
Create index "idx_abschlusspruefung_vorsitz" on "lehre"."tbl_abschlusspruefung" using btree ("vorsitz");
Create index "idx_antwort_pruefling_frage" on "testtool"."tbl_antwort" using btree ("pruefling_id","frage_id");
Create index "idx_antwort_pruefling_id" on "testtool"."tbl_antwort" using btree ("pruefling_id");
Create index "idx_antwort_frage_id" on "testtool"."tbl_antwort" using btree ("frage_id");
Create index "idx_frage_gruppe_gebiet" on "testtool"."tbl_frage" using btree ("gruppe_kurzbz","gebiet_id");
Create index "idx_frage_gruppe_kurzbz" on "testtool"."tbl_frage" using btree ("gruppe_kurzbz");
Create index "idx_frage_demo" on "testtool"."tbl_frage" using btree ("demo");
Create index "idx_frage_gebiet_id" on "testtool"."tbl_frage" using btree ("gebiet_id");
Create index "idx_pruefling_studiengang_kz" on "testtool"."tbl_pruefling" using btree ("studiengang_kz");
Create index "idx_pruefling_prestudent_id" on "testtool"."tbl_pruefling" using btree ("prestudent_id");



Alter table "lehre"."tbl_stundenplan" add Constraint "lehreinheit_stundenplan" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update restrict on delete restrict;
Alter table "lehre"."tbl_stundenplandev" add Constraint "lehreinheit_stundenplandev" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update restrict on delete restrict;
Alter table "lehre"."tbl_lehreinheitgruppe" add Constraint "lehreinheit_gruppelehreinheit" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete cascade;
Alter table "lehre"."tbl_lehreinheitmitarbeiter" add Constraint "lehreinheit_lehreinheitmitarbeiter" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete cascade;
Alter table "campus"."tbl_notenschluessel" add Constraint "lehreinheit_notenschluessel" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete restrict;
Alter table "campus"."tbl_uebung" add Constraint "lehreinheit_uebung" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete restrict;
Alter table "campus"."tbl_legesamtnote" add Constraint "lehreinheit_legesamtnote" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektarbeit" add Constraint "lehreinheit_projektarbeit" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_pruefung" add Constraint "lehreinheit_pruefung" foreign key ("lehreinheit_id") references "lehre"."tbl_lehreinheit" ("lehreinheit_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplan" add Constraint "gruppe_stundenplan" foreign key ("gruppe_kurzbz") references "public"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplandev" add Constraint "gruppe_stundenplandev" foreign key ("gruppe_kurzbz") references "public"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_reservierung" add Constraint "gruppe_reservierung" foreign key ("gruppe_kurzbz") references "public"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete cascade;
Alter table "public"."tbl_benutzergruppe" add Constraint "gruppe_persongruppe" foreign key ("gruppe_kurzbz") references "public"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete cascade;
Alter table "lehre"."tbl_lehreinheitgruppe" add Constraint "gruppe_lehreinheitgruppe" foreign key ("gruppe_kurzbz") references "public"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_benutzerfunktion" add Constraint "funktion_personfunktion" foreign key ("funktion_kurzbz") references "public"."tbl_funktion" ("funktion_kurzbz") on update cascade on delete cascade;
Alter table "public"."tbl_personfunktionfirma" add Constraint "funktion_personfunktionfirma" foreign key ("funktion_kurzbz") references "public"."tbl_funktion" ("funktion_kurzbz") on update cascade on delete restrict;
Alter table "fue"."tbl_projektbenutzer" add Constraint "funktion_projektbenutzer" foreign key ("funktion_kurzbz") references "public"."tbl_funktion" ("funktion_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "lehrfach_lehreinheit" foreign key ("lehrfach_id") references "lehre"."tbl_lehrfach" ("lehrfach_id") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitwunsch" add Constraint "lektor_zeitwunsch" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete cascade;
Alter table "campus"."tbl_zeitsperre" add Constraint "lektor_zeitsperre" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete cascade;
Alter table "lehre"."tbl_stundenplan" add Constraint "lektor_stundenplan" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplandev" add Constraint "mitarbeiter_stundenplandev" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "mitarbeiter_bisverwendung" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheitmitarbeiter" add Constraint "mitarbeiter_lehreinheitmitarbeiter" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "mitarbeiter_lvgesamtnote" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_studentuebung" add Constraint "mitarbeiter_studentuebung" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "public"."tbl_log" add Constraint "mitarbeiter_log" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "bis"."tbl_entwicklungsteam" add Constraint "mitarbeiter_entwickungsteam" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "public"."tbl_dokumentprestudent" add Constraint "mitarbeiter_dokumentprestudent" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitsperre" add Constraint "vertretung_zeitsperre" foreign key ("vertretung_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "mitarbeitervorsitz_abschlusspruefung" foreign key ("vorsitz") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_pruefung" add Constraint "mitarbeiter_pruefung" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_resturlaub" add Constraint "mitarbeiter_resturlaub" foreign key ("mitarbeiter_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "freigabevon_lvgesamtnote" foreign key ("freigabevon_uid") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehrveranstaltung" add Constraint "mitarbeiter_lehrveranstaltung" foreign key ("koordinator") references "public"."tbl_mitarbeiter" ("mitarbeiter_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplan" add Constraint "ort_stundenplan" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplandev" add Constraint "ort_stundenplandev" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_reservierung" add Constraint "ort_reservierung" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_ortraumtyp" add Constraint "ort_ortraumtyp" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete cascade;
Alter table "lehre"."tbl_zeitfenster" add Constraint "ort_zeitfenster" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update restrict on delete restrict;
Alter table "public"."tbl_reihungstest" add Constraint "ort_reihungstest" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_mitarbeiter" add Constraint "ort_mitarbeiter" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_betriebsmittel" add Constraint "ort_betriebsmittel" foreign key ("ort_kurzbz") references "public"."tbl_ort" ("ort_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_benutzergruppe" add Constraint "benutzer_personmailgrp" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "campus"."tbl_reservierung" add Constraint "benutzer_reservierung" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerfunktion" add Constraint "benutzer_benutzerfunktion" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "public"."tbl_student" add Constraint "benutzer_student" foreign key ("student_uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "public"."tbl_mitarbeiter" add Constraint "person_mitarbeiter" foreign key ("mitarbeiter_uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerberechtigung" add Constraint "benutzer_userberechtigung" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "campus"."tbl_bmreservierung" add Constraint "benutzer_lmreservierung" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "campus"."tbl_news" add Constraint "person_news" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "campus"."tbl_benutzerlvstudiensemester" add Constraint "benutzer_benutzerlvstudiensemester" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete cascade;
Alter table "campus"."tbl_feedback" add Constraint "benutzer_feedback" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "public"."tbl_variable" add Constraint "benutzer_variable" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "public"."tbl_akte" add Constraint "benutzer_akte" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitaufzeichnung" add Constraint "benutzer_zeitaufzeichnung" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "fue"."tbl_projektbenutzer" add Constraint "benutzer_projektbenutzer" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "kommune"."tbl_teambenutzer" add Constraint "benutzer_teambenutzer" foreign key ("uid") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "benutzer_match-gefordertvon" foreign key ("gefordertvon") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "benutzer_match-bestaetigtvon" foreign key ("bestaetigtvon") references "public"."tbl_benutzer" ("uid") on update cascade on delete restrict;
Alter table "campus"."tbl_studentuebung" add Constraint "student_studentuebung" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_studentbeispiel" add Constraint "student_studentbeispiel" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_legesamtnote" add Constraint "student_legesamtnote" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "student_lvgesamtnote" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeugnisnote" add Constraint "student_zeugnisnote" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeugnis" add Constraint "student_zeugnis" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektarbeit" add Constraint "student_projektarbeit" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "student_abschlusspruefung" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "bis"."tbl_bisio" add Constraint "student_bisio" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "lehre"."tbl_pruefung" add Constraint "student_pruefung" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "public"."tbl_studentlehrverband" add Constraint "student_studentlehrverband" foreign key ("student_uid") references "public"."tbl_student" ("student_uid") on update cascade on delete restrict;
Alter table "public"."tbl_gruppe" add Constraint "studiengang_gruppe" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete cascade;
Alter table "campus"."tbl_reservierung" add Constraint "studiengang_reservierung" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerfunktion" add Constraint "studiengang_personfunktion" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete cascade;
Alter table "public"."tbl_fachbereich" add Constraint "studiengang_fachbereich" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_benutzerberechtigung" add Constraint "studiengang_userberechtigung" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete cascade;
Alter table "lehre"."tbl_ferien" add Constraint "studiengang_ferien" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete cascade;
Alter table "lehre"."tbl_zeitfenster" add Constraint "studiengang_zeitfenster" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update restrict on delete restrict;
Alter table "lehre"."tbl_lehrfach" add Constraint "studiengang_lehrfach" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "campus"."tbl_news" add Constraint "studiengang_news" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_lehrverband" add Constraint "studiengang_lehrverband" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_konto" add Constraint "studiengang_konto" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehrveranstaltung" add Constraint "studiengang_lehrveranstaltung" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "studiengang_prestudent" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "bis"."tbl_bisfunktion" add Constraint "studiengang_bisfunktion" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_reihungstest" add Constraint "studiengang_reihungstest" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "lehre"."tbl_akadgrad" add Constraint "studiengang_akadgrad" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_semesterwochen" add Constraint "studiengang_semesterwochen" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "bis"."tbl_entwicklungsteam" add Constraint "studiengang_entwicklungsteam" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_dokumentstudiengang" add Constraint "studiengang_dokumentstudiengang" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "public"."tbl_vorlagestudiengang" add Constraint "studiengang_vorlagestudiengang" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "testtool"."tbl_ablauf" add Constraint "studiengang_ablauf" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "testtool"."tbl_pruefling" add Constraint "studiengang_pruefling" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitaufzeichnung" add Constraint "studiengang_zeitaufzeichnung" foreign key ("studiengang_kz") references "public"."tbl_studiengang" ("studiengang_kz") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplan" add Constraint "stunde_stundenplan" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitwunsch" add Constraint "stunde_zeitwunsch" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete cascade;
Alter table "campus"."tbl_zeitsperre" add Constraint "stunde_zeitsperre_bis" foreign key ("bisstunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitsperre" add Constraint "stunde_zeitsperre_von" foreign key ("vonstunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete cascade;
Alter table "campus"."tbl_reservierung" add Constraint "stunde_reservierung" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete cascade;
Alter table "lehre"."tbl_stundenplandev" add Constraint "stunde_stundenplandev" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete restrict;
Alter table "campus"."tbl_bmreservierung" add Constraint "stunde_lmreservierung" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeitfenster" add Constraint "stunde_zeitfenster" foreign key ("stunde") references "lehre"."tbl_stunde" ("stunde") on update restrict on delete restrict;
Alter table "lehre"."tbl_lehrfach" add Constraint "fachbereich_lehrfach" foreign key ("fachbereich_kurzbz") references "public"."tbl_fachbereich" ("fachbereich_kurzbz") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerfunktion" add Constraint "fachbereich_personfunktion" foreign key ("fachbereich_kurzbz") references "public"."tbl_fachbereich" ("fachbereich_kurzbz") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerberechtigung" add Constraint "fachbereich_userberechtigung" foreign key ("fachbereich_kurzbz") references "public"."tbl_fachbereich" ("fachbereich_kurzbz") on update cascade on delete cascade;
Alter table "campus"."tbl_news" add Constraint "fachbereich_news" foreign key ("fachbereich_kurzbz") references "public"."tbl_fachbereich" ("fachbereich_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitaufzeichnung" add Constraint "fachbereich_zeitaufzeichnung" foreign key ("fachbereich_kurzbz") references "public"."tbl_fachbereich" ("fachbereich_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_standort" add Constraint "adresse_standort" foreign key ("adresse_id") references "public"."tbl_adresse" ("adresse_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "raumtyp_lehrveranstaltung" foreign key ("raumtyp") references "public"."tbl_raumtyp" ("raumtyp_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "raumtypalternativ_lehrveranstaltung" foreign key ("raumtypalternativ") references "public"."tbl_raumtyp" ("raumtyp_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_ortraumtyp" add Constraint "raumtype_ortraumtyp" foreign key ("raumtyp_kurzbz") references "public"."tbl_raumtyp" ("raumtyp_kurzbz") on update cascade on delete cascade;
Alter table "lehre"."tbl_lehreinheit" add Constraint "lehrform_lehreinheit" foreign key ("lehrform_kurzbz") references "lehre"."tbl_lehrform" ("lehrform_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_benutzerberechtigung" add Constraint "berechtigung_benutzerberechtigung" foreign key ("berechtigung_kurzbz") references "public"."tbl_berechtigung" ("berechtigung_kurzbz") on update cascade on delete cascade;
Alter table "public"."tbl_benutzerberechtigung" add Constraint "aubildungssemester_userberechtigung" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete cascade;
Alter table "campus"."tbl_benutzerlvstudiensemester" add Constraint "studiensemester_benutzerlvstudiensemester" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "studiensemester_lehreinheit" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_prestudentstatus" add Constraint "studiensemester_prestudentrolle" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_konto" add Constraint "studiensemester_konto" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeugnisnote" add Constraint "studiensemester_zeugnisnote" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "studiensemester_lvgesamtnote" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_studentlehrverband" add Constraint "studiensemester_studentlehrverband" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_benutzergruppe" add Constraint "studiensemester_benutzergruppe" foreign key ("studiensemester_kurzbz") references "public"."tbl_studiensemester" ("studiensemester_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_bmreservierung" add Constraint "lehrmittel_lmreservierung" foreign key ("betriebsmittel_id","person_id") references "public"."tbl_betriebsmittelperson" ("betriebsmittel_id","person_id") on update cascade on delete cascade;
Alter table "lehre"."tbl_lehrfach" add Constraint "sprache_lehrfach" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "campus"."tbl_lvinfo" add Constraint "sprache_lvinfo" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "public"."tbl_person" add Constraint "sprache_person" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehrveranstaltung" add Constraint "sprache_lehrveranstaltung" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "sprache_lehreinheit" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "campus"."tbl_newssprache" add Constraint "sprache_newssprache" foreign key ("sprache") references "public"."tbl_sprache" ("sprache") on update cascade on delete restrict;
Alter table "campus"."tbl_newssprache" add Constraint "news_newssprache" foreign key ("news_id") references "campus"."tbl_news" ("news_id") on update cascade on delete restrict;
Alter table "public"."tbl_adresse" add Constraint "person_adresse" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_benutzer" add Constraint "person_person" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_konto" add Constraint "person_konto" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "person_prestudent" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_kontakt" add Constraint "person_kontakt" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete cascade;
Alter table "lehre"."tbl_projektbetreuer" add Constraint "person_projektbetreuer" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_bankverbindung" add Constraint "person_bankverbindung" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_betriebsmittelperson" add Constraint "person_betriebsmittelperson" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_akte" add Constraint "person_akte" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "person1_abschlusspruefung" foreign key ("pruefer1") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "person2_abschlusspruefung" foreign key ("pruefer2") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "person3_abschlusspruefung" foreign key ("pruefer3") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_personfunktionfirma" add Constraint "person_personfunktionfirma" foreign key ("person_id") references "public"."tbl_person" ("person_id") on update cascade on delete restrict;
Alter table "public"."tbl_studiengang" add Constraint "erhalter_studiengang" foreign key ("erhalter_kz") references "public"."tbl_erhalter" ("erhalter_kz") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplan" add Constraint "lehrverband_stundenplan" foreign key ("studiengang_kz","semester","verband","gruppe") references "public"."tbl_lehrverband" ("studiengang_kz","semester","verband","gruppe") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheitgruppe" add Constraint "lehrverband_gruppelehreinheit" foreign key ("studiengang_kz","semester","verband","gruppe") references "public"."tbl_lehrverband" ("studiengang_kz","semester","verband","gruppe") on update cascade on delete restrict;
Alter table "lehre"."tbl_stundenplandev" add Constraint "lehrverband_stundenplandev" foreign key ("studiengang_kz","semester","verband","gruppe") references "public"."tbl_lehrverband" ("studiengang_kz","semester","verband","gruppe") on update cascade on delete restrict;
Alter table "public"."tbl_student" add Constraint "lehrverband_student" foreign key ("studiengang_kz","semester","verband","gruppe") references "public"."tbl_lehrverband" ("studiengang_kz","semester","verband","gruppe") on update cascade on delete restrict;
Alter table "public"."tbl_studentlehrverband" add Constraint "lehrverband_studentlehrverband" foreign key ("studiengang_kz","semester","verband","gruppe") references "public"."tbl_lehrverband" ("studiengang_kz","semester","verband","gruppe") on update cascade on delete restrict;
Alter table "public"."tbl_konto" add Constraint "konto_konto" foreign key ("buchungsnr_verweis") references "public"."tbl_konto" ("buchungsnr") on update cascade on delete restrict;
Alter table "campus"."tbl_studentuebung" add Constraint "uebung_studentuebung" foreign key ("uebung_id") references "campus"."tbl_uebung" ("uebung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_beispiel" add Constraint "uebung_beispiel" foreign key ("uebung_id") references "campus"."tbl_uebung" ("uebung_id") on update cascade on delete cascade;
Alter table "campus"."tbl_notenschluesseluebung" add Constraint "uebung_notenschluesseluebung" foreign key ("uebung_id") references "campus"."tbl_uebung" ("uebung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_uebung" add Constraint "uebung_uebung" foreign key ("liste_id") references "campus"."tbl_uebung" ("uebung_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheit" add Constraint "lehrveranstaltung_lehreinheit" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "lehrveranstaltung_lvgesamtnote" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeugnisnote" add Constraint "lehrveranstaltung_zeugnisnote" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_feedback" add Constraint "lehrveranstaltung_feedback" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_benutzerlvstudiensemester" add Constraint "lehrveranstaltung_benutzerlvstudiensemester" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_lvinfo" add Constraint "lehrveranstaltung_lvinfo" foreign key ("lehrveranstaltung_id") references "lehre"."tbl_lehrveranstaltung" ("lehrveranstaltung_id") on update cascade on delete restrict;
Alter table "campus"."tbl_studentbeispiel" add Constraint "beispiel_studentbeispiel" foreign key ("beispiel_id") references "campus"."tbl_beispiel" ("beispiel_id") on update cascade on delete restrict;
Alter table "public"."tbl_prestudentstatus" add Constraint "rolle_prestudentrolle" foreign key ("status_kurzbz") references "public"."tbl_status" ("status_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_student" add Constraint "prestudent_student" foreign key ("prestudent_id") references "public"."tbl_prestudent" ("prestudent_id") on update cascade on delete restrict;
Alter table "public"."tbl_prestudentstatus" add Constraint "prestudent_prestudentrolle" foreign key ("prestudent_id") references "public"."tbl_prestudent" ("prestudent_id") on update cascade on delete restrict;
Alter table "public"."tbl_dokumentprestudent" add Constraint "prestudent_dokumentprestudent" foreign key ("prestudent_id") references "public"."tbl_prestudent" ("prestudent_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_pruefling" add Constraint "prestudent_pruefling" foreign key ("prestudent_id") references "public"."tbl_prestudent" ("prestudent_id") on update cascade on delete restrict;
Alter table "bis"."tbl_bisfunktion" add Constraint "bisverwendung_bisfunktion" foreign key ("bisverwendung_id") references "bis"."tbl_bisverwendung" ("bisverwendung_id") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "hauptberuf_bisverwendung" foreign key ("hauptberufcode") references "bis"."tbl_hauptberuf" ("hauptberufcode") on update cascade on delete restrict;
Alter table "bis"."tbl_entwicklungsteam" add Constraint "besqual_entwicklungsteam" foreign key ("besqualcode") references "bis"."tbl_besqual" ("besqualcode") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "beschaeftigungsart1_bisverwendung" foreign key ("ba1code") references "bis"."tbl_beschaeftigungsart1" ("ba1code") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "beschaeftigungsart2_bisverwendung" foreign key ("ba2code") references "bis"."tbl_beschaeftigungsart2" ("ba2code") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "beschaeftigungsausmass_bisverwendung" foreign key ("beschausmasscode") references "bis"."tbl_beschaeftigungsausmass" ("beschausmasscode") on update cascade on delete restrict;
Alter table "bis"."tbl_bisverwendung" add Constraint "verwendungscode_bisverwendung" foreign key ("verwendung_code") references "bis"."tbl_verwendung" ("verwendung_code") on update cascade on delete restrict;
Alter table "public"."tbl_mitarbeiter" add Constraint "ausbildung_mitarbeiter" foreign key ("ausbildungcode") references "bis"."tbl_ausbildung" ("ausbildungcode") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "aubildung_prestudent" foreign key ("ausbildungcode") references "bis"."tbl_ausbildung" ("ausbildungcode") on update cascade on delete restrict;
Alter table "public"."tbl_kontakt" add Constraint "kontakttyp_kontakt" foreign key ("kontakttyp") references "public"."tbl_kontakttyp" ("kontakttyp") on update cascade on delete restrict;
Alter table "public"."tbl_kontakt" add Constraint "firma_kontakt" foreign key ("firma_id") references "public"."tbl_firma" ("firma_id") on update cascade on delete restrict;
Alter table "public"."tbl_adresse" add Constraint "firma_adresse" foreign key ("firma_id") references "public"."tbl_firma" ("firma_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektarbeit" add Constraint "firma_projektarbeit" foreign key ("firma_id") references "public"."tbl_firma" ("firma_id") on update cascade on delete restrict;
Alter table "public"."tbl_personfunktionfirma" add Constraint "firma_personfunktionfirma" foreign key ("firma_id") references "public"."tbl_firma" ("firma_id") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "zgv_prestudent" foreign key ("zgv_code") references "bis"."tbl_zgv" ("zgv_code") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "berufstaetigkeit_prestudent" foreign key ("berufstaetigkeit_code") references "bis"."tbl_berufstaetigkeit" ("berufstaetigkeit_code") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "zgvmaster_prestudent" foreign key ("zgvmas_code") references "bis"."tbl_zgvmaster" ("zgvmas_code") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "aufmerksamdurch_prestudent" foreign key ("aufmerksamdurch_kurzbz") references "public"."tbl_aufmerksamdurch" ("aufmerksamdurch_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "aufnahmeschluessel_prestudent" foreign key ("aufnahmeschluessel") references "public"."tbl_aufnahmeschluessel" ("aufnahmeschluessel") on update cascade on delete restrict;
Alter table "public"."tbl_prestudent" add Constraint "reihungstest_prestudent" foreign key ("reihungstest_id") references "public"."tbl_reihungstest" ("reihungstest_id") on update cascade on delete restrict;
Alter table "public"."tbl_betriebsmittelperson" add Constraint "betriebsmittel_betriebsmittelperson" foreign key ("betriebsmittel_id") references "public"."tbl_betriebsmittel" ("betriebsmittel_id") on update cascade on delete restrict;
Alter table "campus"."tbl_studentuebung" add Constraint "abgabe_studentuebung" foreign key ("abgabe_id") references "campus"."tbl_abgabe" ("abgabe_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektbetreuer" add Constraint "projektarbeit_projektbetreuer" foreign key ("projektarbeit_id") references "lehre"."tbl_projektarbeit" ("projektarbeit_id") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektarbeit" add Constraint "projektarbeit_note" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "lehre"."tbl_zeugnisnote" add Constraint "note_zeugnisnote" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektbetreuer" add Constraint "note_projektbetreuer" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "campus"."tbl_lvgesamtnote" add Constraint "note_lvgesamtnote" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "campus"."tbl_studentuebung" add Constraint "note_studentuebung" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "campus"."tbl_legesamtnote" add Constraint "note_legesamtnote" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "campus"."tbl_notenschluessel" add Constraint "note_notenschluessel" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "lehre"."tbl_pruefung" add Constraint "note_pruefung" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "campus"."tbl_notenschluesseluebung" add Constraint "note_notenschluesseluebung" foreign key ("note") references "lehre"."tbl_note" ("note") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektarbeit" add Constraint "projekttyp_projektarbeit" foreign key ("projekttyp_kurzbz") references "lehre"."tbl_projekttyp" ("projekttyp_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_betriebsmittel" add Constraint "betriebsmitteltyp_betriebsmittel" foreign key ("betriebsmitteltyp") references "public"."tbl_betriebsmitteltyp" ("betriebsmitteltyp") on update cascade on delete restrict;
Alter table "public"."tbl_person" add Constraint "nation_person" foreign key ("geburtsnation") references "bis"."tbl_nation" ("nation_code") on update cascade on delete restrict;
Alter table "public"."tbl_adresse" add Constraint "nation_adresse" foreign key ("nation") references "bis"."tbl_nation" ("nation_code") on update cascade on delete restrict;
Alter table "public"."tbl_person" add Constraint "nationgeburt_person" foreign key ("staatsbuergerschaft") references "bis"."tbl_nation" ("nation_code") on update cascade on delete restrict;
Alter table "bis"."tbl_bisio" add Constraint "nation_bisio" foreign key ("nation_code") references "bis"."tbl_nation" ("nation_code") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "abschlussbeurteilung_abschlusspruefung" foreign key ("abschlussbeurteilung_kurzbz") references "lehre"."tbl_abschlussbeurteilung" ("abschlussbeurteilung_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "akadgrad_abschlusspruefung" foreign key ("akadgrad_id") references "lehre"."tbl_akadgrad" ("akadgrad_id") on update cascade on delete restrict;
Alter table "public"."tbl_dokumentstudiengang" add Constraint "dokument_dokumentstudiengang" foreign key ("dokument_kurzbz") references "public"."tbl_dokument" ("dokument_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_dokumentprestudent" add Constraint "dokument_dokumentprestudent" foreign key ("dokument_kurzbz") references "public"."tbl_dokument" ("dokument_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_akte" add Constraint "dokument_akte" foreign key ("dokument_kurzbz") references "public"."tbl_dokument" ("dokument_kurzbz") on update cascade on delete restrict;
Alter table "bis"."tbl_bisio" add Constraint "mobilitaetsprogramm_bisio" foreign key ("mobilitaetsprogramm_code") references "bis"."tbl_mobilitaetsprogramm" ("mobilitaetsprogramm_code") on update cascade on delete restrict;
Alter table "bis"."tbl_bisio" add Constraint "zweck_bisio" foreign key ("zweck_code") references "bis"."tbl_zweck" ("zweck_code") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitsperre" add Constraint "zeitsperretyp_zeitsperre" foreign key ("zeitsperretyp_kurzbz") references "campus"."tbl_zeitsperretyp" ("zeitsperretyp_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_firma" add Constraint "firmentyp_firma" foreign key ("firmentyp_kurzbz") references "public"."tbl_firmentyp" ("firmentyp_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_lehreinheitmitarbeiter" add Constraint "lehrfunktion_lehreinheitmitarbeiter" foreign key ("lehrfunktion_kurzbz") references "lehre"."tbl_lehrfunktion" ("lehrfunktion_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_pruefung" add Constraint "pruefungstyp_pruefung" foreign key ("pruefungstyp_kurzbz") references "lehre"."tbl_pruefungstyp" ("pruefungstyp_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_abschlusspruefung" add Constraint "pruefungstyp_abschlusspruefung" foreign key ("pruefungstyp_kurzbz") references "lehre"."tbl_pruefungstyp" ("pruefungstyp_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_mitarbeiter" add Constraint "standort_mitarbeiter" foreign key ("standort_kurzbz") references "public"."tbl_standort" ("standort_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitsperre" add Constraint "erreichbarkeit_zeitsperre" foreign key ("erreichbarkeit_kurzbz") references "campus"."tbl_erreichbarkeit" ("erreichbarkeit_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_vorlagestudiengang" add Constraint "vorlage_vorlagestudiengang" foreign key ("vorlage_kurzbz") references "public"."tbl_vorlage" ("vorlage_kurzbz") on update cascade on delete restrict;
Alter table "lehre"."tbl_projektbetreuer" add Constraint "betreuerart_projektbetreuer" foreign key ("betreuerart_kurzbz") references "lehre"."tbl_betreuerart" ("betreuerart_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_konto" add Constraint "buchungstyp_konto" foreign key ("buchungstyp_kurzbz") references "public"."tbl_buchungstyp" ("buchungstyp_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_studiengang" add Constraint "orgform_studiengang" foreign key ("orgform_kurzbz") references "bis"."tbl_orgform" ("orgform_kurzbz") on update cascade on delete restrict;
Alter table "public"."tbl_prestudentstatus" add Constraint "orgform_prestudentrolle" foreign key ("orgform_kurzbz") references "bis"."tbl_orgform" ("orgform_kurzbz") on update cascade on delete restrict;
Alter table "testtool"."tbl_antwort" add Constraint "frage_antwort" foreign key ("frage_id") references "testtool"."tbl_frage" ("frage_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_vorschlag" add Constraint "frage_vorschlag" foreign key ("frage_id") references "testtool"."tbl_frage" ("frage_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_kriterien" add Constraint "gebiet_kriterien" foreign key ("gebiet_id") references "testtool"."tbl_gebiet" ("gebiet_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_ablauf" add Constraint "gebiet_ablauf" foreign key ("gebiet_id") references "testtool"."tbl_gebiet" ("gebiet_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_kategorie" add Constraint "gebiet_kategorie" foreign key ("gebiet_id") references "testtool"."tbl_gebiet" ("gebiet_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_frage" add Constraint "gebiet_frage" foreign key ("gebiet_id") references "testtool"."tbl_gebiet" ("gebiet_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_kriterien" add Constraint "kategorie_kriterien" foreign key ("kategorie_kurzbz") references "testtool"."tbl_kategorie" ("kategorie_kurzbz") on update cascade on delete restrict;
Alter table "testtool"."tbl_frage" add Constraint "kategorie_frage" foreign key ("kategorie_kurzbz") references "testtool"."tbl_kategorie" ("kategorie_kurzbz") on update cascade on delete restrict;
Alter table "testtool"."tbl_antwort" add Constraint "pruefling_antwort" foreign key ("pruefling_id") references "testtool"."tbl_pruefling" ("pruefling_id") on update cascade on delete restrict;
Alter table "testtool"."tbl_frage" add Constraint "gruppe_frage" foreign key ("gruppe_kurzbz") references "testtool"."tbl_gruppe" ("gruppe_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitaufzeichnung" add Constraint "projekt_zeitaufzeichnung" foreign key ("projekt_kurzbz") references "fue"."tbl_projekt" ("projekt_kurzbz") on update cascade on delete restrict;
Alter table "fue"."tbl_projektbenutzer" add Constraint "projekt_projektbenutzer" foreign key ("projekt_kurzbz") references "fue"."tbl_projekt" ("projekt_kurzbz") on update cascade on delete restrict;
Alter table "campus"."tbl_zeitaufzeichnung" add Constraint "aktivitaet_zeitaufzeichnung" foreign key ("aktivitaet_kurzbz") references "fue"."tbl_aktivitaet" ("aktivitaet_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_teambenutzer" add Constraint "team_teambenutzer" foreign key ("team_kurzbz") references "kommune"."tbl_team" ("team_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_wettbewerbteam" add Constraint "team_wettbewerbteam" foreign key ("team_kurzbz") references "kommune"."tbl_team" ("team_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "team_match-forderer" foreign key ("team_forderer") references "kommune"."tbl_team" ("team_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "team_match-gefordert" foreign key ("team_gefordert") references "kommune"."tbl_team" ("team_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "team_match-sieger" foreign key ("team_sieger") references "kommune"."tbl_team" ("team_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_wettbewerbteam" add Constraint "wettbewerb_wettbewerbteam" foreign key ("wettbewerb_kurzbz") references "kommune"."tbl_wettbewerb" ("wettbewerb_kurzbz") on update cascade on delete restrict;
Alter table "kommune"."tbl_match" add Constraint "wettbewerb_match" foreign key ("wettbewerb_kurzbz") references "kommune"."tbl_wettbewerb" ("wettbewerb_kurzbz") on update cascade on delete restrict;






CREATE  OR REPLACE VIEW campus.vw_benutzer AS 
 	SELECT person_id, uid, alias, geburtsnation, sprache, anrede, titelpost, titelpre, nachname, vorname, vornamen, gebdatum, 
 		gebort, gebzeit, foto, geschlecht, anmerkung, homepage, svnr, ersatzkennzeichen, familienstand, anzahlkinder, tbl_benutzer.aktiv, 
 		tbl_benutzer.insertamum, tbl_benutzer.insertvon, tbl_benutzer.updateamum, tbl_benutzer.updatevon, tbl_benutzer.ext_id 
 	FROM (public.tbl_benutzer  JOIN public.tbl_person USING (person_id));

CREATE  OR REPLACE VIEW campus.vw_lehreinheit AS 
SELECT tbl_lehrveranstaltung.studiengang_kz AS lv_studiengang_kz, tbl_lehrveranstaltung.kurzbz AS lv_kurzbz, tbl_lehrveranstaltung.bezeichnung AS lv_bezeichnung,
 tbl_lehrveranstaltung.ects AS lv_ects, tbl_lehrveranstaltung.lehreverzeichnis AS lv_lehreverzeichnis, tbl_lehrveranstaltung.planfaktor AS lv_planfaktor,
 tbl_lehrveranstaltung.planlektoren AS lv_planlektoren, tbl_lehrveranstaltung.planpersonalkosten AS lv_planpersonalkosten,
 tbl_lehrveranstaltung.plankostenprolektor AS lv_plankostenprolektor, lehreinheit_id, lehrveranstaltung_id, studiensemester_kurzbz, lehrform_kurzbz,
 stundenblockung, wochenrythmus, start_kw, raumtyp, raumtypalternativ, tbl_lehreinheit.lehre, unr, lvnr, lehrfunktion_kurzbz, tbl_lehreinheit.insertamum,
 tbl_lehreinheit.insertvon, tbl_lehreinheit.updateamum, tbl_lehreinheit.updatevon, lehrfach_id, fachbereich_kurzbz, tbl_lehrfach.kurzbz AS lehrfach, 
 tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe, tbl_lehrveranstaltung.aktiv, tbl_lehrfach.sprache, mitarbeiter_uid, 
 tbl_lehreinheitmitarbeiter.semesterstunden AS semesterstunden, tbl_lehrveranstaltung.semesterstunden AS lv_semesterstunden, planstunden, tbl_lehreinheitmitarbeiter.stundensatz, 
 faktor, tbl_lehreinheit.anmerkung, tbl_mitarbeiter.kurzbz AS lektor, tbl_lehreinheitgruppe.studiengang_kz, tbl_lehreinheitgruppe.semester, verband, gruppe, 
 gruppe_kurzbz, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.kurzbzlang AS stg_kurzbzlang, tbl_studiengang.bezeichnung AS stg_bez, 
 tbl_studiengang.typ AS stg_typ, tbl_lehreinheitmitarbeiter.anmerkung AS anmerkunglektor 
FROM ((((((lehre.tbl_lehreinheit JOIN lehre.tbl_lehrveranstaltung USING (lehrveranstaltung_id)) JOIN lehre.tbl_lehrfach USING (lehrfach_id)) 
	JOIN lehre.tbl_lehreinheitmitarbeiter USING (lehreinheit_id)) JOIN tbl_mitarbeiter USING (mitarbeiter_uid)) JOIN lehre.tbl_lehreinheitgruppe USING (lehreinheit_id)) 
	JOIN tbl_studiengang ON ((tbl_lehreinheitgruppe.studiengang_kz = tbl_studiengang.studiengang_kz)));
	

CREATE  OR REPLACE VIEW campus.vw_mitarbeiter AS 
SELECT uid, ausbildungcode, personalnummer, kurzbz, lektor, fixangestellt, telefonklappe, person_id, alias, geburtsnation, sprache, 
	anrede, titelpost, titelpre, nachname, vorname, vornamen, gebdatum, gebort, gebzeit, foto, tbl_mitarbeiter.anmerkung, homepage, svnr, ersatzkennzeichen, 
	 geschlecht, familienstand, anzahlkinder, ort_kurzbz, tbl_benutzer.aktiv, standort_kurzbz, tbl_mitarbeiter.updateamum, tbl_mitarbeiter.updatevon, tbl_mitarbeiter.insertamum, tbl_mitarbeiter.insertvon, tbl_mitarbeiter.ext_id 
FROM ((public.tbl_mitarbeiter JOIN public.tbl_benutzer ON ((tbl_mitarbeiter.mitarbeiter_uid = tbl_benutzer.uid))) JOIN public.tbl_person USING (person_id));

CREATE  OR REPLACE VIEW campus.vw_reservierung AS 
SELECT campus.tbl_reservierung.*, public.tbl_studiengang.kurzbz AS stg_kurzbz 
FROM campus.tbl_reservierung JOIN public.tbl_studiengang USING (studiengang_kz); 

CREATE  OR REPLACE VIEW campus.vw_stundenplan AS 
SELECT stundenplan_id, tbl_stundenplan.unr, tbl_stundenplan.mitarbeiter_uid AS uid, lehreinheit_id, lehrfach_id, datum, stunde, tbl_stundenplan.ort_kurzbz,
	tbl_stundenplan.studiengang_kz, tbl_stundenplan.semester, verband, gruppe, gruppe_kurzbz, titel, tbl_stundenplan.anmerkung, fix, 
	 lehrveranstaltung_id, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.kurzbzlang AS stg_kurzbzlang, 
	 tbl_studiengang.bezeichnung AS stg_bezeichnung, tbl_studiengang.typ AS stg_typ,fachbereich_kurzbz, tbl_lehrfach.kurzbz AS lehrfach,
	 tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe, tbl_lehreinheit.lehrform_kurzbz AS lehrform, tbl_mitarbeiter.kurzbz AS lektor,
	 tbl_stundenplan.updateamum, tbl_stundenplan.updatevon,tbl_stundenplan.insertamum, tbl_stundenplan.insertvon
FROM ((((lehre.tbl_stundenplan JOIN tbl_studiengang USING (studiengang_kz)) JOIN lehre.tbl_lehreinheit USING (lehreinheit_id)) 
	JOIN lehre.tbl_lehrfach USING (lehrfach_id)) JOIN public.tbl_mitarbeiter USING (mitarbeiter_uid));

CREATE  OR REPLACE VIEW campus.vw_persongruppe AS 
 	SELECT uid,gruppe_kurzbz,studiengang_kz,nachname,vorname,vornamen,person_id,gebdatum,titelpost,titelpre,
	staatsbuergerschaft,geburtsnation,sprache,anrede,gebort,gebzeit,foto,homepage,svnr,ersatzkennzeichen,
	familienstand,geschlecht,anzahlkinder,alias,anmerkung,tbl_person.aktiv AS aktivperson,mailgrp,sichtbar,
	tbl_benutzer.aktiv AS aktivbenutzer,semester,bezeichnung,beschreibung,generiert,tbl_gruppe.aktiv AS aktivgruppe,sort,
	tbl_benutzergruppe.updateamum,tbl_benutzergruppe.updatevon,tbl_benutzergruppe.insertamum,tbl_benutzergruppe.insertvon
FROM ((public.tbl_person JOIN public.tbl_benutzer USING (person_id)) 
	JOIN public.tbl_benutzergruppe USING (uid)) 
	JOIN public.tbl_gruppe USING (gruppe_kurzbz) ;

CREATE  OR REPLACE VIEW campus.vw_student AS 
	SELECT uid, matrikelnr, prestudent_id, studiengang_kz, semester, verband, gruppe, person_id, alias, geburtsnation, sprache, 
		anrede, titelpost, titelpre, nachname, vorname, vornamen, gebdatum, gebort, gebzeit, foto, anmerkung, homepage, svnr, ersatzkennzeichen, 
		 geschlecht, familienstand, anzahlkinder, tbl_benutzer.aktiv,  tbl_student.updateamum,  tbl_student.updatevon,  
		 tbl_student.insertamum,  tbl_student.insertvon,  tbl_student.ext_id
	FROM ((public.tbl_student  JOIN public.tbl_benutzer ON student_uid=uid)  JOIN public.tbl_person  USING (person_id));

CREATE OR REPLACE VIEW campus.vw_student_lehrveranstaltung AS
SELECT tbl_benutzergruppe.uid, tbl_lehrveranstaltung.zeugnis, tbl_lehrveranstaltung.sort,
	tbl_lehrveranstaltung.lehrveranstaltung_id, tbl_lehrveranstaltung.kurzbz, tbl_lehrveranstaltung.bezeichnung, 
	tbl_lehrveranstaltung.studiengang_kz, tbl_lehrveranstaltung.semester, tbl_lehrveranstaltung.sprache, 
	tbl_lehrveranstaltung.ects, tbl_lehrveranstaltung.semesterstunden, tbl_lehrveranstaltung.anmerkung, 
	tbl_lehrveranstaltung.lehre, tbl_lehrveranstaltung.lehreverzeichnis, tbl_lehrveranstaltung.aktiv, 
	tbl_lehrveranstaltung.planfaktor, tbl_lehrveranstaltung.planlektoren, tbl_lehrveranstaltung.planpersonalkosten, 
	tbl_lehrveranstaltung.plankostenprolektor, tbl_lehrveranstaltung.updateamum, tbl_lehrveranstaltung.updatevon, 
	tbl_lehrveranstaltung.insertamum, tbl_lehrveranstaltung.insertvon, tbl_lehrveranstaltung.ext_id,
	tbl_lehreinheit.lehreinheit_id, tbl_lehreinheit.studiensemester_kurzbz, tbl_lehreinheit.lehrfach_id, 
	tbl_lehreinheit.lehrform_kurzbz, tbl_lehreinheit.stundenblockung, tbl_lehreinheit.wochenrythmus, 
	tbl_lehreinheit.start_kw, tbl_lehreinheit.raumtyp, tbl_lehreinheit.raumtypalternativ, tbl_lehrveranstaltung.lehrform_kurzbz AS lv_lehrform_kurzbz
FROM lehre.tbl_lehreinheitgruppe, public.tbl_benutzergruppe,lehre.tbl_lehreinheit, lehre.tbl_lehrveranstaltung
WHERE tbl_lehreinheitgruppe.gruppe_kurzbz=tbl_benutzergruppe.gruppe_kurzbz
	AND tbl_lehrveranstaltung.lehrveranstaltung_id=tbl_lehreinheit.lehrveranstaltung_id
	AND tbl_lehreinheit.lehreinheit_id=tbl_lehreinheitgruppe.lehreinheit_id 
	AND tbl_lehreinheit.studiensemester_kurzbz = tbl_benutzergruppe.studiensemester_kurzbz
UNION
SELECT tbl_studentlehrverband.student_uid AS uid, tbl_lehrveranstaltung.zeugnis, tbl_lehrveranstaltung.sort, 
	tbl_lehrveranstaltung.lehrveranstaltung_id, tbl_lehrveranstaltung.kurzbz,tbl_lehrveranstaltung.bezeichnung, 
	tbl_lehrveranstaltung.studiengang_kz, tbl_lehrveranstaltung.semester, tbl_lehrveranstaltung.sprache,
	tbl_lehrveranstaltung.ects, tbl_lehrveranstaltung.semesterstunden, tbl_lehrveranstaltung.anmerkung,
	tbl_lehrveranstaltung.lehre, tbl_lehrveranstaltung.lehreverzeichnis, tbl_lehrveranstaltung.aktiv,
	tbl_lehrveranstaltung.planfaktor, tbl_lehrveranstaltung.planlektoren, tbl_lehrveranstaltung.planpersonalkosten,
	tbl_lehrveranstaltung.plankostenprolektor, tbl_lehrveranstaltung.updateamum, tbl_lehrveranstaltung.updatevon,
	tbl_lehrveranstaltung.insertamum, tbl_lehrveranstaltung.insertvon, tbl_lehrveranstaltung.ext_id,
	tbl_lehreinheit.lehreinheit_id, tbl_lehreinheit.studiensemester_kurzbz, tbl_lehreinheit.lehrfach_id,
	tbl_lehreinheit.lehrform_kurzbz, tbl_lehreinheit.stundenblockung, tbl_lehreinheit.wochenrythmus, tbl_lehreinheit.start_kw,
	tbl_lehreinheit.raumtyp, tbl_lehreinheit.raumtypalternativ, tbl_lehrveranstaltung.lehrform_kurzbz AS lv_lehrform_kurzbz
FROM lehre.tbl_lehreinheitgruppe, tbl_studentlehrverband,  lehre.tbl_lehreinheit, lehre.tbl_lehrveranstaltung
WHERE tbl_lehreinheit.lehreinheit_id=tbl_lehreinheitgruppe.lehreinheit_id 
	AND tbl_lehreinheit.studiensemester_kurzbz=tbl_studentlehrverband.studiensemester_kurzbz
	AND tbl_lehrveranstaltung.lehrveranstaltung_id=tbl_lehreinheit.lehrveranstaltung_id
	AND
	(
		(
			(
				(tbl_studentlehrverband.studiengang_kz =tbl_lehreinheitgruppe.studiengang_kz)
				AND
                (tbl_studentlehrverband.semester =tbl_lehreinheitgruppe.semester)
			)
             AND
            (
            	( btrim((tbl_studentlehrverband.verband)::text) = btrim((tbl_lehreinheitgruppe.verband)::text)
			)
			OR
     		(
            	(
                	(tbl_lehreinheitgruppe.verband IS NULL)
					OR
                    (btrim((tbl_studentlehrverband.verband)::text) = ''::text)
				)
	            AND
    			(tbl_lehreinheitgruppe.gruppe_kurzbz IS NULL)
			)
		)
	)
    AND
    (
    	(btrim((tbl_studentlehrverband.gruppe)::text) = btrim((tbl_lehreinheitgruppe.gruppe)::text))
		OR
       	(
        	(
            	(tbl_lehreinheitgruppe.gruppe IS NULL)
                OR
				(btrim((tbl_studentlehrverband.gruppe)::text) = ''::text)
	        )
            AND (tbl_lehreinheitgruppe.gruppe_kurzbz IS NULL)
		)
   	)
)
;

CREATE  OR REPLACE VIEW lehre.vw_stundenplan AS 
SELECT stundenplan_id, tbl_stundenplan.unr, tbl_stundenplan.mitarbeiter_uid AS uid, lehreinheit_id, lehrfach_id, datum, stunde, tbl_stundenplan.ort_kurzbz,
	tbl_stundenplan.studiengang_kz, tbl_stundenplan.semester, verband, gruppe, gruppe_kurzbz, titel, tbl_stundenplan.anmerkung, fix, 
	 lehrveranstaltung_id, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.kurzbzlang AS stg_kurzbzlang, 
	 tbl_studiengang.bezeichnung AS stg_bezeichnung, tbl_studiengang.typ AS stg_typ,fachbereich_kurzbz, tbl_lehrfach.kurzbz AS lehrfach,
	 tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe, tbl_lehreinheit.lehrform_kurzbz AS lehrform, tbl_mitarbeiter.kurzbz AS lektor,
	 tbl_stundenplan.updateamum, tbl_stundenplan.updatevon,tbl_stundenplan.insertamum, tbl_stundenplan.insertvon
FROM ((((lehre.tbl_stundenplan JOIN tbl_studiengang USING (studiengang_kz)) JOIN lehre.tbl_lehreinheit USING (lehreinheit_id)) 
	JOIN lehre.tbl_lehrfach USING (lehrfach_id)) JOIN public.tbl_mitarbeiter USING (mitarbeiter_uid));

CREATE  OR REPLACE VIEW lehre.vw_stundenplandev AS
SELECT stundenplandev_id, tbl_stundenplandev.unr, tbl_stundenplandev.mitarbeiter_uid AS uid, lehreinheit_id, lehrfach_id, datum, stunde, 
	tbl_stundenplandev.ort_kurzbz, tbl_stundenplandev.studiengang_kz, tbl_stundenplandev.semester, verband, gruppe, gruppe_kurzbz, titel, 
	tbl_stundenplandev.anmerkung, fix, lehrveranstaltung_id, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.kurzbzlang AS stg_kurzbzlang, 
	tbl_studiengang.bezeichnung AS stg_bezeichnung, tbl_studiengang.typ AS stg_typ, fachbereich_kurzbz, tbl_lehrfach.kurzbz AS lehrfach, 
	tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe, tbl_lehreinheit.lehrform_kurzbz AS lehrform, tbl_mitarbeiter.kurzbz AS lektor,
	 tbl_stundenplandev.updateamum, tbl_stundenplandev.updatevon,tbl_stundenplandev.insertamum, tbl_stundenplandev.insertvon
FROM ((((lehre.tbl_stundenplandev JOIN tbl_studiengang USING (studiengang_kz)) JOIN lehre.tbl_lehreinheit USING (lehreinheit_id)) 
	JOIN lehre.tbl_lehrfach USING (lehrfach_id)) JOIN public.tbl_mitarbeiter USING (mitarbeiter_uid));

CREATE OR REPLACE VIEW lehre.vw_lva_stundenplan AS
SELECT lehreinheit_id, unr, lvnr,fachbereich_kurzbz,lehrfach_id, tbl_lehrfach.kurzbz AS lehrfach,
	tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe AS lehrfach_farbe, lehrform_kurzbz AS lehrform,
	lema.mitarbeiter_uid AS lektor_uid, ma.kurzbz AS lektor, tbl_studiengang.studiengang_kz,
	tbl_studiengang.kurzbz AS studiengang,lvb.semester, verband, gruppe, gruppe_kurzbz, raumtyp, raumtypalternativ,
	stundenblockung, wochenrythmus, semesterstunden, planstunden, start_kw, le.anmerkung, studiensemester_kurzbz,
	(
		SELECT count(*) AS count 
		FROM lehre.tbl_stundenplan 
		WHERE 
		(
			(
				(
					(
						(
							(
								(
									(lehre.tbl_stundenplan.mitarbeiter_uid = lema.mitarbeiter_uid) 
									AND 
									(lehre.tbl_stundenplan.studiengang_kz = lvb.studiengang_kz)
								) 
								AND (lehre.tbl_stundenplan.semester = lvb.semester)
							) 
							AND 
							(
								(lehre.tbl_stundenplan.verband = lvb.verband) 
								OR 
								(
									(
										(lehre.tbl_stundenplan.verband IS NULL) 
										OR 
										(lehre.tbl_stundenplan.verband = ''::bpchar)
									)
									AND (lvb.verband IS NULL)
								)
							)
						) 
						AND
						(
							(lehre.tbl_stundenplan.gruppe = lvb.gruppe)
							OR 
							(
								(
									(lehre.tbl_stundenplan.gruppe IS NULL) 
									OR 
									(lehre.tbl_stundenplan.gruppe = ''::bpchar)
								)
								AND (lvb.gruppe IS NULL)
							)
						)
					)
					AND
					(
						(lehre.tbl_stundenplan.gruppe_kurzbz = lvb.gruppe_kurzbz)
						OR
						(
							(lehre.tbl_stundenplan.gruppe_kurzbz IS NULL) 
							AND 
							(lvb.gruppe_kurzbz IS NULL)
						)
					)
				)
				AND 
				(
					lehre.tbl_stundenplan.datum >= 
					(
						SELECT tbl_studiensemester.start 
						FROM public.tbl_studiensemester 
						WHERE (tbl_studiensemester.studiensemester_kurzbz = le.studiensemester_kurzbz)
					)
				)
			)
			AND
			(
				lehre.tbl_stundenplan.datum < 
				(
					SELECT tbl_studiensemester.ende 
					FROM public.tbl_studiensemester 
					WHERE (tbl_studiensemester.studiensemester_kurzbz = le.studiensemester_kurzbz)
				)
			)
			AND lehre.tbl_stundenplan.lehreinheit_id = lvb.lehreinheit_id
		)
	) AS verplant 	
	
FROM 
(
	(
		(
			(lehre.tbl_lehreinheit le JOIN lehre.tbl_lehreinheitgruppe lvb USING (lehreinheit_id)) 
			JOIN lehre.tbl_lehreinheitmitarbeiter lema USING (lehreinheit_id)
		)
		JOIN public.tbl_studiengang USING (studiengang_kz)
	) 
	JOIN lehre.tbl_lehrfach USING (lehrfach_id)
) JOIN public.tbl_mitarbeiter ma USING (mitarbeiter_uid);

CREATE OR REPLACE VIEW lehre.vw_lva_stundenplandev AS
SELECT lehreinheit_id, unr, lvnr,fachbereich_kurzbz,lehrfach_id, tbl_lehrfach.kurzbz AS lehrfach,
	tbl_lehrfach.bezeichnung AS lehrfach_bez, tbl_lehrfach.farbe AS lehrfach_farbe, lehrform_kurzbz AS lehrform,
	lema.mitarbeiter_uid AS lektor_uid, tbl_mitarbeiter.kurzbz AS lektor, tbl_studiengang.studiengang_kz,
	upper(tbl_studiengang.typ::varchar || tbl_studiengang.kurzbz) AS studiengang,lvb.semester, verband, gruppe, gruppe_kurzbz, raumtyp, raumtypalternativ,
	stundenblockung, wochenrythmus, semesterstunden, planstunden, start_kw, le.anmerkung, studiensemester_kurzbz,
	(
		SELECT count(*) AS count 
		FROM lehre.tbl_stundenplandev 
		WHERE 
		(
			(
				(
					(
						(
							(
								(
									(lehre.tbl_stundenplandev.mitarbeiter_uid = lema.mitarbeiter_uid) 
									AND 
									(lehre.tbl_stundenplandev.studiengang_kz = lvb.studiengang_kz)
								) 
								AND (lehre.tbl_stundenplandev.semester = lvb.semester)
							) 
							AND 
							(
								(lehre.tbl_stundenplandev.verband = lvb.verband) 
								OR 
								(
									(
										(lehre.tbl_stundenplandev.verband IS NULL) 
										OR 
										(lehre.tbl_stundenplandev.verband = ''::bpchar)
									)
									AND (lvb.verband IS NULL)
								)
							)
						) 
						AND
						(
							(lehre.tbl_stundenplandev.gruppe = lvb.gruppe)
							OR 
							(
								(
									(lehre.tbl_stundenplandev.gruppe IS NULL) 
									OR 
									(lehre.tbl_stundenplandev.gruppe = ''::bpchar)
								)
								AND (lvb.gruppe IS NULL)
							)
						)
					)
					AND
					(
						(lehre.tbl_stundenplandev.gruppe_kurzbz = lvb.gruppe_kurzbz)
						OR
						(
							(lehre.tbl_stundenplandev.gruppe_kurzbz IS NULL) 
							AND 
							(lvb.gruppe_kurzbz IS NULL)
						)
					)
				)
				AND 
				(
					lehre.tbl_stundenplandev.datum >= 
					(
						SELECT tbl_studiensemester.start 
						FROM tbl_studiensemester 
						WHERE (tbl_studiensemester.studiensemester_kurzbz = le.studiensemester_kurzbz)
					)
				)
			)
			AND
			(
				lehre.tbl_stundenplandev.datum < 
				(
					SELECT tbl_studiensemester.ende 
					FROM tbl_studiensemester 
					WHERE (tbl_studiensemester.studiensemester_kurzbz = le.studiensemester_kurzbz)
				)
			)
			AND lehre.tbl_stundenplandev.lehreinheit_id = lvb.lehreinheit_id
		)
	) AS verplant 	
	
FROM 
(
	(
		(
			(lehre.tbl_lehreinheit le JOIN lehre.tbl_lehreinheitmitarbeiter lema USING (lehreinheit_id)) 
			JOIN lehre.tbl_lehreinheitgruppe lvb USING (lehreinheit_id)
		)
		JOIN public.tbl_studiengang ON (lvb.studiengang_kz=tbl_studiengang.studiengang_kz)
	) 
	JOIN lehre.tbl_lehrfach USING (lehrfach_id)
) JOIN public.tbl_mitarbeiter USING (mitarbeiter_uid);

CREATE  OR REPLACE VIEW lehre.vw_reservierung AS 
SELECT campus.tbl_reservierung.*, public.tbl_studiengang.kurzbz AS stg_kurzbz 
FROM campus.tbl_reservierung JOIN public.tbl_studiengang USING (studiengang_kz); 

CREATE OR REPLACE VIEW lehre.vw_fas_lehrveranstaltung AS
SELECT vw_fas_lehrveranstaltung.fas_id, vw_fas_lehrveranstaltung.studiensemester_kurzbz FROM public.dblink('hostaddr=10.63.0.27 dbname=fas user=vilesci password=vi1e5ci'::text, 'SELECT fas_id, studiensemester_kurzbz FROM fas_view_alle_lehreinheiten_vilesci'::text) vw_fas_lehrveranstaltung(fas_id bigint, studiensemester_kurzbz character varying);

CREATE OR REPLACE VIEW vw_betriebsmittelperson AS
SELECT tbl_betriebsmittelperson.betriebsmittel_id, tbl_betriebsmittelperson.person_id, tbl_betriebsmittelperson.anmerkung, tbl_betriebsmittelperson.kaution,
	 tbl_betriebsmittelperson.ausgegebenam, tbl_betriebsmittelperson.retouram, tbl_betriebsmittelperson.insertamum, tbl_betriebsmittelperson.insertvon, 
	 tbl_betriebsmittelperson.updateamum, tbl_betriebsmittelperson.updatevon, tbl_betriebsmittelperson.ext_id, tbl_betriebsmittel.beschreibung, 
	 tbl_betriebsmittel.betriebsmitteltyp, tbl_betriebsmittel.nummer, tbl_betriebsmittel.nummerintern, tbl_betriebsmittel.reservieren, tbl_betriebsmittel.ort_kurzbz, tbl_person.staatsbuergerschaft, 
	 tbl_person.geburtsnation, tbl_person.sprache, tbl_person.anrede, tbl_person.titelpost, tbl_person.titelpre, tbl_person.nachname, tbl_person.vorname, 
	 tbl_person.vornamen, tbl_person.gebdatum, tbl_person.gebort, tbl_person.gebzeit, tbl_person.foto, tbl_person.homepage, 
	 tbl_person.svnr, tbl_person.ersatzkennzeichen, tbl_person.familienstand, tbl_person.geschlecht, tbl_person.anzahlkinder, tbl_person.aktiv, tbl_benutzer.uid, 
	 tbl_benutzer.aktiv AS benutzer_aktiv, tbl_benutzer.alias 
FROM (((tbl_betriebsmittelperson JOIN tbl_betriebsmittel USING (betriebsmittel_id)) JOIN tbl_person USING (person_id)) LEFT JOIN tbl_benutzer USING (person_id));

CREATE OR REPLACE VIEW testtool.vw_pruefling AS
SELECT prestudent_id,pruefling_id, gruppe_kurzbz, tbl_pruefling.studiengang_kz, nachname, vorname, gebdatum, geschlecht, idnachweis, 
registriert, kurzbz AS stg_kurzbz, bezeichnung AS stg_bez 
FROM (((testtool.tbl_pruefling JOIN tbl_studiengang USING (studiengang_kz)) JOIN tbl_prestudent USING (prestudent_id)) JOIN tbl_person USING (person_id));

CREATE OR REPLACE VIEW testtool.vw_gebiet AS
SELECT count(*) AS anz_fragen, tbl_gebiet.gebiet_id, tbl_gebiet.kurzbz, tbl_gebiet.bezeichnung, tbl_gebiet.abzug, tbl_gebiet.kategorien, tbl_frage.gruppe_kurzbz 
	FROM (testtool.tbl_gebiet JOIN testtool.tbl_frage USING (gebiet_id)) 
	WHERE (NOT demo) GROUP BY tbl_gebiet.gebiet_id, tbl_gebiet.kurzbz, tbl_gebiet.bezeichnung, tbl_gebiet.abzug, tbl_frage.gruppe_kurzbz, tbl_gebiet.kategorien;

CREATE OR REPLACE VIEW testtool.vw_frage AS
SELECT prestudent_id, pruefling_id, gruppe_kurzbz, tbl_pruefling.studiengang_kz, nachname, vorname, gebdatum, geschlecht, idnachweis, 
registriert, tbl_studiengang.kurzbz AS stg_kurzbz, tbl_studiengang.bezeichnung AS stg_bez, tbl_ablauf.gebiet_id, reihung, gewicht, 
tbl_gebiet.kurzbz AS gebiet_kurzbz, tbl_gebiet.bezeichnung AS gebiet_bez, tbl_gebiet.beschreibung AS gebiet_beschreibung, tbl_gebiet.kategorien, 
zeit, abzug, frage_id, loesung, nummer, demo, text, bild, kategorie_kurzbz 
FROM ((((((testtool.tbl_pruefling JOIN tbl_studiengang USING (studiengang_kz)) JOIN testtool.tbl_ablauf USING (studiengang_kz)) 
	JOIN testtool.tbl_gebiet USING (gebiet_id)) JOIN testtool.tbl_frage USING (gebiet_id, gruppe_kurzbz)) JOIN tbl_prestudent USING (prestudent_id)) 
	JOIN tbl_person USING (person_id)) ORDER BY reihung, nummer;

CREATE OR REPLACE VIEW testtool.vw_antwort AS
SELECT vw_frage.prestudent_id,vw_frage.pruefling_id, vw_frage.gruppe_kurzbz, vw_frage.studiengang_kz, vw_frage.nachname, 
vw_frage.vorname, vw_frage.gebdatum, vw_frage.geschlecht, vw_frage.idnachweis, vw_frage.registriert, vw_frage.stg_kurzbz, 
vw_frage.stg_bez, vw_frage.gebiet_id, vw_frage.reihung, vw_frage.gewicht, vw_frage.gebiet_kurzbz, vw_frage.gebiet_bez, 
vw_frage.gebiet_beschreibung, vw_frage.zeit, vw_frage.abzug, vw_frage.frage_id, vw_frage.loesung, vw_frage.nummer, vw_frage.demo, 
vw_frage.text, vw_frage.bild, vw_frage.kategorie_kurzbz, vw_frage.kategorien, tbl_antwort.antwort, tbl_antwort.begintime, tbl_antwort.endtime 
FROM (testtool.vw_frage LEFT JOIN testtool.tbl_antwort USING (frage_id, pruefling_id)) WHERE (NOT vw_frage.demo);

CREATE OR REPLACE VIEW testtool.vw_anz_antwort AS
SELECT count(*) AS anz_antworten, vw_antwort.pruefling_id, vw_antwort.gebiet_id 
FROM testtool.vw_antwort WHERE (vw_antwort.antwort IS NOT NULL) GROUP BY vw_antwort.pruefling_id, vw_antwort.gebiet_id;

CREATE OR REPLACE VIEW testtool.vw_anz_richtig AS
SELECT count(*) AS anz_richtig, vw_antwort.pruefling_id, vw_antwort.gebiet_id 
FROM testtool.vw_antwort WHERE (vw_antwort.antwort = vw_antwort.loesung) GROUP BY vw_antwort.pruefling_id, vw_antwort.gebiet_id;

CREATE OR REPLACE VIEW testtool.vw_auswertung AS
SELECT prestudent_id, pruefling_id, nachname, vorname, gebdatum, geschlecht, idnachweis, registriert, stg_kurzbz, stg_bez, vw_pruefling.gruppe_kurzbz, 
vw_gebiet.gebiet_id, vw_gebiet.kurzbz AS gebiet, vw_gebiet.anz_fragen, vw_gebiet.abzug, anz_richtig, anz_antworten, (anz_antworten - anz_richtig) AS anz_falsch,
((anz_richtig)::double precision + (((anz_antworten - anz_richtig))::double precision * vw_gebiet.abzug)) AS punkte, 
(((100)::double precision * ((anz_richtig)::double precision + (((anz_antworten - anz_richtig))::double precision * vw_gebiet.abzug))) / (vw_gebiet.anz_fragen)::double precision) AS prozent 
FROM (((testtool.vw_pruefling JOIN testtool.vw_anz_richtig USING (pruefling_id)) JOIN testtool.vw_anz_antwort USING (pruefling_id, gebiet_id)) JOIN testtool.vw_gebiet USING (gebiet_id, gruppe_kurzbz)) WHERE (NOT vw_gebiet.kategorien);

CREATE OR REPLACE VIEW testtool.vw_auswertung_kategorie AS
SELECT antw.prestudent_id, antw.pruefling_id, antw.nachname, antw.vorname, antw.gebdatum, antw.geschlecht, antw.idnachweis, antw.registriert, antw.stg_kurzbz, antw.stg_bez, antw.gruppe_kurzbz, antw.gebiet_id, antw.kategorie_kurzbz, count(CASE WHEN (antw.antwort <> antw.loesung) THEN NULL::boolean WHEN (antw.antwort IS NULL) THEN NULL::boolean ELSE true END) AS richtig, count(CASE WHEN (antw.loesung = antw.antwort) THEN NULL::bpchar ELSE antw.loesung END) AS falsch, count(*) AS gesamt 
FROM testtool.vw_antwort antw 
GROUP BY antw.prestudent_id, antw.pruefling_id, antw.nachname, antw.vorname, antw.gebdatum, antw.geschlecht, antw.idnachweis, antw.registriert, antw.stg_kurzbz, antw.stg_bez, antw.gruppe_kurzbz, antw.gebiet_id, antw.kategorie_kurzbz, antw.kategorien HAVING antw.kategorien;

/*CREATE OR REPLACE VIEW public.vw_zutrittskarte AS
SELECT person_id,betriebsmittel_id,beschreibung,betriebsmitteltyp,nummer	reservieren,ort_kurzbz,	tbl_betriebsmittelperson.anmerkung,	kaution	,ausgegebenam,	retouram,
	tbl_betriebsmittelperson.insertamum,tbl_betriebsmittelperson.insertvon,tbl_betriebsmittelperson.updateamum,tbl_betriebsmittelperson.updatevon,tbl_betriebsmittelperson.ext_id,
	staatsbuergerschaft,geburtsnation,sprache,anrede,titelpost,titelpre,nachname,vorname,vornamen,gebdatum,gebort,gebzeit,foto, homepage,	svnr,	ersatzkennzeichen,	familienstand,
	geschlecht,	anzahlkinder,	aktiv	insertamum	insertvon	updateamum	updatevon	ext_id	uid	aktiv	alias	insertamum	insertvon	updateamum	updatevon	ext_id
 FROM tbl_betriebsmittel JOIN tbl_betriebsmittelperson USING (betriebsmittel_id) JOIN tbl_person USING (person_id) JOIN tbl_benutzer USING (person_id) 
 WHERE betriebsmitteltyp='Zutrittskarte' LIMIT 10*/


/* Creating roles */
Create group "admin";
Create group "web";


/* Groups permissions for tables */
Grant select on "lehre"."tbl_lehreinheit" to group "admin";
Grant update on "lehre"."tbl_lehreinheit" to group "admin";
Grant delete on "lehre"."tbl_lehreinheit" to group "admin";
Grant insert on "lehre"."tbl_lehreinheit" to group "admin";
Grant select on "lehre"."tbl_lehreinheit" to group "web";
Grant select on "public"."tbl_gruppe" to group "admin";
Grant update on "public"."tbl_gruppe" to group "admin";
Grant delete on "public"."tbl_gruppe" to group "admin";
Grant insert on "public"."tbl_gruppe" to group "admin";
Grant select on "public"."tbl_gruppe" to group "web";
Grant select on "public"."tbl_funktion" to group "admin";
Grant update on "public"."tbl_funktion" to group "admin";
Grant delete on "public"."tbl_funktion" to group "admin";
Grant insert on "public"."tbl_funktion" to group "admin";
Grant select on "public"."tbl_funktion" to group "web";
Grant select on "lehre"."tbl_lehrfach" to group "admin";
Grant update on "lehre"."tbl_lehrfach" to group "admin";
Grant delete on "lehre"."tbl_lehrfach" to group "admin";
Grant insert on "lehre"."tbl_lehrfach" to group "admin";
Grant select on "lehre"."tbl_lehrfach" to group "web";
Grant select on "public"."tbl_mitarbeiter" to group "admin";
Grant update on "public"."tbl_mitarbeiter" to group "admin";
Grant delete on "public"."tbl_mitarbeiter" to group "admin";
Grant insert on "public"."tbl_mitarbeiter" to group "admin";
Grant select on "public"."tbl_mitarbeiter" to group "web";
Grant select on "public"."tbl_ort" to group "admin";
Grant update on "public"."tbl_ort" to group "admin";
Grant delete on "public"."tbl_ort" to group "admin";
Grant insert on "public"."tbl_ort" to group "admin";
Grant select on "public"."tbl_ort" to group "web";
Grant select on "public"."tbl_benutzer" to group "admin";
Grant update on "public"."tbl_benutzer" to group "admin";
Grant delete on "public"."tbl_benutzer" to group "admin";
Grant insert on "public"."tbl_benutzer" to group "admin";
Grant select on "public"."tbl_benutzer" to group "web";
Grant select on "public"."tbl_benutzerfunktion" to group "admin";
Grant update on "public"."tbl_benutzerfunktion" to group "admin";
Grant delete on "public"."tbl_benutzerfunktion" to group "admin";
Grant insert on "public"."tbl_benutzerfunktion" to group "admin";
Grant select on "public"."tbl_benutzerfunktion" to group "web";
Grant select on "public"."tbl_benutzergruppe" to group "admin";
Grant update on "public"."tbl_benutzergruppe" to group "admin";
Grant delete on "public"."tbl_benutzergruppe" to group "admin";
Grant insert on "public"."tbl_benutzergruppe" to group "admin";
Grant select on "public"."tbl_benutzergruppe" to group "web";
Grant select on "public"."tbl_student" to group "admin";
Grant update on "public"."tbl_student" to group "admin";
Grant delete on "public"."tbl_student" to group "admin";
Grant insert on "public"."tbl_student" to group "admin";
Grant select on "public"."tbl_student" to group "web";
Grant select on "public"."tbl_studiengang" to group "admin";
Grant update on "public"."tbl_studiengang" to group "admin";
Grant delete on "public"."tbl_studiengang" to group "admin";
Grant insert on "public"."tbl_studiengang" to group "admin";
Grant select on "public"."tbl_studiengang" to group "web";
Grant select on "lehre"."tbl_stunde" to group "admin";
Grant update on "lehre"."tbl_stunde" to group "admin";
Grant delete on "lehre"."tbl_stunde" to group "admin";
Grant insert on "lehre"."tbl_stunde" to group "admin";
Grant select on "lehre"."tbl_stunde" to group "web";
Grant select on "lehre"."tbl_stundenplan" to group "admin";
Grant update on "lehre"."tbl_stundenplan" to group "admin";
Grant delete on "lehre"."tbl_stundenplan" to group "admin";
Grant insert on "lehre"."tbl_stundenplan" to group "admin";
Grant select on "lehre"."tbl_stundenplan" to group "web";
Grant select on "campus"."tbl_zeitwunsch" to group "admin";
Grant update on "campus"."tbl_zeitwunsch" to group "admin";
Grant delete on "campus"."tbl_zeitwunsch" to group "admin";
Grant insert on "campus"."tbl_zeitwunsch" to group "admin";
Grant select on "campus"."tbl_zeitwunsch" to group "web";
Grant update on "campus"."tbl_zeitwunsch" to group "web";
Grant delete on "campus"."tbl_zeitwunsch" to group "web";
Grant insert on "campus"."tbl_zeitwunsch" to group "web";
Grant select on "public"."tbl_fachbereich" to group "admin";
Grant update on "public"."tbl_fachbereich" to group "admin";
Grant delete on "public"."tbl_fachbereich" to group "admin";
Grant insert on "public"."tbl_fachbereich" to group "admin";
Grant select on "public"."tbl_fachbereich" to group "web";
Grant select on "campus"."tbl_zeitsperre" to group "admin";
Grant update on "campus"."tbl_zeitsperre" to group "admin";
Grant delete on "campus"."tbl_zeitsperre" to group "admin";
Grant insert on "campus"."tbl_zeitsperre" to group "admin";
Grant select on "campus"."tbl_zeitsperre" to group "web";
Grant update on "campus"."tbl_zeitsperre" to group "web";
Grant delete on "campus"."tbl_zeitsperre" to group "web";
Grant insert on "campus"."tbl_zeitsperre" to group "web";
Grant select on "public"."tbl_adresse" to group "admin";
Grant update on "public"."tbl_adresse" to group "admin";
Grant delete on "public"."tbl_adresse" to group "admin";
Grant insert on "public"."tbl_adresse" to group "admin";
Grant select on "public"."tbl_adresse" to group "web";
Grant select on "campus"."tbl_reservierung" to group "admin";
Grant update on "campus"."tbl_reservierung" to group "admin";
Grant delete on "campus"."tbl_reservierung" to group "admin";
Grant insert on "campus"."tbl_reservierung" to group "admin";
Grant select on "campus"."tbl_reservierung" to group "web";
Grant update on "campus"."tbl_reservierung" to group "web";
Grant delete on "campus"."tbl_reservierung" to group "web";
Grant insert on "campus"."tbl_reservierung" to group "web";
Grant select on "public"."tbl_raumtyp" to group "admin";
Grant update on "public"."tbl_raumtyp" to group "admin";
Grant delete on "public"."tbl_raumtyp" to group "admin";
Grant insert on "public"."tbl_raumtyp" to group "admin";
Grant select on "public"."tbl_raumtyp" to group "web";
Grant select on "lehre"."tbl_lehrform" to group "admin";
Grant update on "lehre"."tbl_lehrform" to group "admin";
Grant delete on "lehre"."tbl_lehrform" to group "admin";
Grant insert on "lehre"."tbl_lehrform" to group "admin";
Grant select on "lehre"."tbl_lehrform" to group "web";
Grant select on "public"."tbl_berechtigung" to group "admin";
Grant update on "public"."tbl_berechtigung" to group "admin";
Grant delete on "public"."tbl_berechtigung" to group "admin";
Grant insert on "public"."tbl_berechtigung" to group "admin";
Grant select on "public"."tbl_berechtigung" to group "web";
Grant select on "public"."tbl_benutzerberechtigung" to group "admin";
Grant update on "public"."tbl_benutzerberechtigung" to group "admin";
Grant delete on "public"."tbl_benutzerberechtigung" to group "admin";
Grant insert on "public"."tbl_benutzerberechtigung" to group "admin";
Grant select on "public"."tbl_benutzerberechtigung" to group "web";
Grant select on "public"."tbl_studiensemester" to group "admin";
Grant update on "public"."tbl_studiensemester" to group "admin";
Grant delete on "public"."tbl_studiensemester" to group "admin";
Grant insert on "public"."tbl_studiensemester" to group "admin";
Grant select on "public"."tbl_studiensemester" to group "web";
Grant select on "lehre"."tbl_stundenplandev" to group "admin";
Grant update on "lehre"."tbl_stundenplandev" to group "admin";
Grant delete on "lehre"."tbl_stundenplandev" to group "admin";
Grant insert on "lehre"."tbl_stundenplandev" to group "admin";
Grant select on "public"."tbl_betriebsmittelperson" to group "admin";
Grant update on "public"."tbl_betriebsmittelperson" to group "admin";
Grant delete on "public"."tbl_betriebsmittelperson" to group "admin";
Grant insert on "public"."tbl_betriebsmittelperson" to group "admin";
Grant select on "public"."tbl_betriebsmittelperson" to group "web";
Grant select on "campus"."tbl_bmreservierung" to group "admin";
Grant update on "campus"."tbl_bmreservierung" to group "admin";
Grant delete on "campus"."tbl_bmreservierung" to group "admin";
Grant insert on "campus"."tbl_bmreservierung" to group "admin";
Grant select on "campus"."tbl_bmreservierung" to group "web";
Grant update on "campus"."tbl_bmreservierung" to group "web";
Grant delete on "campus"."tbl_bmreservierung" to group "web";
Grant insert on "campus"."tbl_bmreservierung" to group "web";
Grant select on "lehre"."tbl_ferien" to group "admin";
Grant update on "lehre"."tbl_ferien" to group "admin";
Grant delete on "lehre"."tbl_ferien" to group "admin";
Grant insert on "lehre"."tbl_ferien" to group "admin";
Grant select on "lehre"."tbl_ferien" to group "web";
Grant select on "public"."tbl_ortraumtyp" to group "admin";
Grant update on "public"."tbl_ortraumtyp" to group "admin";
Grant delete on "public"."tbl_ortraumtyp" to group "admin";
Grant insert on "public"."tbl_ortraumtyp" to group "admin";
Grant select on "public"."tbl_ortraumtyp" to group "web";
Grant select on "lehre"."tbl_zeitfenster" to group "admin";
Grant update on "lehre"."tbl_zeitfenster" to group "admin";
Grant delete on "lehre"."tbl_zeitfenster" to group "admin";
Grant insert on "lehre"."tbl_zeitfenster" to group "admin";
Grant select on "lehre"."tbl_zeitfenster" to group "web";
Grant select on "public"."tbl_variable" to group "admin";
Grant update on "public"."tbl_variable" to group "admin";
Grant delete on "public"."tbl_variable" to group "admin";
Grant insert on "public"."tbl_variable" to group "admin";
Grant select on "public"."tbl_sprache" to group "admin";
Grant update on "public"."tbl_sprache" to group "admin";
Grant delete on "public"."tbl_sprache" to group "admin";
Grant insert on "public"."tbl_sprache" to group "admin";
Grant select on "public"."tbl_sprache" to group "web";
Grant select on "campus"."tbl_lvinfo" to group "admin";
Grant update on "campus"."tbl_lvinfo" to group "admin";
Grant delete on "campus"."tbl_lvinfo" to group "admin";
Grant insert on "campus"."tbl_lvinfo" to group "admin";
Grant select on "campus"."tbl_lvinfo" to group "web";
Grant update on "campus"."tbl_lvinfo" to group "web";
Grant delete on "campus"."tbl_lvinfo" to group "web";
Grant insert on "campus"."tbl_lvinfo" to group "web";
Grant select on "campus"."tbl_feedback" to group "admin";
Grant update on "campus"."tbl_feedback" to group "admin";
Grant delete on "campus"."tbl_feedback" to group "admin";
Grant insert on "campus"."tbl_feedback" to group "admin";
Grant select on "campus"."tbl_feedback" to group "web";
Grant insert on "campus"."tbl_feedback" to group "web";
Grant select on "campus"."tbl_news" to group "admin";
Grant update on "campus"."tbl_news" to group "admin";
Grant delete on "campus"."tbl_news" to group "admin";
Grant insert on "campus"."tbl_news" to group "admin";
Grant select on "campus"."tbl_news" to group "web";
Grant update on "campus"."tbl_news" to group "web";
Grant delete on "campus"."tbl_news" to group "web";
Grant insert on "campus"."tbl_news" to group "web";
Grant select on "campus"."tbl_benutzerlvstudiensemester" to group "admin";
Grant update on "campus"."tbl_benutzerlvstudiensemester" to group "admin";
Grant delete on "campus"."tbl_benutzerlvstudiensemester" to group "admin";
Grant insert on "campus"."tbl_benutzerlvstudiensemester" to group "admin";
Grant select on "campus"."tbl_benutzerlvstudiensemester" to group "web";
Grant update on "campus"."tbl_benutzerlvstudiensemester" to group "web";
Grant delete on "campus"."tbl_benutzerlvstudiensemester" to group "web";
Grant insert on "campus"."tbl_benutzerlvstudiensemester" to group "web";
Grant select on "public"."tbl_person" to group "admin";
Grant update on "public"."tbl_person" to group "admin";
Grant delete on "public"."tbl_person" to group "admin";
Grant insert on "public"."tbl_person" to group "admin";
Grant select on "public"."tbl_person" to group "web";
Grant select on "public"."tbl_erhalter" to group "admin";
Grant update on "public"."tbl_erhalter" to group "admin";
Grant delete on "public"."tbl_erhalter" to group "admin";
Grant insert on "public"."tbl_erhalter" to group "admin";
Grant select on "public"."tbl_erhalter" to group "web";
Grant select on "public"."tbl_lehrverband" to group "admin";
Grant update on "public"."tbl_lehrverband" to group "admin";
Grant delete on "public"."tbl_lehrverband" to group "admin";
Grant insert on "public"."tbl_lehrverband" to group "admin";
Grant select on "public"."tbl_lehrverband" to group "web";
Grant select on "bis"."tbl_gemeinde" to group "admin";
Grant update on "bis"."tbl_gemeinde" to group "admin";
Grant delete on "bis"."tbl_gemeinde" to group "admin";
Grant insert on "bis"."tbl_gemeinde" to group "admin";
Grant select on "public"."tbl_log" to group "admin";
Grant update on "public"."tbl_log" to group "admin";
Grant delete on "public"."tbl_log" to group "admin";
Grant insert on "public"."tbl_log" to group "admin";
Grant select on "public"."tbl_log" to group "web";
Grant select on "public"."tbl_konto" to group "admin";
Grant update on "public"."tbl_konto" to group "admin";
Grant delete on "public"."tbl_konto" to group "admin";
Grant insert on "public"."tbl_konto" to group "admin";
Grant select on "public"."tbl_konto" to group "web";
Grant select on "campus"."tbl_uebung" to group "admin";
Grant update on "campus"."tbl_uebung" to group "admin";
Grant delete on "campus"."tbl_uebung" to group "admin";
Grant insert on "campus"."tbl_uebung" to group "admin";
Grant select on "campus"."tbl_uebung" to group "web";
Grant update on "campus"."tbl_uebung" to group "web";
Grant delete on "campus"."tbl_uebung" to group "web";
Grant insert on "campus"."tbl_uebung" to group "web";
Grant select on "campus"."tbl_studentuebung" to group "admin";
Grant update on "campus"."tbl_studentuebung" to group "admin";
Grant delete on "campus"."tbl_studentuebung" to group "admin";
Grant insert on "campus"."tbl_studentuebung" to group "admin";
Grant select on "campus"."tbl_studentuebung" to group "web";
Grant update on "campus"."tbl_studentuebung" to group "web";
Grant delete on "campus"."tbl_studentuebung" to group "web";
Grant insert on "campus"."tbl_studentuebung" to group "web";
Grant select on "lehre"."tbl_lehrveranstaltung" to group "admin";
Grant update on "lehre"."tbl_lehrveranstaltung" to group "admin";
Grant delete on "lehre"."tbl_lehrveranstaltung" to group "admin";
Grant insert on "lehre"."tbl_lehrveranstaltung" to group "admin";
Grant select on "lehre"."tbl_lehrveranstaltung" to group "web";
Grant select on "lehre"."tbl_lehreinheitgruppe" to group "admin";
Grant update on "lehre"."tbl_lehreinheitgruppe" to group "admin";
Grant delete on "lehre"."tbl_lehreinheitgruppe" to group "admin";
Grant insert on "lehre"."tbl_lehreinheitgruppe" to group "admin";
Grant select on "lehre"."tbl_lehreinheitgruppe" to group "web";
Grant select on "campus"."tbl_beispiel" to group "admin";
Grant update on "campus"."tbl_beispiel" to group "admin";
Grant delete on "campus"."tbl_beispiel" to group "admin";
Grant insert on "campus"."tbl_beispiel" to group "admin";
Grant select on "campus"."tbl_beispiel" to group "web";
Grant update on "campus"."tbl_beispiel" to group "web";
Grant delete on "campus"."tbl_beispiel" to group "web";
Grant insert on "campus"."tbl_beispiel" to group "web";
Grant select on "campus"."tbl_studentbeispiel" to group "admin";
Grant update on "campus"."tbl_studentbeispiel" to group "admin";
Grant delete on "campus"."tbl_studentbeispiel" to group "admin";
Grant insert on "campus"."tbl_studentbeispiel" to group "admin";
Grant select on "campus"."tbl_studentbeispiel" to group "web";
Grant update on "campus"."tbl_studentbeispiel" to group "web";
Grant delete on "campus"."tbl_studentbeispiel" to group "web";
Grant insert on "campus"."tbl_studentbeispiel" to group "web";
Grant select on "campus"."tbl_notenschluessel" to group "admin";
Grant update on "campus"."tbl_notenschluessel" to group "admin";
Grant delete on "campus"."tbl_notenschluessel" to group "admin";
Grant insert on "campus"."tbl_notenschluessel" to group "admin";
Grant select on "campus"."tbl_notenschluessel" to group "web";
Grant update on "campus"."tbl_notenschluessel" to group "web";
Grant delete on "campus"."tbl_notenschluessel" to group "web";
Grant insert on "campus"."tbl_notenschluessel" to group "web";
Grant select on "campus"."tbl_legesamtnote" to group "admin";
Grant update on "campus"."tbl_legesamtnote" to group "admin";
Grant delete on "campus"."tbl_legesamtnote" to group "admin";
Grant insert on "campus"."tbl_legesamtnote" to group "admin";
Grant select on "campus"."tbl_legesamtnote" to group "web";
Grant update on "campus"."tbl_legesamtnote" to group "web";
Grant delete on "campus"."tbl_legesamtnote" to group "web";
Grant insert on "campus"."tbl_legesamtnote" to group "web";
Grant select on "public"."tbl_status" to group "admin";
Grant update on "public"."tbl_status" to group "admin";
Grant delete on "public"."tbl_status" to group "admin";
Grant insert on "public"."tbl_status" to group "admin";
Grant select on "public"."tbl_status" to group "web";
Grant select on "public"."tbl_prestudentstatus" to group "admin";
Grant update on "public"."tbl_prestudentstatus" to group "admin";
Grant delete on "public"."tbl_prestudentstatus" to group "admin";
Grant insert on "public"."tbl_prestudentstatus" to group "admin";
Grant select on "public"."tbl_prestudentstatus" to group "web";
Grant select on "public"."tbl_prestudent" to group "admin";
Grant update on "public"."tbl_prestudent" to group "admin";
Grant delete on "public"."tbl_prestudent" to group "admin";
Grant insert on "public"."tbl_prestudent" to group "admin";
Grant select on "public"."tbl_prestudent" to group "web";
Grant select on "bis"."tbl_bisfunktion" to group "admin";
Grant update on "bis"."tbl_bisfunktion" to group "admin";
Grant delete on "bis"."tbl_bisfunktion" to group "admin";
Grant insert on "bis"."tbl_bisfunktion" to group "admin";
Grant select on "bis"."tbl_bisfunktion" to group "web";
Grant select on "bis"."tbl_bisverwendung" to group "admin";
Grant update on "bis"."tbl_bisverwendung" to group "admin";
Grant delete on "bis"."tbl_bisverwendung" to group "admin";
Grant insert on "bis"."tbl_bisverwendung" to group "admin";
Grant select on "bis"."tbl_bisverwendung" to group "web";
Grant select on "bis"."tbl_hauptberuf" to group "admin";
Grant update on "bis"."tbl_hauptberuf" to group "admin";
Grant delete on "bis"."tbl_hauptberuf" to group "admin";
Grant insert on "bis"."tbl_hauptberuf" to group "admin";
Grant select on "bis"."tbl_hauptberuf" to group "web";
Grant select on "bis"."tbl_besqual" to group "admin";
Grant update on "bis"."tbl_besqual" to group "admin";
Grant delete on "bis"."tbl_besqual" to group "admin";
Grant insert on "bis"."tbl_besqual" to group "admin";
Grant select on "bis"."tbl_besqual" to group "web";
Grant select on "bis"."tbl_beschaeftigungsart1" to group "admin";
Grant update on "bis"."tbl_beschaeftigungsart1" to group "admin";
Grant delete on "bis"."tbl_beschaeftigungsart1" to group "admin";
Grant insert on "bis"."tbl_beschaeftigungsart1" to group "admin";
Grant select on "bis"."tbl_beschaeftigungsart1" to group "web";
Grant select on "bis"."tbl_beschaeftigungsart2" to group "admin";
Grant update on "bis"."tbl_beschaeftigungsart2" to group "admin";
Grant delete on "bis"."tbl_beschaeftigungsart2" to group "admin";
Grant insert on "bis"."tbl_beschaeftigungsart2" to group "admin";
Grant select on "bis"."tbl_beschaeftigungsart2" to group "web";
Grant select on "bis"."tbl_beschaeftigungsausmass" to group "admin";
Grant update on "bis"."tbl_beschaeftigungsausmass" to group "admin";
Grant delete on "bis"."tbl_beschaeftigungsausmass" to group "admin";
Grant insert on "bis"."tbl_beschaeftigungsausmass" to group "admin";
Grant select on "bis"."tbl_beschaeftigungsausmass" to group "web";
Grant select on "bis"."tbl_verwendung" to group "admin";
Grant update on "bis"."tbl_verwendung" to group "admin";
Grant delete on "bis"."tbl_verwendung" to group "admin";
Grant insert on "bis"."tbl_verwendung" to group "admin";
Grant select on "bis"."tbl_verwendung" to group "web";
Grant select on "bis"."tbl_ausbildung" to group "admin";
Grant update on "bis"."tbl_ausbildung" to group "admin";
Grant delete on "bis"."tbl_ausbildung" to group "admin";
Grant insert on "bis"."tbl_ausbildung" to group "admin";
Grant select on "bis"."tbl_ausbildung" to group "web";
Grant select on "public"."tbl_kontakt" to group "admin";
Grant update on "public"."tbl_kontakt" to group "admin";
Grant delete on "public"."tbl_kontakt" to group "admin";
Grant insert on "public"."tbl_kontakt" to group "admin";
Grant select on "public"."tbl_kontakt" to group "web";
Grant select on "public"."tbl_kontakttyp" to group "admin";
Grant update on "public"."tbl_kontakttyp" to group "admin";
Grant delete on "public"."tbl_kontakttyp" to group "admin";
Grant insert on "public"."tbl_kontakttyp" to group "admin";
Grant select on "public"."tbl_kontakttyp" to group "web";
Grant select on "public"."tbl_firma" to group "admin";
Grant update on "public"."tbl_firma" to group "admin";
Grant delete on "public"."tbl_firma" to group "admin";
Grant insert on "public"."tbl_firma" to group "admin";
Grant select on "public"."tbl_firma" to group "web";
Grant select on "bis"."tbl_zgv" to group "admin";
Grant update on "bis"."tbl_zgv" to group "admin";
Grant delete on "bis"."tbl_zgv" to group "admin";
Grant insert on "bis"."tbl_zgv" to group "admin";
Grant select on "bis"."tbl_zgv" to group "web";
Grant select on "bis"."tbl_berufstaetigkeit" to group "admin";
Grant update on "bis"."tbl_berufstaetigkeit" to group "admin";
Grant delete on "bis"."tbl_berufstaetigkeit" to group "admin";
Grant insert on "bis"."tbl_berufstaetigkeit" to group "admin";
Grant select on "bis"."tbl_berufstaetigkeit" to group "web";
Grant select on "bis"."tbl_zgvmaster" to group "admin";
Grant update on "bis"."tbl_zgvmaster" to group "admin";
Grant delete on "bis"."tbl_zgvmaster" to group "admin";
Grant insert on "bis"."tbl_zgvmaster" to group "admin";
Grant select on "bis"."tbl_zgvmaster" to group "web";
Grant select on "public"."tbl_aufmerksamdurch" to group "admin";
Grant update on "public"."tbl_aufmerksamdurch" to group "admin";
Grant delete on "public"."tbl_aufmerksamdurch" to group "admin";
Grant insert on "public"."tbl_aufmerksamdurch" to group "admin";
Grant select on "public"."tbl_aufmerksamdurch" to group "web";
Grant select on "public"."tbl_aufnahmeschluessel" to group "admin";
Grant update on "public"."tbl_aufnahmeschluessel" to group "admin";
Grant delete on "public"."tbl_aufnahmeschluessel" to group "admin";
Grant insert on "public"."tbl_aufnahmeschluessel" to group "admin";
Grant select on "public"."tbl_aufnahmeschluessel" to group "web";
Grant select on "public"."tbl_reihungstest" to group "admin";
Grant update on "public"."tbl_reihungstest" to group "admin";
Grant delete on "public"."tbl_reihungstest" to group "admin";
Grant insert on "public"."tbl_reihungstest" to group "admin";
Grant select on "public"."tbl_reihungstest" to group "web";
Grant select on "public"."tbl_betriebsmittel" to group "admin";
Grant update on "public"."tbl_betriebsmittel" to group "admin";
Grant delete on "public"."tbl_betriebsmittel" to group "admin";
Grant insert on "public"."tbl_betriebsmittel" to group "admin";
Grant select on "public"."tbl_betriebsmittel" to group "web";
Grant select on "lehre"."tbl_lehreinheitmitarbeiter" to group "admin";
Grant update on "lehre"."tbl_lehreinheitmitarbeiter" to group "admin";
Grant delete on "lehre"."tbl_lehreinheitmitarbeiter" to group "admin";
Grant insert on "lehre"."tbl_lehreinheitmitarbeiter" to group "admin";
Grant select on "lehre"."tbl_lehreinheitmitarbeiter" to group "web";
Grant select on "campus"."tbl_abgabe" to group "admin";
Grant update on "campus"."tbl_abgabe" to group "admin";
Grant delete on "campus"."tbl_abgabe" to group "admin";
Grant insert on "campus"."tbl_abgabe" to group "admin";
Grant select on "campus"."tbl_abgabe" to group "web";
Grant update on "campus"."tbl_abgabe" to group "web";
Grant delete on "campus"."tbl_abgabe" to group "web";
Grant insert on "campus"."tbl_abgabe" to group "web";
Grant select on "campus"."tbl_lvgesamtnote" to group "admin";
Grant update on "campus"."tbl_lvgesamtnote" to group "admin";
Grant delete on "campus"."tbl_lvgesamtnote" to group "admin";
Grant insert on "campus"."tbl_lvgesamtnote" to group "admin";
Grant select on "campus"."tbl_lvgesamtnote" to group "web";
Grant update on "campus"."tbl_lvgesamtnote" to group "web";
Grant delete on "campus"."tbl_lvgesamtnote" to group "web";
Grant insert on "campus"."tbl_lvgesamtnote" to group "web";
Grant select on "lehre"."tbl_zeugnisnote" to group "admin";
Grant update on "lehre"."tbl_zeugnisnote" to group "admin";
Grant delete on "lehre"."tbl_zeugnisnote" to group "admin";
Grant insert on "lehre"."tbl_zeugnisnote" to group "admin";
Grant select on "lehre"."tbl_zeugnisnote" to group "web";
Grant select on "lehre"."tbl_zeugnis" to group "admin";
Grant update on "lehre"."tbl_zeugnis" to group "admin";
Grant delete on "lehre"."tbl_zeugnis" to group "admin";
Grant insert on "lehre"."tbl_zeugnis" to group "admin";
Grant select on "lehre"."tbl_zeugnis" to group "web";
Grant select on "lehre"."tbl_projektarbeit" to group "admin";
Grant update on "lehre"."tbl_projektarbeit" to group "admin";
Grant delete on "lehre"."tbl_projektarbeit" to group "admin";
Grant insert on "lehre"."tbl_projektarbeit" to group "admin";
Grant select on "lehre"."tbl_projektarbeit" to group "web";
Grant select on "lehre"."tbl_note" to group "admin";
Grant update on "lehre"."tbl_note" to group "admin";
Grant delete on "lehre"."tbl_note" to group "admin";
Grant insert on "lehre"."tbl_note" to group "admin";
Grant select on "lehre"."tbl_note" to group "web";
Grant select on "lehre"."tbl_projekttyp" to group "admin";
Grant update on "lehre"."tbl_projekttyp" to group "admin";
Grant delete on "lehre"."tbl_projekttyp" to group "admin";
Grant insert on "lehre"."tbl_projekttyp" to group "admin";
Grant select on "lehre"."tbl_projekttyp" to group "web";
Grant select on "lehre"."tbl_projektbetreuer" to group "admin";
Grant update on "lehre"."tbl_projektbetreuer" to group "admin";
Grant delete on "lehre"."tbl_projektbetreuer" to group "admin";
Grant insert on "lehre"."tbl_projektbetreuer" to group "admin";
Grant select on "lehre"."tbl_projektbetreuer" to group "web";
Grant select on "public"."tbl_betriebsmitteltyp" to group "admin";
Grant update on "public"."tbl_betriebsmitteltyp" to group "admin";
Grant delete on "public"."tbl_betriebsmitteltyp" to group "admin";
Grant insert on "public"."tbl_betriebsmitteltyp" to group "admin";
Grant select on "public"."tbl_betriebsmitteltyp" to group "web";
Grant select on "bis"."tbl_nation" to group "admin";
Grant update on "bis"."tbl_nation" to group "admin";
Grant delete on "bis"."tbl_nation" to group "admin";
Grant insert on "bis"."tbl_nation" to group "admin";
Grant select on "bis"."tbl_nation" to group "web";
Grant select on "lehre"."tbl_abschlussbeurteilung" to group "admin";
Grant update on "lehre"."tbl_abschlussbeurteilung" to group "admin";
Grant delete on "lehre"."tbl_abschlussbeurteilung" to group "admin";
Grant insert on "lehre"."tbl_abschlussbeurteilung" to group "admin";
Grant select on "lehre"."tbl_abschlussbeurteilung" to group "web";
Grant select on "lehre"."tbl_abschlusspruefung" to group "admin";
Grant update on "lehre"."tbl_abschlusspruefung" to group "admin";
Grant delete on "lehre"."tbl_abschlusspruefung" to group "admin";
Grant insert on "lehre"."tbl_abschlusspruefung" to group "admin";
Grant select on "lehre"."tbl_abschlusspruefung" to group "web";
Grant select on "lehre"."tbl_akadgrad" to group "admin";
Grant update on "lehre"."tbl_akadgrad" to group "admin";
Grant delete on "lehre"."tbl_akadgrad" to group "admin";
Grant insert on "lehre"."tbl_akadgrad" to group "admin";
Grant select on "lehre"."tbl_akadgrad" to group "web";
Grant select on "public"."tbl_bankverbindung" to group "admin";
Grant update on "public"."tbl_bankverbindung" to group "admin";
Grant delete on "public"."tbl_bankverbindung" to group "admin";
Grant insert on "public"."tbl_bankverbindung" to group "admin";
Grant select on "public"."tbl_bankverbindung" to group "web";
Grant select on "public"."tbl_semesterwochen" to group "admin";
Grant update on "public"."tbl_semesterwochen" to group "admin";
Grant delete on "public"."tbl_semesterwochen" to group "admin";
Grant insert on "public"."tbl_semesterwochen" to group "admin";
Grant select on "public"."tbl_semesterwochen" to group "web";
Grant select on "bis"."tbl_entwicklungsteam" to group "admin";
Grant update on "bis"."tbl_entwicklungsteam" to group "admin";
Grant delete on "bis"."tbl_entwicklungsteam" to group "admin";
Grant insert on "bis"."tbl_entwicklungsteam" to group "admin";
Grant select on "bis"."tbl_entwicklungsteam" to group "web";
Grant select on "public"."tbl_dokument" to group "admin";
Grant update on "public"."tbl_dokument" to group "admin";
Grant delete on "public"."tbl_dokument" to group "admin";
Grant insert on "public"."tbl_dokument" to group "admin";
Grant select on "public"."tbl_dokument" to group "web";
Grant select on "public"."tbl_dokumentstudiengang" to group "admin";
Grant update on "public"."tbl_dokumentstudiengang" to group "admin";
Grant delete on "public"."tbl_dokumentstudiengang" to group "admin";
Grant insert on "public"."tbl_dokumentstudiengang" to group "admin";
Grant select on "public"."tbl_dokumentstudiengang" to group "web";
Grant select on "public"."tbl_dokumentprestudent" to group "admin";
Grant update on "public"."tbl_dokumentprestudent" to group "admin";
Grant delete on "public"."tbl_dokumentprestudent" to group "admin";
Grant insert on "public"."tbl_dokumentprestudent" to group "admin";
Grant select on "public"."tbl_dokumentprestudent" to group "web";
Grant select on "bis"."tbl_mobilitaetsprogramm" to group "admin";
Grant update on "bis"."tbl_mobilitaetsprogramm" to group "admin";
Grant delete on "bis"."tbl_mobilitaetsprogramm" to group "admin";
Grant insert on "bis"."tbl_mobilitaetsprogramm" to group "admin";
Grant select on "bis"."tbl_mobilitaetsprogramm" to group "web";
Grant select on "bis"."tbl_zweck" to group "admin";
Grant update on "bis"."tbl_zweck" to group "admin";
Grant delete on "bis"."tbl_zweck" to group "admin";
Grant insert on "bis"."tbl_zweck" to group "admin";
Grant select on "bis"."tbl_zweck" to group "web";
Grant select on "bis"."tbl_bisio" to group "admin";
Grant update on "bis"."tbl_bisio" to group "admin";
Grant delete on "bis"."tbl_bisio" to group "admin";
Grant insert on "bis"."tbl_bisio" to group "admin";
Grant select on "bis"."tbl_bisio" to group "web";
Grant select on "campus"."tbl_zeitsperretyp" to group "admin";
Grant update on "campus"."tbl_zeitsperretyp" to group "admin";
Grant delete on "campus"."tbl_zeitsperretyp" to group "admin";
Grant insert on "campus"."tbl_zeitsperretyp" to group "admin";
Grant select on "campus"."tbl_zeitsperretyp" to group "web";
Grant select on "public"."tbl_firmentyp" to group "admin";
Grant update on "public"."tbl_firmentyp" to group "admin";
Grant delete on "public"."tbl_firmentyp" to group "admin";
Grant insert on "public"."tbl_firmentyp" to group "admin";
Grant select on "public"."tbl_firmentyp" to group "web";
Grant select on "lehre"."tbl_lehrfunktion" to group "admin";
Grant update on "lehre"."tbl_lehrfunktion" to group "admin";
Grant delete on "lehre"."tbl_lehrfunktion" to group "admin";
Grant insert on "lehre"."tbl_lehrfunktion" to group "admin";
Grant select on "lehre"."tbl_lehrfunktion" to group "web";
Grant select on "lehre"."tbl_pruefung" to group "admin";
Grant update on "lehre"."tbl_pruefung" to group "admin";
Grant delete on "lehre"."tbl_pruefung" to group "admin";
Grant insert on "lehre"."tbl_pruefung" to group "admin";
Grant select on "lehre"."tbl_pruefung" to group "web";
Grant select on "lehre"."tbl_pruefungstyp" to group "admin";
Grant update on "lehre"."tbl_pruefungstyp" to group "admin";
Grant delete on "lehre"."tbl_pruefungstyp" to group "admin";
Grant insert on "lehre"."tbl_pruefungstyp" to group "admin";
Grant select on "lehre"."tbl_pruefungstyp" to group "web";
Grant select on "public"."tbl_studentlehrverband" to group "admin";
Grant update on "public"."tbl_studentlehrverband" to group "admin";
Grant delete on "public"."tbl_studentlehrverband" to group "admin";
Grant insert on "public"."tbl_studentlehrverband" to group "admin";
Grant select on "public"."tbl_studentlehrverband" to group "web";
Grant select on "campus"."tbl_newssprache" to group "admin";
Grant update on "campus"."tbl_newssprache" to group "admin";
Grant delete on "campus"."tbl_newssprache" to group "admin";
Grant insert on "campus"."tbl_newssprache" to group "admin";
Grant select on "campus"."tbl_newssprache" to group "web";
Grant update on "campus"."tbl_newssprache" to group "web";
Grant delete on "campus"."tbl_newssprache" to group "web";
Grant insert on "campus"."tbl_newssprache" to group "web";
Grant select on "public"."tbl_standort" to group "admin";
Grant update on "public"."tbl_standort" to group "admin";
Grant delete on "public"."tbl_standort" to group "admin";
Grant insert on "public"."tbl_standort" to group "admin";
Grant select on "public"."tbl_standort" to group "web";
Grant select on "campus"."tbl_erreichbarkeit" to group "admin";
Grant update on "campus"."tbl_erreichbarkeit" to group "admin";
Grant delete on "campus"."tbl_erreichbarkeit" to group "admin";
Grant insert on "campus"."tbl_erreichbarkeit" to group "admin";
Grant select on "campus"."tbl_erreichbarkeit" to group "web";
Grant select on "campus"."tbl_notenschluesseluebung" to group "admin";
Grant update on "campus"."tbl_notenschluesseluebung" to group "admin";
Grant delete on "campus"."tbl_notenschluesseluebung" to group "admin";
Grant insert on "campus"."tbl_notenschluesseluebung" to group "admin";
Grant select on "campus"."tbl_notenschluesseluebung" to group "web";
Grant update on "campus"."tbl_notenschluesseluebung" to group "web";
Grant delete on "campus"."tbl_notenschluesseluebung" to group "web";
Grant insert on "campus"."tbl_notenschluesseluebung" to group "web";
Grant select on "public"."tbl_vorlage" to group "admin";
Grant update on "public"."tbl_vorlage" to group "admin";
Grant delete on "public"."tbl_vorlage" to group "admin";
Grant insert on "public"."tbl_vorlage" to group "admin";
Grant select on "public"."tbl_vorlage" to group "web";
Grant select on "public"."tbl_vorlagestudiengang" to group "admin";
Grant update on "public"."tbl_vorlagestudiengang" to group "admin";
Grant delete on "public"."tbl_vorlagestudiengang" to group "admin";
Grant insert on "public"."tbl_vorlagestudiengang" to group "admin";
Grant select on "public"."tbl_vorlagestudiengang" to group "web";
Grant select on "lehre"."tbl_betreuerart" to group "admin";
Grant update on "lehre"."tbl_betreuerart" to group "admin";
Grant delete on "lehre"."tbl_betreuerart" to group "admin";
Grant insert on "lehre"."tbl_betreuerart" to group "admin";
Grant select on "lehre"."tbl_betreuerart" to group "web";
Grant select on "public"."tbl_akte" to group "admin";
Grant update on "public"."tbl_akte" to group "admin";
Grant delete on "public"."tbl_akte" to group "admin";
Grant insert on "public"."tbl_akte" to group "admin";
Grant select on "public"."tbl_akte" to group "web";
Grant select on "public"."tbl_buchungstyp" to group "admin";
Grant update on "public"."tbl_buchungstyp" to group "admin";
Grant delete on "public"."tbl_buchungstyp" to group "admin";
Grant insert on "public"."tbl_buchungstyp" to group "admin";
Grant select on "public"."tbl_buchungstyp" to group "web";
Grant select on "campus"."tbl_resturlaub" to group "admin";
Grant update on "campus"."tbl_resturlaub" to group "admin";
Grant delete on "campus"."tbl_resturlaub" to group "admin";
Grant insert on "campus"."tbl_resturlaub" to group "admin";
Grant select on "campus"."tbl_resturlaub" to group "web";
Grant select on "sync"."tbl_zutrittskarte" to group "admin";
Grant update on "sync"."tbl_zutrittskarte" to group "admin";
Grant delete on "sync"."tbl_zutrittskarte" to group "admin";
Grant insert on "sync"."tbl_zutrittskarte" to group "admin";
Grant select on "sync"."tbl_zutrittskarte" to group "web";
Grant select on "bis"."tbl_orgform" to group "admin";
Grant update on "bis"."tbl_orgform" to group "admin";
Grant delete on "bis"."tbl_orgform" to group "admin";
Grant insert on "bis"."tbl_orgform" to group "admin";
Grant select on "bis"."tbl_orgform" to group "web";
Grant select on "testtool"."tbl_ablauf" to group "admin";
Grant update on "testtool"."tbl_ablauf" to group "admin";
Grant delete on "testtool"."tbl_ablauf" to group "admin";
Grant insert on "testtool"."tbl_ablauf" to group "admin";
Grant select on "testtool"."tbl_ablauf" to group "web";
Grant select on "testtool"."tbl_antwort" to group "admin";
Grant update on "testtool"."tbl_antwort" to group "admin";
Grant delete on "testtool"."tbl_antwort" to group "admin";
Grant insert on "testtool"."tbl_antwort" to group "admin";
Grant select on "testtool"."tbl_antwort" to group "web";
Grant update on "testtool"."tbl_antwort" to group "web";
Grant insert on "testtool"."tbl_antwort" to group "web";
Grant select on "testtool"."tbl_frage" to group "admin";
Grant update on "testtool"."tbl_frage" to group "admin";
Grant delete on "testtool"."tbl_frage" to group "admin";
Grant insert on "testtool"."tbl_frage" to group "admin";
Grant select on "testtool"."tbl_frage" to group "web";
Grant select on "testtool"."tbl_gebiet" to group "admin";
Grant update on "testtool"."tbl_gebiet" to group "admin";
Grant delete on "testtool"."tbl_gebiet" to group "admin";
Grant insert on "testtool"."tbl_gebiet" to group "admin";
Grant select on "testtool"."tbl_gebiet" to group "web";
Grant select on "testtool"."tbl_kategorie" to group "admin";
Grant update on "testtool"."tbl_kategorie" to group "admin";
Grant delete on "testtool"."tbl_kategorie" to group "admin";
Grant insert on "testtool"."tbl_kategorie" to group "admin";
Grant select on "testtool"."tbl_kategorie" to group "web";
Grant select on "testtool"."tbl_kriterien" to group "admin";
Grant update on "testtool"."tbl_kriterien" to group "admin";
Grant delete on "testtool"."tbl_kriterien" to group "admin";
Grant insert on "testtool"."tbl_kriterien" to group "admin";
Grant select on "testtool"."tbl_kriterien" to group "web";
Grant select on "testtool"."tbl_pruefling" to group "admin";
Grant update on "testtool"."tbl_pruefling" to group "admin";
Grant delete on "testtool"."tbl_pruefling" to group "admin";
Grant insert on "testtool"."tbl_pruefling" to group "admin";
Grant select on "testtool"."tbl_pruefling" to group "web";
Grant update on "testtool"."tbl_pruefling" to group "web";
Grant insert on "testtool"."tbl_pruefling" to group "web";
Grant select on "testtool"."tbl_vorschlag" to group "admin";
Grant update on "testtool"."tbl_vorschlag" to group "admin";
Grant delete on "testtool"."tbl_vorschlag" to group "admin";
Grant insert on "testtool"."tbl_vorschlag" to group "admin";
Grant select on "testtool"."tbl_vorschlag" to group "web";
Grant select on "testtool"."tbl_gruppe" to group "admin";
Grant update on "testtool"."tbl_gruppe" to group "admin";
Grant delete on "testtool"."tbl_gruppe" to group "admin";
Grant insert on "testtool"."tbl_gruppe" to group "admin";
Grant select on "testtool"."tbl_gruppe" to group "web";
Grant select on "campus"."tbl_zeitaufzeichnung" to group "admin";
Grant update on "campus"."tbl_zeitaufzeichnung" to group "admin";
Grant delete on "campus"."tbl_zeitaufzeichnung" to group "admin";
Grant insert on "campus"."tbl_zeitaufzeichnung" to group "admin";
Grant select on "campus"."tbl_zeitaufzeichnung" to group "web";
Grant update on "campus"."tbl_zeitaufzeichnung" to group "web";
Grant delete on "campus"."tbl_zeitaufzeichnung" to group "web";
Grant insert on "campus"."tbl_zeitaufzeichnung" to group "web";
Grant select on "fue"."tbl_projekt" to group "admin";
Grant update on "fue"."tbl_projekt" to group "admin";
Grant delete on "fue"."tbl_projekt" to group "admin";
Grant insert on "fue"."tbl_projekt" to group "admin";
Grant select on "fue"."tbl_projekt" to group "web";
Grant select on "fue"."tbl_aktivitaet" to group "admin";
Grant update on "fue"."tbl_aktivitaet" to group "admin";
Grant delete on "fue"."tbl_aktivitaet" to group "admin";
Grant insert on "fue"."tbl_aktivitaet" to group "admin";
Grant select on "fue"."tbl_aktivitaet" to group "web";
Grant select on "public"."tbl_personfunktionfirma" to group "admin";
Grant update on "public"."tbl_personfunktionfirma" to group "admin";
Grant delete on "public"."tbl_personfunktionfirma" to group "admin";
Grant insert on "public"."tbl_personfunktionfirma" to group "admin";
Grant select on "public"."tbl_personfunktionfirma" to group "web";
Grant select on "fue"."tbl_projektbenutzer" to group "admin";
Grant update on "fue"."tbl_projektbenutzer" to group "admin";
Grant delete on "fue"."tbl_projektbenutzer" to group "admin";
Grant insert on "fue"."tbl_projektbenutzer" to group "admin";
Grant select on "fue"."tbl_projektbenutzer" to group "web";
Grant select on "kommune"."tbl_team" to group "admin";
Grant update on "kommune"."tbl_team" to group "admin";
Grant delete on "kommune"."tbl_team" to group "admin";
Grant insert on "kommune"."tbl_team" to group "admin";
Grant select on "kommune"."tbl_team" to group "web";
Grant update on "kommune"."tbl_team" to group "web";
Grant delete on "kommune"."tbl_team" to group "web";
Grant insert on "kommune"."tbl_team" to group "web";
Grant select on "kommune"."tbl_teambenutzer" to group "admin";
Grant update on "kommune"."tbl_teambenutzer" to group "admin";
Grant delete on "kommune"."tbl_teambenutzer" to group "admin";
Grant insert on "kommune"."tbl_teambenutzer" to group "admin";
Grant select on "kommune"."tbl_teambenutzer" to group "web";
Grant update on "kommune"."tbl_teambenutzer" to group "web";
Grant delete on "kommune"."tbl_teambenutzer" to group "web";
Grant insert on "kommune"."tbl_teambenutzer" to group "web";
Grant select on "kommune"."tbl_wettbewerb" to group "admin";
Grant update on "kommune"."tbl_wettbewerb" to group "admin";
Grant delete on "kommune"."tbl_wettbewerb" to group "admin";
Grant insert on "kommune"."tbl_wettbewerb" to group "admin";
Grant select on "kommune"."tbl_wettbewerb" to group "web";
Grant select on "kommune"."tbl_wettbewerbteam" to group "admin";
Grant update on "kommune"."tbl_wettbewerbteam" to group "admin";
Grant delete on "kommune"."tbl_wettbewerbteam" to group "admin";
Grant insert on "kommune"."tbl_wettbewerbteam" to group "admin";
Grant select on "kommune"."tbl_wettbewerbteam" to group "web";
Grant update on "kommune"."tbl_wettbewerbteam" to group "web";
Grant delete on "kommune"."tbl_wettbewerbteam" to group "web";
Grant insert on "kommune"."tbl_wettbewerbteam" to group "web";
Grant select on "kommune"."tbl_match" to group "admin";
Grant update on "kommune"."tbl_match" to group "admin";
Grant delete on "kommune"."tbl_match" to group "admin";
Grant insert on "kommune"."tbl_match" to group "admin";
Grant select on "kommune"."tbl_match" to group "web";
Grant update on "kommune"."tbl_match" to group "web";
Grant delete on "kommune"."tbl_match" to group "web";
Grant insert on "kommune"."tbl_match" to group "web";

/* Groups permissions for views */
Grant select on campus.vw_benutzer to group "admin";
Grant select on campus.vw_benutzer to group "web";
Grant select on campus.vw_lehreinheit to group "admin";
Grant select on campus.vw_lehreinheit to group "web";
Grant select on campus.vw_mitarbeiter to group "admin";
Grant select on campus.vw_mitarbeiter to group "web";
Grant select on campus.vw_reservierung to group "admin";
Grant select on campus.vw_reservierung to group "web";
Grant select on campus.vw_stundenplan to group "admin";
Grant select on campus.vw_stundenplan to group "web";
Grant select on campus.vw_persongruppe to group "admin";
Grant select on campus.vw_persongruppe to group "web";
Grant select on campus.vw_student to group "admin";
Grant select on campus.vw_student to group "web";
Grant select on campus.vw_student_lehrveranstaltung to group "admin";
Grant select on campus.vw_student_lehrveranstaltung to group "web";
Grant select on lehre.vw_stundenplan to group "admin";
Grant select on lehre.vw_stundenplan to group "web";
Grant select on lehre.vw_stundenplandev to group "admin";
Grant select on lehre.vw_stundenplandev to group "web";
Grant select on lehre.vw_lva_stundenplan to group "admin";
Grant select on lehre.vw_lva_stundenplandev to group "admin";
Grant select on lehre.vw_reservierung to group "admin";
Grant select on lehre.vw_reservierung to group "web";
Grant select on lehre.vw_fas_lehrveranstaltung to group "admin";
Grant select on lehre.vw_fas_lehrveranstaltung to group "web";
Grant select on vw_betriebsmittelperson to group "admin";
Grant select on vw_betriebsmittelperson to group "web";
Grant select on testtool.vw_pruefling to group "admin";
Grant select on testtool.vw_pruefling to group "web";
Grant select on testtool.vw_gebiet to group "admin";
Grant select on testtool.vw_gebiet to group "web";
Grant select on testtool.vw_frage to group "admin";
Grant select on testtool.vw_frage to group "web";
Grant select on testtool.vw_antwort to group "admin";
Grant select on testtool.vw_antwort to group "web";
Grant select on testtool.vw_anz_antwort to group "admin";
Grant select on testtool.vw_anz_antwort to group "web";
Grant select on testtool.vw_anz_richtig to group "admin";
Grant select on testtool.vw_anz_richtig to group "web";
Grant select on testtool.vw_auswertung to group "admin";
Grant select on testtool.vw_auswertung to group "web";
Grant select on testtool.vw_auswertung_kategorie to group "admin";
Grant select on testtool.vw_auswertung_kategorie to group "web";
