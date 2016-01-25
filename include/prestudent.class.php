<?php
/* Copyright (C) 2007 fhcomplete.org
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
<<<<<<< HEAD
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>, 
=======
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at> and
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at>.
 */
require_once(dirname(__FILE__).'/person.class.php');

class prestudent extends person
{
	//Tabellenspalten
	public $prestudent_id;	// varchar(16)
	public $aufmerksamdurch_kurzbz;
	public $studiengang_kz;
	public $berufstaetigkeit_code;
	public $ausbildungcode;
	public $zgv_code;
	public $zgvort;
	public $zgvdatum;
<<<<<<< HEAD
	public $zgvmas_code;
	public $zgvmaort;
	public $zgvmadatum;
=======
	public $zgvnation;
	public $zgvmas_code;
	public $zgvmaort;
	public $zgvmadatum;
	public $zgvmanation;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	public $ausstellungsstaat;
	public $aufnahmeschluessel;
	public $facheinschlberuf;
	public $anmeldungreihungstest;
	public $reihungstestangetreten;
	public $reihungstest_id;
	public $punkte; //rt_gesamtpunkte
	public $rt_punkte1;
	public $rt_punkte2;
<<<<<<< HEAD
	public $rt_punkte3=0;
	public $bismelden=true;
	public $anmerkung;
	public $mentor;
	public $ext_id_prestudent;
	public $dual=false;
    public $zgvdoktor_code; 
    public $zgvdoktorort; 
    public $zgvdoktordatum; 
    
=======
    public $rt_punkte3 = 0;
    public $bismelden = true;
	public $anmerkung;
	public $anmerkung_status;
	public $mentor;
	public $ext_id_prestudent;
    public $dual = false;
    public $zgvdoktor_code;
    public $zgvdoktorort;
    public $zgvdoktordatum;
    public $zgvdoktornation;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	public $status_kurzbz;
	public $studiensemester_kurzbz;
	public $ausbildungssemester;
	public $datum;
	public $insertamum;
	public $insertvon;
	public $updateamum;
	public $updatevon;
	public $orgform_kurzbz;
	public $studienplan_id;
	public $studienplan_bezeichnung;
	public $bestaetigtam;
	public $bestaetigtvon;
<<<<<<< HEAD
	
	public $studiensemester_old='';
	public $ausbildungssemester_old='';
	
	// ErgebnisArray
	public $result=array();
	public $num_rows=0;
		
=======

    public $studiensemester_old = '';
    public $ausbildungssemester_old = '';

    // ErgebnisArray
    public $result = array();
    public $num_rows = 0;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor - Uebergibt die Connection und laedt optional einen Prestudent
	 * @param $prestudent_id Prestudent der geladen werden soll (default=null)
	 */
	public function __construct($prestudent_id=null)
	{
		parent::__construct();

		if($prestudent_id != null)
			$this->load($prestudent_id);
	}
<<<<<<< HEAD
	
	/**
	 * Laedt Prestudent mit der uebergebenen ID
	 * @param $uid ID der Person die geladen werden soll
=======

	/**
	 * Laedt Prestudent mit der uebergebenen ID
	 * @param $prestudent_id ID des Prestudenten der geladen werden soll
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 */
	public function load($prestudent_id)
	{
		if(!is_numeric($prestudent_id))
		{
			$this->errormsg = 'ID ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT * FROM public.tbl_prestudent WHERE prestudent_id=".$this->db_add_param($prestudent_id);
		
=======

		$qry = 'SELECT * '
				. 'FROM public.tbl_prestudent '
				. 'WHERE prestudent_id = '.$this->db_add_param($prestudent_id, FHC_INTEGER);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->prestudent_id = $row->prestudent_id;
				$this->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
				$this->studiengang_kz = $row->studiengang_kz;
				$this->berufstaetigkeit_code = $row->berufstaetigkeit_code;
				$this->ausbildungcode = $row->ausbildungcode;
				$this->zgv_code = $row->zgv_code;
				$this->zgvort = $row->zgvort;
				$this->zgvdatum = $row->zgvdatum;
<<<<<<< HEAD
				$this->zgvmas_code = $row->zgvmas_code;
				$this->zgvmaort = $row->zgvmaort;
				$this->zgvmadatum = $row->zgvmadatum;
				$this->aufnahmeschluessel = $row->aufnahmeschluessel;
=======
				$this->zgvnation = $row->zgvnation;
				$this->zgvmas_code = $row->zgvmas_code;
				$this->zgvmaort = $row->zgvmaort;
                $this->zgvmadatum = $row->zgvmadatum;
                $this->zgvmanation = $row->zgvmanation;
                $this->aufnahmeschluessel = $row->aufnahmeschluessel;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->facheinschlberuf = $this->db_parse_bool($row->facheinschlberuf);
				$this->anmeldungreihungstest = $row->anmeldungreihungstest;
				$this->reihungstestangetreten = $this->db_parse_bool($row->reihungstestangetreten);
				$this->reihungstest_id = $row->reihungstest_id;
				$this->punkte = $row->rt_gesamtpunkte;
				$this->rt_punkte1 = $row->rt_punkte1;
				$this->rt_punkte2 = $row->rt_punkte2;
				$this->rt_punkte3 = $row->rt_punkte3;
				$this->bismelden = $this->db_parse_bool($row->bismelden);
				$this->person_id = $row->person_id;
				$this->anmerkung = $row->anmerkung;
				$this->mentor = $row->mentor;
				$this->ext_id_prestudent = $row->ext_id;
				$this->dual = $this->db_parse_bool($row->dual);
				$this->ausstellungsstaat = $row->ausstellungsstaat;
<<<<<<< HEAD
                $this->zgvdoktor_code = $row->zgvdoktor_code; 
                $this->zgvdoktorort = $row->zgvdoktorort; 
                $this->zgvdoktordatum = $row->zgvdoktordatum; 
				
				if(!person::load($row->person_id))
					return false;
				else 
					return true;
			}
			else 
			{
				$this->errormsg = "Kein Prestudent Eintrag gefunden";
				return false;
			}				
		}
		else 
		{
			$this->errormsg = "Fehler beim Laden des Prestudenten";
			return false;
		}		
	}
	
	/**
	 * Prueft die Variablen vor dem Speichern 
=======
                $this->zgvdoktor_code = $row->zgvdoktor_code;
                $this->zgvdoktorort = $row->zgvdoktorort;
                $this->zgvdoktordatum = $row->zgvdoktordatum;
                $this->zgvdoktornation = $row->zgvdoktornation;

                if(!person::load($row->person_id))
					return false;
				else
					return true;
			}
			else
			{
				$this->errormsg = "Kein Prestudent Eintrag gefunden";
				return false;
			}
		}
		else
		{
			$this->errormsg = "Fehler beim Laden des Prestudenten";
			return false;
		}
	}

	/**
	 * Prueft die Variablen vor dem Speichern
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * auf Gueltigkeit.
	 * @return true wenn ok, false im Fehlerfall
	 */
	protected function validate()
	{
		if($this->punkte>9999.9999)
		{
			$this->errormsg = 'Reihungstestgesamtpunkte darf nicht groesser als 9999.9999 sein';
			return false;
		}
		if($this->rt_punkte1>9999.9999)
		{
			$this->errormsg = 'Reihungstestpunkte1 darf nicht groesser als 9999.9999 sein';
			return false;
		}
		if($this->rt_punkte2>9999.9999)
		{
			$this->errormsg = 'Reihungstestpunkte2 darf nicht groesser als 9999.9999 sein';
			return false;
		}
		if($this->rt_punkte3>9999.9999)
		{
			$this->errormsg = 'Reihungstestpunkte3 darf nicht groesser als 9999.9999 sein';
			return false;
		}

		return true;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Speichert die Benutzerdaten in die Datenbank
	 * Wenn $new auf true gesetzt ist wird ein neuer Datensatz angelegt
	 * ansonsten der Datensatz mit $uid upgedated
	 * @return true wenn erfolgreich, false im Fehlerfall
	 */
	public function save()
	{
		//Personen Datensatz speichern
		//if(!person::save())
		//	return false;
<<<<<<< HEAD
			
		//Variablen auf Gueltigkeit pruefen
		if(!prestudent::validate())
			return false;
		
		if($this->new) //Wenn new true ist dann ein INSERT absetzen ansonsten ein UPDATE
		{
			$qry = 'BEGIN;INSERT INTO public.tbl_prestudent (aufmerksamdurch_kurzbz, person_id, 
					studiengang_kz, berufstaetigkeit_code, ausbildungcode, zgv_code, zgvort, zgvdatum, 
					zgvmas_code, zgvmaort, zgvmadatum, aufnahmeschluessel, facheinschlberuf, 
					reihungstest_id, anmeldungreihungstest, reihungstestangetreten, rt_gesamtpunkte, 
					rt_punkte1, rt_punkte2, rt_punkte3, bismelden, insertamum, insertvon, 
					updateamum, updatevon, ext_id, anmerkung, dual, ausstellungsstaat, mentor) VALUES('.
=======

        $this->checkAusstellungsstaat();

		//Variablen auf Gueltigkeit pruefen
		if(!prestudent::validate())
			return false;

		if($this->new) //Wenn new true ist dann ein INSERT absetzen ansonsten ein UPDATE
		{
			$qry = 'BEGIN;INSERT INTO public.tbl_prestudent (aufmerksamdurch_kurzbz, person_id,
					studiengang_kz, berufstaetigkeit_code, ausbildungcode, zgv_code, zgvort, zgvdatum, zgvnation,
					zgvmas_code, zgvmaort, zgvmadatum, zgvmanation, aufnahmeschluessel, facheinschlberuf,
					reihungstest_id, anmeldungreihungstest, reihungstestangetreten, rt_gesamtpunkte,
					rt_punkte1, rt_punkte2, rt_punkte3, bismelden, insertamum, insertvon,
					updateamum, updatevon, anmerkung, dual, ausstellungsstaat, mentor) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       $this->db_add_param($this->aufmerksamdurch_kurzbz).",".
			       $this->db_add_param($this->person_id).",".
			       $this->db_add_param($this->studiengang_kz).",".
			       $this->db_add_param($this->berufstaetigkeit_code).",".
			       $this->db_add_param($this->ausbildungcode).",".
			       $this->db_add_param($this->zgv_code).",".
			       $this->db_add_param($this->zgvort).",".
			       $this->db_add_param($this->zgvdatum).",".
<<<<<<< HEAD
			       $this->db_add_param($this->zgvmas_code).",".
			       $this->db_add_param($this->zgvmaort).",".
			       $this->db_add_param($this->zgvmadatum).",".
=======
			       $this->db_add_param($this->zgvnation).",".
			       $this->db_add_param($this->zgvmas_code).",".
			       $this->db_add_param($this->zgvmaort).",".
			       $this->db_add_param($this->zgvmadatum).",".
                   $this->db_add_param($this->zgvmanation).",".
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       $this->db_add_param($this->aufnahmeschluessel).",".
			       $this->db_add_param($this->facheinschlberuf, FHC_BOOLEAN).",".
			       $this->db_add_param($this->reihungstest_id).",".
			       $this->db_add_param($this->anmeldungreihungstest).",".
			       $this->db_add_param($this->reihungstestangetreten, FHC_BOOLEAN).",".
			       $this->db_add_param($this->punkte).",".
			       $this->db_add_param($this->rt_punkte1).",".
			       $this->db_add_param($this->rt_punkte2).",".
			       $this->db_add_param($this->rt_punkte3).",".
			       $this->db_add_param($this->bismelden, FHC_BOOLEAN).",".
			       $this->db_add_param($this->insertamum).",".
			       $this->db_add_param($this->insertvon).",".
			       $this->db_add_param($this->updateamum).",".
			       $this->db_add_param($this->updatevon).",".
<<<<<<< HEAD
			       $this->db_add_param($this->ext_id_prestudent).",".
=======
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       $this->db_add_param($this->anmerkung).",".
			       $this->db_add_param($this->dual, FHC_BOOLEAN).",".
			       $this->db_add_param($this->ausstellungsstaat).",".
			       $this->db_add_param($this->mentor).");";
		}
		else
		{
			$qry = 'UPDATE public.tbl_prestudent SET'.
			       ' aufmerksamdurch_kurzbz='.$this->db_add_param($this->aufmerksamdurch_kurzbz).",".
			       ' person_id='.$this->db_add_param($this->person_id).",".
			       ' studiengang_kz='.$this->db_add_param($this->studiengang_kz).",".
			       ' berufstaetigkeit_code='.$this->db_add_param($this->berufstaetigkeit_code).",".
			       ' ausbildungcode='.$this->db_add_param($this->ausbildungcode).",".
			       ' zgv_code='.$this->db_add_param($this->zgv_code).",".
			       ' zgvort='.$this->db_add_param($this->zgvort).",".
			       ' zgvdatum='.$this->db_add_param($this->zgvdatum).",".
<<<<<<< HEAD
			       ' zgvmas_code='.$this->db_add_param($this->zgvmas_code).",".
			       ' zgvmaort='.$this->db_add_param($this->zgvmaort).",".
			       ' zgvmadatum='.$this->db_add_param($this->zgvmadatum).",".
=======
			       ' zgvnation='.$this->db_add_param($this->zgvnation).",".
			       ' zgvmas_code='.$this->db_add_param($this->zgvmas_code).",".
			       ' zgvmaort='.$this->db_add_param($this->zgvmaort).",".
			       ' zgvmadatum='.$this->db_add_param($this->zgvmadatum).",".
			       ' zgvmanation='.$this->db_add_param($this->zgvmanation).",".
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       ' aufnahmeschluessel='.$this->db_add_param($this->aufnahmeschluessel).",".
			       ' facheinschlberuf='.$this->db_add_param($this->facheinschlberuf, FHC_BOOLEAN).",".
			       ' reihungstest_id='.$this->db_add_param($this->reihungstest_id).",".
			       ' anmeldungreihungstest='.$this->db_add_param($this->anmeldungreihungstest).",".
			       ' reihungstestangetreten='.$this->db_add_param($this->reihungstestangetreten, FHC_BOOLEAN).",".
			       ' rt_gesamtpunkte='.$this->db_add_param($this->punkte).",".
			       ' rt_punkte1='.$this->db_add_param($this->rt_punkte1).",".
			       ' rt_punkte2='.$this->db_add_param($this->rt_punkte2).",".
			       ' rt_punkte3='.$this->db_add_param($this->rt_punkte3).",".
			       ' bismelden='.$this->db_add_param($this->bismelden, FHC_BOOLEAN).",".
			       ' updateamum='.$this->db_add_param($this->updateamum).",".
			       ' updatevon='.$this->db_add_param($this->updatevon).",".
<<<<<<< HEAD
			       ' ext_id='.$this->db_add_param($this->ext_id_prestudent).",".
=======
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       ' anmerkung='.$this->db_add_param($this->anmerkung).",".
			       ' mentor='.$this->db_add_param($this->mentor).",".
			       ' dual='.$this->db_add_param($this->dual, FHC_BOOLEAN).",".
				   ' ausstellungsstaat='.$this->db_add_param($this->ausstellungsstaat).
			       " WHERE prestudent_id=".$this->db_add_param($this->prestudent_id).";";
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($this->new)
			{
				$qry = "SELECT currval('public.tbl_prestudent_prestudent_id_seq') as id;";
				if($this->db_query($qry))
				{
					if($row = $this->db_fetch_object())
					{
						$this->prestudent_id = $row->id;
						$this->db_query('COMMIT;');
						return true;
					}
<<<<<<< HEAD
					else 
=======
					else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					{
						$this->errormsg = 'Fehler beim Auslesen der Sequence';
						$this->db_query('ROLLBACK;');
						return false;
<<<<<<< HEAD
					}						
				}
				else 
=======
					}
				}
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					$this->errormsg = 'Fehler beim Auslesen der Sequence';
					$this->db_query('ROLLBACK;');
					return false;
				}
			}
			//Log schreiben
			return true;
		}
<<<<<<< HEAD
		else 
		{	
=======
		else
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$this->errormsg = 'Fehler beim Speichern des Prestudent-Datensatzes';
			return false;
		}
	}

<<<<<<< HEAD
	/**
	 * Laden aller Prestudenten, die an $datum zum Reihungstest geladen sind.
	 * Wenn $equal auf true gesetzt ist wird genau dieses Datum verwendet,
	 * ansonsten werden auch alle mit späterem Datum geladen. ---> von kindlm am 30.03.2012 geändert 
	 * da zukünftige Teilnehmer nicht mehr angezeigt werden sollen. 
=======
    /**
     * Falls ZGV vorhanden, setze Ausstellungsstaat (für BIS-Meldung)
     * auf Nation der höchsten angegebenen ZGV
     */
    private function checkAusstellungsstaat()
    {

        if ($this->zgvmas_code && $this->zgvmanation) {

            $this->ausstellungsstaat = $this->zgvmanation;

        } elseif ($this->zgv_code && $this->zgvnation) {

            $this->ausstellungsstaat = $this->zgvnation;

        }

    }

	/**
	 * Laden aller Prestudenten, die an $datum zum Reihungstest geladen sind.
	 * Wenn $equal auf true gesetzt ist wird genau dieses Datum verwendet,
	 * ansonsten werden auch alle mit späterem Datum geladen. ---> von kindlm am 30.03.2012 geändert
	 * da zukünftige Teilnehmer nicht mehr angezeigt werden sollen.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * @return true wenn erfolgreich, false im Fehlerfall
	 */
	public function getPrestudentRT($datum, $equal=false)
	{
		$sql_query='SELECT DISTINCT * FROM public.vw_prestudent WHERE rt_datum';
		if ($equal)
			$sql_query.='=';
		else
			$sql_query.='=';
		$sql_query.="'$datum' ORDER BY nachname,vorname";
<<<<<<< HEAD
		
		if(!$this->db_query($sql_query))
		{	
			$this->errormsg = 'Fehler beim Speichern des Benutzer-Datensatzes:'.$sql_query;
			return false;
		}
		
		$this->num_rows=0;
		
=======

		if(!$this->db_query($sql_query))
		{
			$this->errormsg = 'Fehler beim Speichern des Benutzer-Datensatzes:'.$sql_query;
			return false;
		}

		$this->num_rows=0;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		while($row = $this->db_fetch_object())
		{
			$ps=new prestudent();
			$ps->prestudent_id = $row->prestudent_id;
			$ps->person_id = $row->person_id;
			$ps->reihungstest_id = $row->reihungstest_id;
			$ps->staatsbuergerschaft = $row->staatsbuergerschaft;
			$ps->geburtsnation = $row->geburtsnation;
			$ps->sprache = $row->sprache;
			$ps->anrede = $row->anrede;
			$ps->titelpost = $row->titelpost;
			$ps->titelpre = $row->titelpre;
			$ps->nachname = $row->nachname;
			$ps->vorname = $row->vorname;
			$ps->vornamen = $row->vornamen;
			$ps->gebdatum = $row->gebdatum;
			$ps->gebort = $row->gebort;
			$ps->gebzeit = $row->gebzeit;
			// $ps->foto = $row->foto;
			$ps->anmerkungen = $row->anmerkungen;
			$ps->homepage = $row->homepage;
			$ps->svnr = $row->svnr;
			$ps->ersatzkennzeichen = $row->ersatzkennzeichen;
			$ps->familienstand = $row->familienstand;
			$ps->geschlecht = $row->geschlecht;
			$ps->anzahlkinder = $row->anzahlkinder;
			$ps->aktiv = $this->db_parse_bool($row->aktiv);
			$ps->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
			$ps->studiengang_kz = $row->studiengang_kz;
			$ps->berufstaetigkeit_code = $row->berufstaetigkeit_code;
			$ps->ausbildungcode = $row->ausbildungcode;
			$ps->zgv_code = $row->zgv_code;
			$ps->zgvort = $row->zgvort;
			$ps->zgvdatum = $row->zgvdatum;
<<<<<<< HEAD
			$ps->zgvmas_code = $row->zgvmas_code;
			$ps->zgvmaort = $row->zgvmaort;
			$ps->zgvmadatum = $row->zgvmadatum;
=======
			//$ps->zgvnation = $row->zgvnation;
			$ps->zgvmas_code = $row->zgvmas_code;
			$ps->zgvmaort = $row->zgvmaort;
			$ps->zgvmadatum = $row->zgvmadatum;
			//$ps->zgvmanation = $row->zgvmanation;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$ps->aufnahmeschluessel = $row->aufnahmeschluessel;
			$ps->facheinschlberuf = $this->db_parse_bool($row->facheinschlberuf);
			$ps->anmeldungreihungstest = $row->anmeldungreihungstest;
			$ps->reihungstestangetreten = $this->db_parse_bool($row->reihungstestangetreten);
			$ps->punkte = $row->punkte;
			$ps->rt_punkte1 = $row->rt_punkte1;
			$ps->rt_punkte2 = $row->rt_punkte2;
			$ps->bismelden = $this->db_parse_bool($row->bismelden);
			$ps->rt_studiengang_kz = $row->rt_studiengang_kz;
			$ps->rt_ort = $row->rt_ort;
			$ps->rt_datum = $row->rt_datum;
			$ps->rt_uhrzeit = $row->rt_uhrzeit;
			$ps->updateamum = $row->updateamum;
			$ps->updatevon = $row->updatevon;
			$ps->insertamum = $row->insertamum;
			$ps->insertvon = $row->insertvon;
			//$ps->ext_id_prestudent = $row->ext_id_prestudent;
			$this->result[]=$ps;
<<<<<<< HEAD
			$this->num_rows++; 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
		}
		return true;		
	}
	
=======
			$this->num_rows++;
		}
		return true;
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt die Rolle(n) eines Prestudenten
	 */
	public function getPrestudentRolle($prestudent_id, $status_kurzbz=null, $studiensemester_kurzbz=null, $order="datum, insertamum", $ausbildungssemester=null)
	{
		if(!is_numeric($prestudent_id))
		{
			$this->errormsg = 'Prestudent_id muss eine gueltige Zahl sein';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT 
					tbl_prestudentstatus.*, tbl_studienplan.bezeichnung as studienplan_bezeichnung
				FROM public.tbl_prestudentstatus 
					LEFT JOIN lehre.tbl_studienplan USING(studienplan_id)
				WHERE 
					prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER);	
=======

		$qry = "SELECT
					tbl_prestudentstatus.*, tbl_studienplan.bezeichnung as studienplan_bezeichnung
				FROM public.tbl_prestudentstatus
					LEFT JOIN lehre.tbl_studienplan USING(studienplan_id)
				WHERE
					prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($status_kurzbz!=null)
			$qry.= " AND status_kurzbz=".$this->db_add_param($status_kurzbz);
		if($studiensemester_kurzbz!=null)
			$qry.= " AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
		if($ausbildungssemester!=null)
			$qry.= " AND ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($order!='')
			$qry.=" ORDER BY ".$order;
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$rolle = new prestudent();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$rolle->prestudent_id = $row->prestudent_id;
				$rolle->status_kurzbz = $row->status_kurzbz;
				$rolle->studiensemester_kurzbz = $row->studiensemester_kurzbz;
				$rolle->ausbildungssemester = $row->ausbildungssemester;
				$rolle->datum = $row->datum;
				$rolle->insertamum = $row->insertamum;
				$rolle->insertvon = $row->insertvon;
				$rolle->updateamum = $row->updateamum;
				$rolle->updatevon = $row->updatevon;
				$rolle->orgform_kurzbz = $row->orgform_kurzbz;
				$rolle->studienplan_id = $row->studienplan_id;
				$rolle->studienplan_bezeichnung = $row->studienplan_bezeichnung;
				$rolle->bestaetigtam = $row->bestaetigtam;
				$rolle->bestaetigtvon = $row->bestaetigtvon;
<<<<<<< HEAD
=======
				$rolle->anmerkung_status = $row->anmerkung;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $rolle;
			}
			return true;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der PrestudentDaten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt die Rolle
	 *
	 * @param $prestudent_id
	 * @param $status_kurzbz
	 * @param $studiensemester_kurzbz
	 * @param $ausbildungssemester
	 * @return boolean
	 */
	public function load_rolle($prestudent_id, $status_kurzbz, $studiensemester_kurzbz, $ausbildungssemester)
	{
		if(!is_numeric($prestudent_id) || $prestudent_id=='')
		{
			$this->errormsg = 'Prestudent_id muss eine gueltige Zahl sein';
			return false;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$qry = "SELECT * FROM public.tbl_prestudentstatus WHERE prestudent_id=".$this->db_add_param($prestudent_id).
			   " AND status_kurzbz=".$this->db_add_param($status_kurzbz).
			   " AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz).
			   " AND ausbildungssemester=".$this->db_add_param($ausbildungssemester);
<<<<<<< HEAD
		
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{								
=======

		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->prestudent_id = $row->prestudent_id;
				$this->status_kurzbz = $row->status_kurzbz;
				$this->studiensemester_kurzbz = $row->studiensemester_kurzbz;
				$this->ausbildungssemester = $row->ausbildungssemester;
				$this->datum = $row->datum;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->ext_id_prestudent = $row->ext_id;
				$this->orgform_kurzbz = $row->orgform_kurzbz;
				$this->studienplan_id = $row->studienplan_id;
				$this->bestaetigtam = $row->bestaetigtam;
				$this->bestaetigtvon = $row->bestaetigtvon;
<<<<<<< HEAD

				return true;
			}
			else 
=======
				$this->anmerkung_status = $row->anmerkung;

				return true;
			}
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg = 'Rolle existiert nicht';
				return false;
			}
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der PrestudentDaten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt die Interessenten und Bewerber fuer ein bestimmtes Studiensemester
	 * @param $studiensemester_kurzbz Studiensemester fuer das die Int. und Bewerber
	 *                                geladen werden sollen
	 */
	public function loadIntessentenUndBewerber($studiensemester_kurzbz, $studiengang_kz, $semester=null, $typ=null, $orgform=null)
	{
		$stsemqry='';
		if(!is_null($studiensemester_kurzbz) && $studiensemester_kurzbz!='')
			$stsemqry=" AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
<<<<<<< HEAD
		
		$qry = "SELECT 
					*, a.anmerkung, tbl_person.anmerkung as anmerkungen 
				FROM 
					(
						SELECT 
							*, (SELECT status_kurzbz FROM tbl_prestudentstatus 
							    WHERE prestudent_id=prestudent.prestudent_id $stsemqry
							    ORDER BY datum DESC, insertamum DESC, ext_id DESC LIMIT 1) AS rolle 
						FROM tbl_prestudent prestudent ORDER BY prestudent_id
					) a, tbl_prestudentstatus, tbl_person
				WHERE a.rolle=tbl_prestudentstatus.status_kurzbz AND 
					a.person_id=tbl_person.person_id AND
					a.prestudent_id = tbl_prestudentstatus.prestudent_id AND
					a.studiengang_kz=".$this->db_add_param($studiengang_kz);
						
		if(!is_null($studiensemester_kurzbz) && $studiensemester_kurzbz!='')
			$qry.=" AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
			
=======

		$qry = "SELECT
					*, a.anmerkung, tbl_person.anmerkung as anmerkungen
				FROM
					(
						SELECT
							*, (SELECT status_kurzbz FROM tbl_prestudentstatus
							    WHERE prestudent_id=prestudent.prestudent_id $stsemqry
							    ORDER BY datum DESC, insertamum DESC, ext_id DESC LIMIT 1) AS rolle
						FROM tbl_prestudent prestudent ORDER BY prestudent_id
					) a, tbl_prestudentstatus, tbl_person
				WHERE a.rolle=tbl_prestudentstatus.status_kurzbz AND
					a.person_id=tbl_person.person_id AND
					a.prestudent_id = tbl_prestudentstatus.prestudent_id AND
					a.studiengang_kz=".$this->db_add_param($studiengang_kz);

		if(!is_null($studiensemester_kurzbz) && $studiensemester_kurzbz!='')
			$qry.=" AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($semester!=null)
			$qry.=" AND ausbildungssemester=".$this->db_add_param($semester);
		if($orgform!=null && $orgform!='')
			$qry.=" AND tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform);
<<<<<<< HEAD
		
		switch ($typ)
		{
			case "interessenten": 	
				$qry.=" AND a.rolle='Interessent'";
				break;
			case "zgv":	
=======

		switch ($typ)
		{
			case "interessenten":
				$qry.=" AND a.rolle='Interessent'";
				break;
			case "zgv":
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$stg_obj = new studiengang();
				$stg_obj->load($studiengang_kz);
				if($stg_obj->typ=='m')
					$qry.=" AND a.rolle='Interessent' AND a.zgvmas_code is not null";
				else
					$qry.=" AND a.rolle='Interessent' AND a.zgv_code is not null";
				break;
<<<<<<< HEAD
			case "reihungstestangemeldet":  
=======
			case "reihungstestangemeldet":
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$qry.=" AND a.rolle='Interessent' AND a.anmeldungreihungstest is not null";
				break;
			case "reihungstestnichtangemeldet":
				$qry.=" AND a.rolle='Interessent' AND a.anmeldungreihungstest is null";
				break;
			case "bewerber":
				$qry.=" AND a.rolle='Bewerber'";
				break;
			case "aufgenommen":
				$qry.=" AND a.rolle='Aufgenommener'";
				break;
			case "warteliste":
				$qry.=" AND a.rolle='Wartender'";
				break;
			case "absage":
				$qry.=" AND a.rolle='Abgewiesener'";
				break;
			case "prestudent":
				if($studiensemester_kurzbz=='' || is_null($studiensemester_kurzbz))
					$qry = "SELECT *, '' as status_kurzbz, '' as studiensemester_kurzbz, '' as ausbildungssemester, '' as datum, tbl_person.anmerkung as anmerkungen, '' as orgform_kurzbz FROM public.tbl_prestudent prestudent, public.tbl_person WHERE NOT EXISTS (select * from tbl_prestudentstatus WHERE prestudent_id=prestudent.prestudent_id) AND studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER)." AND prestudent.person_id=tbl_person.person_id";
<<<<<<< HEAD
				else 
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					$qry .= " AND a.rolle IN('Interessent', 'Bewerber', 'Aufgenommener', 'Wartender', 'Abgewiesener')";
				break;
			case "absolvent":
				$qry.=" AND a.rolle='Absolvent'";
				break;
			case "diplomand":
				$qry.=" AND a.rolle='Diplomand'";
				break;
<<<<<<< HEAD
			default: 
				break;		
=======
			default:
				break;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}

		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$ps = new prestudent();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$ps->person_id = $row->person_id;
				$ps->staatsbuergerschaft = $row->staatsbuergerschaft;
				$ps->gebnation = $row->geburtsnation;
				$ps->sprache = $row->sprache;
				$ps->anrede = $row->anrede;
				$ps->titelpost = $row->titelpost;
				$ps->titelpre = $row->titelpre;
				$ps->nachname = $row->nachname;
				$ps->vorname = $row->vorname;
				$ps->vornamen = $row->vornamen;
				$ps->gebdatum = $row->gebdatum;
				$ps->gebort = $row->gebort;
				$ps->gebzeit = $row->gebzeit;
				//$ps->foto = $row->foto;
				$ps->anmerkungen = $row->anmerkungen;
				$ps->homepage = $row->homepage;
				$ps->svnr = $row->svnr;
				$ps->ersatzkennzeichen = $row->ersatzkennzeichen;
				$ps->familienstand = $row->familienstand;
				$ps->geschlecht = $row->geschlecht;
				$ps->anzahlkinder = $row->anzahlkinder;
				$ps->aktiv = $this->db_parse_bool($row->aktiv);
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$ps->prestudent_id = $row->prestudent_id;
				$ps->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
				$ps->studiengang_kz = $row->studiengang_kz;
				$ps->berufstaetigkeit_code = $row->berufstaetigkeit_code;
				$ps->ausbildungcode = $row->ausbildungcode;
				$ps->zgv_code = $row->zgv_code;
				$ps->zgvort = $row->zgvort;
				$ps->zgvdatum = $row->zgvdatum;
<<<<<<< HEAD
				$ps->zgvmas_code = $row->zgvmas_code;
				$ps->zgvmaort = $row->zgvmaort;
				$ps->zgvmadatum = $row->zgvmadatum;
=======
				$ps->zgvnation = $row->zgvnation;
				$ps->zgvmas_code = $row->zgvmas_code;
				$ps->zgvmaort = $row->zgvmaort;
				$ps->zgvmadatum = $row->zgvmadatum;
				$ps->zgvmanation = $row->zgvmanation;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$ps->ausstellungsstaat = $row->ausstellungsstaat;
				$ps->aufnahmeschluessel = $row->aufnahmeschluessel;
				$ps->facheinschlberuf = $this->db_parse_bool($row->facheinschlberuf);
				$ps->anmeldungreihungstest = $row->anmeldungreihungstest;
				$ps->reihungstestangetreten = $this->db_parse_bool($row->reihungstestangetreten);
				$ps->reihungstest_id = $row->reihungstest_id;
				$ps->punkte = $row->rt_gesamtpunkte;
				$ps->rt_punkte1 = $row->rt_punkte1;
				$ps->rt_punkte2 = $row->rt_punkte2;
				$ps->rt_punkte3 = $row->rt_punkte3;
				$ps->bismelden = $this->db_parse_bool($row->bismelden);
				$ps->anmerkung = $row->anmerkung;
				$ps->dual = $this->db_parse_bool($row->dual);
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$ps->status_kurzbz = $row->status_kurzbz;
				$ps->studiensemester_kurzbz = $row->studiensemester_kurzbz;
				$ps->ausbildungssemester = $row->ausbildungssemester;
				$ps->datum = $row->datum;
				$ps->orgform_kurzbz = $row->orgform_kurzbz;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $ps;
			}
			return true;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Prueft ob eine Person bereits einen PreStudenteintrag
	 * fuer einen Studiengang besitzt
	 * @param person_id
	 *        studiengang_kz
	 * @return true wenn vorhanden
	 *		 false wenn nicht vorhanden
	 *		 false und errormsg wenn Fehler aufgetreten ist
	 */
	public function exists($person_id, $studiengang_kz)
	{
		if(!is_numeric($person_id))
		{
			$this->errormsg = 'Person_id muss eine gueltige Zahl sein';
			return false;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(!is_numeric($studiengang_kz))
		{
			$this->errormsg = 'Studiengang_kz muss eine gueltige Zahl sein';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT count(*) as anzahl FROM public.tbl_prestudent 
				WHERE person_id=".$this->db_add_param($person_id, FHC_INTEGER)." 
=======

		$qry = "SELECT count(*) as anzahl FROM public.tbl_prestudent
				WHERE person_id=".$this->db_add_param($person_id, FHC_INTEGER)."
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				AND studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
<<<<<<< HEAD
			{	
=======
			{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				if($row->anzahl>0)
				{
					$this->errormsg = '';
					return true;
				}
<<<<<<< HEAD
				else 	
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					$this->errormsg = '';
					return false;
				}
			}
<<<<<<< HEAD
			else 
=======
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Speichert den Prestudentstatus
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save_rolle()
	{
		if($this->new)
		{
			//pruefen ob die Rolle schon vorhanden ist
			if($this->load_rolle($this->prestudent_id, $this->status_kurzbz, $this->studiensemester_kurzbz, $this->ausbildungssemester))
			{
				$this->errormsg = 'Diese Rolle existiert bereits';
				return false;
			}

<<<<<<< HEAD
			$qry = 'INSERT INTO public.tbl_prestudentstatus (prestudent_id, status_kurzbz, 
					studiensemester_kurzbz, ausbildungssemester, datum, insertamum, insertvon, 
					updateamum, updatevon, ext_id, orgform_kurzbz, bestaetigtam, bestaetigtvon, studienplan_id) VALUES('.
=======
			$qry = 'INSERT INTO public.tbl_prestudentstatus (prestudent_id, status_kurzbz,
					studiensemester_kurzbz, ausbildungssemester, datum, insertamum, insertvon,
					updateamum, updatevon, ext_id, orgform_kurzbz, bestaetigtam, bestaetigtvon, anmerkung,
					studienplan_id) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			       $this->db_add_param($this->prestudent_id).",".
			       $this->db_add_param($this->status_kurzbz).",".
			       $this->db_add_param($this->studiensemester_kurzbz).",".
			       $this->db_add_param($this->ausbildungssemester).",".
			       $this->db_add_param($this->datum).",".
			       $this->db_add_param($this->insertamum).",".
			       $this->db_add_param($this->insertvon).",".
			       $this->db_add_param($this->updateamum).",".
			       $this->db_add_param($this->updatevon).",".
			       $this->db_add_param($this->ext_id_prestudent).",".
			       $this->db_add_param($this->orgform_kurzbz).",".
			       $this->db_add_param($this->bestaetigtam).",".
			       $this->db_add_param($this->bestaetigtvon).",".
<<<<<<< HEAD
				   $this->db_add_param($this->studienplan_id,FHC_INTEGER).");";
		}
		else
		{			
			if($this->studiensemester_old=='') 
				$this->studiensemester_old = $this->studiensemester_kurzbz;
			if($this->ausbildungssemester_old=='')
				$this->ausbildungssemester_old = $this->ausbildungssemester;
			
=======
			       $this->db_add_param($this->anmerkung_status).",".
				   $this->db_add_param($this->studienplan_id,FHC_INTEGER).");";
		}
		else
		{
			if($this->studiensemester_old=='')
				$this->studiensemester_old = $this->studiensemester_kurzbz;
			if($this->ausbildungssemester_old=='')
				$this->ausbildungssemester_old = $this->ausbildungssemester;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			//wenn der PrimaryKey geaendert wird, schauen ob schon ein Eintrag mit diesem Key vorhanden ist
			if($this->studiensemester_old!=$this->studiensemester_kurzbz || $this->ausbildungssemester_old!=$this->ausbildungssemester)
			{
				if($this->load_rolle($this->prestudent_id, $this->status_kurzbz, $this->studiensemester_kurzbz, $this->ausbildungssemester))
				{
					$this->errormsg = 'Diese Rolle existiert bereits';
					return false;
				}
			}
			$qry = 'UPDATE public.tbl_prestudentstatus SET'.
			       ' ausbildungssemester='.$this->db_add_param($this->ausbildungssemester).",".
			       ' studiensemester_kurzbz='.$this->db_add_param($this->studiensemester_kurzbz).",".
			       ' datum='.$this->db_add_param($this->datum).",".
			       ' updateamum='.$this->db_add_param($this->updateamum).",".
			       ' updatevon='.$this->db_add_param($this->updatevon).",".
			       ' bestaetigtam='.$this->db_add_param($this->bestaetigtam).",".
			       ' bestaetigtvon='.$this->db_add_param($this->bestaetigtvon).",".
				   ' studienplan_id='.$this->db_add_param($this->studienplan_id, FHC_INTEGER).",".
<<<<<<< HEAD
			       ' orgform_kurzbz='.$this->db_add_param($this->orgform_kurzbz).
			       " WHERE 
						prestudent_id=".$this->db_add_param($this->prestudent_id, FHC_INTEGER, false)." 
=======
				   ' anmerkung='.$this->db_add_param($this->anmerkung_status).",".
			       ' orgform_kurzbz='.$this->db_add_param($this->orgform_kurzbz).
			       " WHERE
						prestudent_id=".$this->db_add_param($this->prestudent_id, FHC_INTEGER, false)."
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
						AND status_kurzbz=".$this->db_add_param($this->status_kurzbz, FHC_STRING, false)."
						AND studiensemester_kurzbz=".$this->db_add_param($this->studiensemester_old, FHC_STRING, false)."
						AND ausbildungssemester=".$this->db_add_param($this->ausbildungssemester_old, FHC_STRING, false).";";
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			//Log schreiben
			return true;
		}
<<<<<<< HEAD
		else 
		{	
=======
		else
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$this->errormsg = 'Fehler beim Speichern des Prestudentstatus';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Loescht einen Prestudentstatus
	 * @param $prestudent_id
	 *        $status_kurzbz
	 *        $studiensemester_kurzbz
	 *		  $ausbildungssemester
	 * @return true wenn ok, false wenn Fehler
	 */
	public function delete_rolle($prestudent_id, $status_kurzbz, $studiensemester_kurzbz, $ausbildungssemester)
	{
		if(!is_numeric($prestudent_id))
		{
			$this->errormsg = 'Prestudent_id ist ungueltig';
			return false;
		}

<<<<<<< HEAD
		$qry = "DELETE FROM public.tbl_prestudentstatus 
				WHERE 
=======
		$qry = "DELETE FROM public.tbl_prestudentstatus
				WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER)."
					AND status_kurzbz=".$this->db_add_param($status_kurzbz)."
					AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz)."
					AND ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($this->load_rolle($prestudent_id, $status_kurzbz, $studiensemester_kurzbz, $ausbildungssemester))
		{
			$this->db_query('BEGIN;');
<<<<<<< HEAD
			
			$log = new log();
			
=======

			$log = new log();

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$log->executetime = date('Y-m-d H:i:s');
			$log->beschreibung = 'Loeschen der Rolle '.$status_kurzbz.' bei '.$prestudent_id;
			$log->mitarbeiter_uid = get_uid();
			$log->sql = $qry;
<<<<<<< HEAD
			$log->sqlundo = 'INSERT INTO public.tbl_prestudentstatus(prestudent_id, status_kurzbz, studiensemester_kurzbz,'.
							' ausbildungssemester, datum, insertamum, insertvon, updateamum, updatevon, ext_id, orgform_kurzbz, bestaetigtam, bestaetigtvon, studienplan_id) VALUES('.
=======
			$log->sqlundo = 'INSERT INTO public.tbl_prestudentstatus(prestudent_id, status_kurzbz, studiensemester_kurzbz,'
							. ' ausbildungssemester, datum, insertamum, insertvon, updateamum, updatevon, ext_id, orgform_kurzbz,'
							. ' bestaetigtam, bestaetigtvon, anmerkung, studienplan_id) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
							$this->db_add_param($this->prestudent_id).','.
							$this->db_add_param($this->status_kurzbz).','.
							$this->db_add_param($this->studiensemester_kurzbz).','.
							$this->db_add_param($this->ausbildungssemester).','.
							$this->db_add_param($this->datum).','.
							$this->db_add_param($this->insertamum).','.
							$this->db_add_param($this->insertvon).','.
							$this->db_add_param($this->updateamum).','.
							$this->db_add_param($this->updatevon).','.
							$this->db_add_param($this->ext_id_prestudent).','.
							$this->db_add_param($this->orgform_kurzbz).','.
							$this->db_add_param($this->bestaetigtam).','.
							$this->db_add_param($this->bestaetigtvon).','.
<<<<<<< HEAD
							$this->db_add_param($this->studienplan_id, FHC_INTEGER).');';
			if($log->save(true))
			{
						
=======
							$this->db_add_param($this->anmerkung_status).','.
							$this->db_add_param($this->studienplan_id, FHC_INTEGER).');';
			if($log->save(true))
			{

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				if($this->db_query($qry))
				{
					$this->db_query('COMMIT');
					return true;
				}
<<<<<<< HEAD
				else 
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					$this->db_query('ROLLBACK');
					$this->errormsg = 'Fehler beim Loeschen der Daten';
					return false;
				}
			}
<<<<<<< HEAD
			else 
=======
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->db_query('ROLLBACK');
				$this->errormsg = 'Fehler beim Speichern des Log-Eintrages';
				return false;
			}
		}
<<<<<<< HEAD
		else 
		{
			return false;
		}			
	}
	
=======
		else
		{
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	public function bestaetige_rolle($prestudent_id, $status_kurzbz, $studiensemester_kurzbz, $ausbildungssemester, $user)
	{
		if(!is_numeric($prestudent_id))
		{
			$this->errormsg = 'Prestudent_id ist ungueltig';
			return false;
		}

	$qry = 'UPDATE public.tbl_prestudentstatus SET'.
				' bestaetigtam='.$this->db_add_param(date('Y-m-d')).','.
				' bestaetigtvon='.$this->db_add_param($user)." ".
<<<<<<< HEAD
				' WHERE 
=======
				' WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					prestudent_id='.$this->db_add_param($prestudent_id, FHC_INTEGER).'
					AND status_kurzbz='.$this->db_add_param($status_kurzbz).'
					AND studiensemester_kurzbz='.$this->db_add_param($studiensemester_kurzbz).'
					AND ausbildungssemester='.$this->db_add_param($ausbildungssemester);
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			return true;
		}
		else
		{
			$this->errormsg='Fehler beim Speichern der Daten';
			return false;
		}
	}

	/**
	 * Liefert den Letzten Status eines Prestudenten in einem Studiensemester
	 * Wenn kein Studiensemester angegeben wird, wird der letztgueltige Status ermittelt
	 * @param $prestudent_id
	 * @param $studiensemester_kurzbz
	 * @return boolean
	 */
	public function getLastStatus($prestudent_id, $studiensemester_kurzbz='', $status_kurzbz = '')
	{
		if($prestudent_id=='' || !is_numeric($prestudent_id))
		{
			$this->errormsg = 'Prestudent_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT tbl_prestudentstatus.*, bezeichnung AS studienplan_bezeichnung 
=======

		$qry = "SELECT tbl_prestudentstatus.*, bezeichnung AS studienplan_bezeichnung
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			FROM public.tbl_prestudentstatus LEFT JOIN lehre.tbl_studienplan USING (studienplan_id)
			 WHERE prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER);

		if($studiensemester_kurzbz!='')
			$qry.=" AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);
<<<<<<< HEAD
		
		if($status_kurzbz !='')
			$qry.= " AND status_kurzbz =".$this->db_add_param($status_kurzbz);
		
=======

		if($status_kurzbz !='')
			$qry.= " AND status_kurzbz =".$this->db_add_param($status_kurzbz);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$qry.=" ORDER BY datum DESC, insertamum DESC, ext_id DESC LIMIT 1";
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
<<<<<<< HEAD
			{				
=======
			{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->prestudent_id = $row->prestudent_id;
				$this->status_kurzbz = $row->status_kurzbz;
				$this->studiensemester_kurzbz = $row->studiensemester_kurzbz;
				$this->ausbildungssemester = $row->ausbildungssemester;
				$this->datum = $row->datum;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->bestaetigtam = $row->bestaetigtam;
				$this->bestaetigtvon = $row->bestaetigtvon;
				$this->orgform_kurzbz = $row->orgform_kurzbz;
				$this->studienplan_id = $row->studienplan_id;
				$this->studienplan_bezeichnung = $row->studienplan_bezeichnung;
<<<<<<< HEAD
				return true;	
			}
			else 
			{
				$this->errormsg = 'Keine Rolle vorhanden';
				return false;
			}			
		}
		else 
=======
				return true;
			}
			else
			{
				$this->errormsg = 'Keine Rolle vorhanden';
				return false;
			}
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der PrestudentDaten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert den Ersten Status eines Prestudenten mit der übergebenen Statuskurzbezeichnung
	 * @param $prestudent_id
	 * @param $studiensemester_kurzbz
	 * @return boolean
	 */
	public function getFirstStatus($prestudent_id, $status_kurzbz)
	{
		if($prestudent_id=='' || !is_numeric($prestudent_id))
		{
			$this->errormsg = 'Prestudent_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT * FROM public.tbl_prestudentstatus 
				WHERE 
					prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER)." 
=======

		$qry = "SELECT * FROM public.tbl_prestudentstatus
				WHERE
					prestudent_id=".$this->db_add_param($prestudent_id, FHC_INTEGER)."
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					AND status_kurzbz = ".$this->db_add_param($status_kurzbz)."
				ORDER BY datum ASC, insertamum ASC, ext_id ASC LIMIT 1";
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
<<<<<<< HEAD
			{				
=======
			{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->prestudent_id = $row->prestudent_id;
				$this->status_kurzbz = $row->status_kurzbz;
				$this->studiensemester_kurzbz = $row->studiensemester_kurzbz;
				$this->ausbildungssemester = $row->ausbildungssemester;
				$this->datum = $row->datum;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->bestaetigtam = $row->bestaetigtam;
				$this->bestaetigtvon = $row->bestaetigtvon;
				$this->orgform_kurzbz = $row->orgform_kurzbz;
				$this->studienplan_id = $row->studienplan_id;
<<<<<<< HEAD
				return true;	
			}
			else 
			{
				$this->errormsg = 'Keine Rolle vorhanden';
				return false;
			}			
		}
		else 
=======
				return true;
			}
			else
			{
				$this->errormsg = 'Keine Rolle vorhanden';
				return false;
			}
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der PrestudentDaten';
			return false;
		}
	}

	/**
	 * Laedt alle Prestudenten der Person
	 * @return true wenn ok, false wenn Fehler
	 */
	public function getPrestudenten($person_id)
	{
		if(!is_numeric($person_id) || $person_id=='')
		{
			$this->errormsg='ID ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT * FROM public.tbl_prestudent WHERE person_id=".$this->db_add_param($person_id, FHC_INTEGER)." ORDER BY prestudent_id";
		
=======

		$qry = "SELECT * FROM public.tbl_prestudent WHERE person_id=".$this->db_add_param($person_id, FHC_INTEGER)." ORDER BY prestudent_id";

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new prestudent();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->prestudent_id = $row->prestudent_id;
				$obj->aufmerksamdurch_kurzbz = $row->aufmerksamdurch_kurzbz;
				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->berufstaetigkeit_code = $row->berufstaetigkeit_code;
				$obj->ausbildungcode = $row->ausbildungcode;
				$obj->zgv_code = $row->zgv_code;
				$obj->zgvort = $row->zgvort;
				$obj->zgvdatum = $row->zgvdatum;
<<<<<<< HEAD
				$obj->zgvmas_code = $row->zgvmas_code;
				$obj->zgvmaort = $row->zgvmaort;
				$obj->zgvmadatum = $row->zgvmadatum;
=======
				$obj->zgvnation = $row->zgvnation;
				$obj->zgvmas_code = $row->zgvmas_code;
				$obj->zgvmaort = $row->zgvmaort;
				$obj->zgvmadatum = $row->zgvmadatum;
				$obj->zgvmanation = $row->zgvmanation;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->aufnahmeschluessel = $row->aufnahmeschluessel;
				$obj->facheinschlberuf = $this->db_parse_bool($row->facheinschlberuf);
				$obj->anmeldungreihungstest = $row->anmeldungreihungstest;
				$obj->reihungstestangetreten = $this->db_parse_bool($row->reihungstestangetreten);
				$obj->reihungstest_id = $row->reihungstest_id;
				$obj->punkte = $row->rt_gesamtpunkte;
				$obj->rt_punkte1 = $row->rt_punkte1;
				$obj->rt_punkte2 = $row->rt_punkte2;
				$obj->rt_punkte3 = $row->rt_punkte3;
				$obj->bismelden = $this->db_parse_bool($row->bismelden);
				$obj->person_id = $row->person_id;
				$obj->anmerkung = $row->anmerkung;
				$obj->mentor = $row->mentor;
				$obj->ext_id_prestudent = $row->ext_id;
				$obj->dual = $this->db_parse_bool($row->dual);
				$obj->ausstellungsstaat = $row->ausstellungsstaat;
<<<<<<< HEAD
                $obj->zgvdoktor_code = $row->zgvdoktor_code; 
                $obj->zgvdoktorort = $row->zgvdoktorort; 
                $obj->zgvdoktordatum = $row->zgvdoktordatum; 
				
=======
                $obj->zgvdoktor_code = $row->zgvdoktor_code;
                $obj->zgvdoktorort = $row->zgvdoktorort;
                $obj->zgvdoktordatum = $row->zgvdoktordatum;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $obj;
			}
			return true;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = "Fehler beim Laden";
			return false;
		}
	}

<<<<<<< HEAD
=======
    /**
     * Gibt die eingetragenen ZGV zurück
     * @return array
     */
    public function getZgv() {

        $zgv = array(
            'bachelor' => array(),
            'master' => array(),
//            'doktor' => array(),
        );
        $attribute = array(
            'art',
            'ort',
            'datum',
            'nation',
        );
        $db_attribute = array(
            'zgv_code',
            'zgvort',
            'zgvdatum',
            'zgvnation',
            'zgvmas_code',
            'zgvmaort',
            'zgvmadatum',
            'zgvmanation',
            'zgvdoktor_code',
            'zgvdoktorort',
            'zgvdoktordatum',
            'zgvdoktornation',
        );

        foreach($this->result as $prestudent) {

            foreach($zgv as &$value) {

                foreach($attribute as $attribut) {
                    $db_attribute_name = current($db_attribute);

                    if($prestudent->$db_attribute_name) {
                        $value[$attribut] = $prestudent->$db_attribute_name;
                    }
                    next($db_attribute);
                }
            }
            reset($db_attribute);
        }

        return $zgv;
    }

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert die Anzahl der Bewerber im ausgewaehlten Bereich
	 * @param $studiensemester_kurzbz Studiensemester
	 * @param $studiengang_kz Kennzahl des Studienganges (optional)
	 * @param $orgform_kurzbz Organisationsform (optional)
	 * @param $ausbildungssemester Ausbildungssemester (optional)
	 * @return Anzahl der Bewerber oder false im Fehlerfall
	 */
	public function getAnzBewerber($studiensemester_kurzbz, $studiengang_kz=null, $orgform_kurzbz=null, $ausbildungssemester=null)
	{
		$qry = "SELECT
					count(*) as anzahl
<<<<<<< HEAD
				FROM 
=======
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Bewerber'
					AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		if(!is_null($studiengang_kz))
			$qry.=" AND tbl_prestudent.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if(!is_null($orgform_kurzbz))
			$qry.=" AND (tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)." OR (tbl_prestudentstatus.orgform_kurzbz IS NULL AND EXISTS(SELECT 1 FROM public.tbl_studiengang WHERE studiengang_kz=tbl_prestudent.studiengang_kz AND orgform_kurzbz=".$this->db_add_param($orgform_kurzbz).")))";

		if(!is_null($ausbildungssemester))
			$qry.=" AND tbl_prestudentstatus.ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($result = $this->db_query($qry))
		{
			if($row = $this->db_fetch_object($result))
			{
				return $row->anzahl;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

	/**
	 * Liefert die Anzahl der Interessenten im ausgewaehlten Bereich
	 * @param $studiensemester_kurzbz Studiensemester
	 * @param $studiengang_kz Kennzahl des Studienganges (optional)
	 * @param $orgform_kurzbz Organisationsform (optional)
	 * @param $ausbildungssemester Ausbildungssemester (optional)
	 * @return Anzahl der Interessenten oder false im Fehlerfall
	 */
	public function getAnzInteressenten($studiensemester_kurzbz, $studiengang_kz=null, $orgform_kurzbz=null, $ausbildungssemester=null)
	{
		$qry = "SELECT
					count(*) as anzahl
<<<<<<< HEAD
				FROM 
=======
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Interessent'
					AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		if(!is_null($studiengang_kz))
			$qry.=" AND tbl_prestudent.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if(!is_null($orgform_kurzbz))
			$qry.=" AND (tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)." OR (tbl_prestudentstatus.orgform_kurzbz IS NULL AND EXISTS(SELECT 1 FROM public.tbl_studiengang WHERE studiengang_kz=tbl_prestudent.studiengang_kz AND orgform_kurzbz=".$this->db_add_param($orgform_kurzbz).")))";

		if(!is_null($ausbildungssemester))
			$qry.=" AND tbl_prestudentstatus.ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($result = $this->db_query($qry))
		{
			if($row = $this->db_fetch_object($result))
			{
				return $row->anzahl;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

	/**
	 * Liefert die Anzahl der Interessenten mit Zugangsvoraussetzung im ausgewaehlten Bereich
	 * @param $studiensemester_kurzbz Studiensemester
	 * @param $studiengang_kz Kennzahl des Studienganges (optional)
	 * @param $orgform_kurzbz Organisationsform (optional)
	 * @param $ausbildungssemester Ausbildungssemester (optional)
	 * @return Anzahl der Interessenten mit ZGV oder false im Fehlerfall
	 */
	public function getAnzInteressentenZGV($studiensemester_kurzbz, $studiengang_kz=null, $orgform_kurzbz=null, $ausbildungssemester=null)
	{
		$qry = "SELECT
					count(*) as anzahl
<<<<<<< HEAD
				FROM 
=======
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
					JOIN public.tbl_studiengang USING(studiengang_kz)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Interessent'
					AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz)."
					AND ((tbl_studiengang.typ<>'m' AND zgv_code IS NOT NULL) OR zgvmas_code IS NOT NULL)";

		if(!is_null($studiengang_kz))
			$qry.=" AND tbl_prestudent.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if(!is_null($orgform_kurzbz))
			$qry.=" AND (tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)." OR (tbl_prestudentstatus.orgform_kurzbz IS NULL AND tbl_studiengang.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)."))";

		if(!is_null($ausbildungssemester))
			$qry.=" AND tbl_prestudentstatus.ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($result = $this->db_query($qry))
		{
			if($row = $this->db_fetch_object($result))
			{
				return $row->anzahl;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}

	}

	/**
	 * Liefert ein Array mit den Bewerberzahlen
	 * @param $studiensemester_kurzbz (optional)
	 * @return true wenn ok, false im Fehlerfall DatenArray in $this->result
	 * Bsp:
	 * $prestudent->result[$stsem][$stg_kz]['anzahl']
	 * $prestudent->result[$stsem][$stg_kz][$orgform][$semester]['anzahl']
	 */
	public function listAnzBewerber($studiensemester_kurzbz=null)
	{
		$qry = "SELECT
<<<<<<< HEAD
					tbl_prestudentstatus.studiensemester_kurzbz, 
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM 
=======
					tbl_prestudentstatus.studiensemester_kurzbz,
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
					JOIN public.tbl_studiengang USING(studiengang_kz)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Bewerber'";

		if(!is_null($studiensemester_kurzbz))
			$qry.=" AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		$this->result = array();
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				// Studiensemester
				if(!isset($this->result[$row->studiensemester_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz]['anzahl']++;

				// Studiengang
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']++;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Orgform
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']++;

				// Ausbildungssemester
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']++;
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

<<<<<<< HEAD
	
	
	
	
=======




>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert ein Array mit den Interessentenzahlen
	 * @param $studiensemester_kurzbz (optional)
	 * @return true wenn ok, false im Fehlerfall DatenArray in $this->result
	 * Bsp:
	 * $prestudent->result[$stsem][$stg_kz]['anzahl']
	 * $prestudent->result[$stsem][$stg_kz][$orgform][$semester]['anzahl']
	 */
	public function listAnzInteressenten($studiensemester_kurzbz=null)
	{
		$qry = "SELECT
<<<<<<< HEAD
					tbl_prestudentstatus.studiensemester_kurzbz, 
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM 
=======
					tbl_prestudentstatus.studiensemester_kurzbz,
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
					JOIN public.tbl_studiengang USING(studiengang_kz)
				WHERE
					bismelden=true
					AND tbl_prestudentstatus.status_kurzbz='Interessent'";

		if(!is_null($studiensemester_kurzbz))
			$qry.="	AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		$this->result = array();
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				// Studiensemester
				if(!isset($this->result[$row->studiensemester_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz]['anzahl']++;

				// Studiengang
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']++;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Orgform
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']++;

				// Ausbildungssemester
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']++;
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
	
	public function listAnzAbbrecher($studiensemester_kurzbz=null)
	{
		$qry = "SELECT
					tbl_prestudentstatus.studiensemester_kurzbz, 
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM 
=======


	public function listAnzAbbrecher($studiensemester_kurzbz=null)
	{
		$qry = "SELECT
					tbl_prestudentstatus.studiensemester_kurzbz,
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
					JOIN public.tbl_studiengang USING(studiengang_kz)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Abbrecher'
					AND bismelden=true";

		if(!is_null($studiensemester_kurzbz))
			$qry.=" AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		$this->result = array();
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				// Studiensemester
				if(!isset($this->result[$row->studiensemester_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz]['anzahl']++;

				// Studiengang
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']++;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Orgform
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']++;

				// Ausbildungssemester
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']++;
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	public function listAnzStudierende($studiensemester_kurzbz=null)
	{
		$qry = "SELECT
					distinct on(prestudent_id) prestudent_id,
<<<<<<< HEAD
					tbl_prestudentstatus.studiensemester_kurzbz, 
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM 
=======
					tbl_prestudentstatus.studiensemester_kurzbz,
					tbl_prestudent.studiengang_kz,
					tbl_prestudentstatus.ausbildungssemester,
					COALESCE(tbl_prestudentstatus.orgform_kurzbz, tbl_studiengang.orgform_kurzbz) as orgform_kurzbz
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
					JOIN public.tbl_studiengang USING(studiengang_kz)
				WHERE
					tbl_prestudentstatus.status_kurzbz IN ('Student','Unterbrecher','Diplomand')
					AND bismelden=true";

		if(!is_null($studiensemester_kurzbz))
			$qry.=" AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

<<<<<<< HEAD
		
		
=======


>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$this->result = array();
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				// Studiensemester
				if(!isset($this->result[$row->studiensemester_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz]['anzahl']++;

				// Studiengang
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz]['anzahl']++;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				// Orgform
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz]['anzahl']++;

				// Ausbildungssemester
				if(!isset($this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']))
					$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']=0;

				$this->result[$row->studiensemester_kurzbz][$row->studiengang_kz][$row->orgform_kurzbz][$row->ausbildungssemester]['anzahl']++;
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Anzahl der Abbrecher liefern.<br>
	 * WM: Kopie von getBewerber() => @TODO: überprüfen!!!
	 * @param type $studiensemester_kurzbz
	 * @param type $studiengang_kz
	 * @param type $orgform_kurzbz
	 * @param type $ausbildungssemester
	 * @return boolean
	 */
	public function getAnzAbbrecher($studiensemester_kurzbz, $studiengang_kz=null, $orgform_kurzbz=null, $ausbildungssemester=null)
	{
		$qry = "SELECT
					count(*) as anzahl
<<<<<<< HEAD
				FROM 
=======
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
				WHERE
					tbl_prestudentstatus.status_kurzbz='Abbrecher'
					AND bismelden=true
					AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		if(!is_null($studiengang_kz))
			$qry.=" AND tbl_prestudent.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if(!is_null($orgform_kurzbz))
			$qry.=" AND (tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)." OR (tbl_prestudentstatus.orgform_kurzbz IS NULL AND EXISTS(SELECT 1 FROM public.tbl_studiengang WHERE studiengang_kz=tbl_prestudent.studiengang_kz AND orgform_kurzbz=".$this->db_add_param($orgform_kurzbz).")))";

		if(!is_null($ausbildungssemester))
			$qry.=" AND tbl_prestudentstatus.ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		if($result = $this->db_query($qry))
		{
			if($row = $this->db_fetch_object($result))
			{
				return $row->anzahl;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Anzahl der Studierenden liefern.<br>
	 * WM: Kopie von getBewerber() => @TODO: überprüfen!!!
	 * @param type $studiensemester_kurzbz
	 * @param type $studiengang_kz
	 * @param type $orgform_kurzbz
	 * @param type $ausbildungssemester
	 * @return boolean
	 */
	public function getAnzStudierende($studiensemester_kurzbz, $studiengang_kz=null, $orgform_kurzbz=null, $ausbildungssemester=null)
	{
		$qry = "SELECT count(*) as anzahl FROM (
				SELECT
					distinct on(prestudent_id) prestudent_id
<<<<<<< HEAD
				FROM 
=======
				FROM
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					public.tbl_prestudent
					JOIN public.tbl_prestudentstatus USING(prestudent_id)
				WHERE
					tbl_prestudentstatus.status_kurzbz IN ('Student','Unterbrecher','Diplomand')
					AND bismelden=true
					AND tbl_prestudentstatus.studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz);

		if(!is_null($studiengang_kz))
			$qry.=" AND tbl_prestudent.studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if(!is_null($orgform_kurzbz))
			$qry.=" AND (tbl_prestudentstatus.orgform_kurzbz=".$this->db_add_param($orgform_kurzbz)." OR (tbl_prestudentstatus.orgform_kurzbz IS NULL AND EXISTS(SELECT 1 FROM public.tbl_studiengang WHERE studiengang_kz=tbl_prestudent.studiengang_kz AND orgform_kurzbz=".$this->db_add_param($orgform_kurzbz).")))";

		if(!is_null($ausbildungssemester))
			$qry.=" AND tbl_prestudentstatus.ausbildungssemester=".$this->db_add_param($ausbildungssemester);

		$qry.=") as sub";

		if($result = $this->db_query($qry))
		{
			if($row = $this->db_fetch_object($result))
			{
				return $row->anzahl;
			}
			else
			{
				$this->errormsg = 'Fehler beim Laden der Daten';
				return false;
			}
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

<<<<<<< HEAD
	public function getSemesterZuUid($uid) {

		$qry = 'SELECT studiensemester_kurzbz, bezeichnung '
				. 'FROM public.tbl_prestudentstatus '
				. 'JOIN public.tbl_prestudent '
				. 'USING (prestudent_id) '
				. 'JOIN public.tbl_student '
				. 'USING (prestudent_id) '
				. 'JOIN public.tbl_studiensemester '
				. 'USING (studiensemester_kurzbz) '
				. 'WHERE status_kurzbz IN ('
					. $this->db_add_param("Student") . ', '
					. $this->db_add_param("Diplomand") . ', '
					. $this->db_add_param("Incoming") . ')'
				. ' AND student_uid = ' . $this->db_add_param($uid)
				. ' ORDER BY ausbildungssemester';

		$result = $this->db_query($qry);
		$semester = array();

		while($row = $this->db_fetch_object($result)) {
			$semester[$row->studiensemester_kurzbz] = $row->bezeichnung;
		}

		return $semester;
=======
	/**
	 * Laedt die Studiensemester eines Studenten
	 * @param $uid
	 * @return array mit Studiensemestern
	 */
	public function getSemesterZuUid($uid)
	{

		$qry = "SELECT
					tbl_studiensemester.studiensemester_kurzbz, tbl_studiensemester.bezeichnung
				FROM
					public.tbl_prestudentstatus
					JOIN public.tbl_prestudent USING (prestudent_id)
					JOIN public.tbl_student USING (prestudent_id)
					JOIN public.tbl_studiensemester USING (studiensemester_kurzbz)
				WHERE
					status_kurzbz IN ('Student', 'Diplomand','Incoming')
				 	AND student_uid = ". $this->db_add_param($uid)."
				 ORDER BY ausbildungssemester";

		if($result = $this->db_query($qry))
		{
			$semester = array();

			while($row = $this->db_fetch_object($result))
				$semester[$row->studiensemester_kurzbz] = $row->bezeichnung;

			return $semester;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}
}
