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
 * Authors: Christian Paminger <christian.paminger@technikum-wien.at>,
 *          Andreas Oesterreicher <andreas.oesterreicher@technikum-wien.at>,
 *          Rudolf Hangl <rudolf.hangl@technikum-wien.at> and
 *          Gerald Raab <gerald.raab@technikum-wien.at>.
 */
require_once(dirname(__FILE__).'/basis_db.class.php');

class studiengang extends basis_db
{
	public $new;      			// boolean
	public $result = array();	// studiengang Objekt

	public $studiengang_kz;		// integer
	public $kurzbz;				// varchar(5)
	public $kurzbzlang;			// varchar(10)
	public $bezeichnung;		// varchar(128)
	public $english;			// varchar(128)
	public $typ;				// char(1)
	public $farbe;				// char(6)
	public $email;				// varchar(64)
	public $max_semester;		// smallint
	public $max_verband;		// char(1)
	public $max_gruppe;			// char(1)
	public $erhalter_kz;		// smallint
	public $bescheid;			// varchar(256)
	public $bescheidbgbl1;		// varchar(16)
	public $bescheidbgbl2;		// varchar(16)
	public $bescheidgz;			// varchar(16)
	public $bescheidvom;		// Date
	public $titelbescheidvom;	// Date
	public $ext_id;				// bigint
	public $orgform_kurzbz;		// varchar(3)
	public $zusatzinfo_html;	// text
	public $sprache;			// varchar(16)
	public $testtool_sprachwahl;// boolean
	public $studienplaetze;		// smallint
	public $oe_kurzbz;			// varchar(32)
<<<<<<< HEAD
=======
	public $onlinebewerbung;	// boolean
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

	public $kuerzel;	// = typ + kurzbz (Bsp: BBE)
	private $studiengang_typ_arr = array(); 	// Array mit den Studiengangstypen
	public $kuerzel_arr = array();			// Array mit allen Kurzeln Index=studiengangs_kz
	public $moodle;		// boolean
	public $lgartcode;	//integer
	public $mischform;	// boolean
	public $projektarbeit_note_anzeige; // boolean
	public $bezeichnung_arr = array();
<<<<<<< HEAD
    
    public $beschreibung; 
	
=======

    public $beschreibung;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor
	 * @param studiengang_kz Kennzahl des zu ladenden Studienganges
	 */
	public function __construct($studiengang_kz=null)
	{
		parent::__construct();
<<<<<<< HEAD
		
		if(!is_null($studiengang_kz))
			$this->load($studiengang_kz);
		
=======

		if(!is_null($studiengang_kz))
			$this->load($studiengang_kz);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//$this->getAllTypes();
/*		$this->studiengang_typ_arr["b"] = "Bachelor";
		$this->studiengang_typ_arr["d"] = "Diplom";
		$this->studiengang_typ_arr["m"] = "Master";
		$this->studiengang_typ_arr["l"] = "LLL";
		$this->studiengang_typ_arr["e"] = "Erhalter"; */
	}

	public function __get($value)
	{
		switch($value)
		{
			case 'studiengang_typ_arr':
				if(count($this->studiengang_typ_arr)==0)
				{
					$this->getAllTypes();
				}
		}
		return $this->$value;
	}

	/**
	 * Laedt einen Studiengang
	 * @param studiengang_kz KZ des Studienganges der zu Laden ist
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load($studiengang_kz)
	{
		if(!is_numeric($studiengang_kz))
		{
			$this->errormsg = 'Studiengang_kz muss eine gueltige Zahl sein';
			return false;
		}

		$qry = "SELECT * FROM public.tbl_studiengang WHERE studiengang_kz=".$this->db_add_param($studiengang_kz);

		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
<<<<<<< HEAD
				$this->studiengang_kz=$row->studiengang_kz;
				$this->kurzbz=$row->kurzbz;
				$this->kurzbzlang=$row->kurzbzlang;
				$this->bezeichnung=$row->bezeichnung;
				$this->english=$row->english;
				$this->typ=$row->typ;
				$this->farbe=$row->farbe;
				$this->email=$row->email;
				$this->max_semester=$row->max_semester;
				$this->max_verband=$row->max_verband;
				$this->max_gruppe=$row->max_gruppe;
				$this->erhalter_kz=$row->erhalter_kz;
				$this->bescheid=$row->bescheid;
				$this->bescheidbgbl1=$row->bescheidbgbl1;
				$this->bescheidbgbl2=$row->bescheidbgbl2;
				$this->bescheidgz=$row->bescheidgz;
				$this->bescheidvom=$row->bescheidvom;
				$this->ext_id=$row->ext_id;
				$this->kuerzel = mb_strtoupper($row->typ.$row->kurzbz);
=======
				$this->studiengang_kz = $row->studiengang_kz;
				$this->kurzbz = $row->kurzbz;
				$this->kurzbzlang = $row->kurzbzlang;
				$this->bezeichnung = $row->bezeichnung;
				$this->english = $row->english;
				$this->typ = $row->typ;
				$this->farbe = $row->farbe;
				$this->email = $row->email;
				$this->max_semester = $row->max_semester;
				$this->max_verband = $row->max_verband;
				$this->max_gruppe = $row->max_gruppe;
				$this->erhalter_kz = $row->erhalter_kz;
				$this->bescheid = $row->bescheid;
				$this->bescheidbgbl1 = $row->bescheidbgbl1;
				$this->bescheidbgbl2 = $row->bescheidbgbl2;
				$this->bescheidgz = $row->bescheidgz;
				$this->bescheidvom = $row->bescheidvom;
				$this->ext_id = $row->ext_id;
				$this->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->orgform_kurzbz = $row->orgform_kurzbz;
				$this->zusatzinfo_html = $row->zusatzinfo_html;
				$this->sprache = $row->sprache;
				$this->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
				$this->studienplaetze = $row->studienplaetze;
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->lgartcode = $row->lgartcode;
<<<<<<< HEAD
				$this->telefon=$row->telefon;
            	$this->titelbescheidvom=$row->titelbescheidvom;
            	$this->aktiv=$this->db_parse_bool($row->aktiv);
            	$this->moodle=$this->db_parse_bool($row->moodle);
				$this->mischform=$this->db_parse_bool($row->mischform);
				$this->projektarbeit_note_anzeige=$this->db_parse_bool($row->projektarbeit_note_anzeige);
				
				$this->bezeichnung_arr['German']=$this->bezeichnung;
				$this->bezeichnung_arr['English']=$this->english;
=======
				$this->telefon = $row->telefon;
				$this->titelbescheidvom = $row->titelbescheidvom;
				$this->aktiv = $this->db_parse_bool($row->aktiv);
				$this->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
				$this->moodle = $this->db_parse_bool($row->moodle);
				$this->mischform = $this->db_parse_bool($row->mischform);
				$this->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);

				$this->bezeichnung_arr['German'] = $this->bezeichnung;
				$this->bezeichnung_arr['English'] = $this->english;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			}
		}
		else
		{
			$this->errormsg = 'Datensatz konnte nicht geladen werden';
			return false;
		}

		return true;
	}

	/**
	 * Liefert alle Studiengaenge
	 * @param $order Sortierreihenfolge
	 * @param $aktiv wenn true dann nur aktive sonst alle
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function getAll($order=null, $aktiv=true)
	{
		$qry = 'SELECT * FROM public.tbl_studiengang';
		if ($aktiv)
			$qry.=' WHERE aktiv=true';

		if($order!=null)
		 	$qry .=" ORDER BY $order";

		if(!$result = $this->db_query($qry))
		{
			$this->errormsg = 'Datensatz konnte nicht geladen werden';
			return false;
<<<<<<< HEAD
		} 
=======
		}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694

		while($row = $this->db_fetch_object($result))
		{
			$stg_obj = new studiengang();

<<<<<<< HEAD
			$stg_obj->studiengang_kz=$row->studiengang_kz;
			$stg_obj->kurzbz=$row->kurzbz;
			$stg_obj->kurzbzlang=$row->kurzbzlang;
			$stg_obj->bezeichnung=$row->bezeichnung;
			$stg_obj->english=$row->english;
			$stg_obj->typ=$row->typ;
			$stg_obj->farbe=$row->farbe;
			$stg_obj->email=$row->email;
			$stg_obj->max_semester=$row->max_semester;
			$stg_obj->max_verband=$row->max_verband;
			$stg_obj->max_gruppe=$row->max_gruppe;
			$stg_obj->erhalter_kz=$row->erhalter_kz;
			$stg_obj->bescheid=$row->bescheid;
			$stg_obj->bescheidbgbl1=$row->bescheidbgbl1;
			$stg_obj->bescheidbgbl2=$row->bescheidbgbl2;
			$stg_obj->bescheidgz=$row->bescheidgz;
			$stg_obj->bescheidvom=$row->bescheidvom;
			$stg_obj->ext_id=$row->ext_id;
			$stg_obj->kuerzel = mb_strtoupper($row->typ.$row->kurzbz);
=======
			$stg_obj->studiengang_kz = $row->studiengang_kz;
			$stg_obj->kurzbz = $row->kurzbz;
			$stg_obj->kurzbzlang = $row->kurzbzlang;
			$stg_obj->bezeichnung = $row->bezeichnung;
			$stg_obj->english = $row->english;
			$stg_obj->typ = $row->typ;
			$stg_obj->farbe = $row->farbe;
			$stg_obj->email = $row->email;
			$stg_obj->max_semester = $row->max_semester;
			$stg_obj->max_verband = $row->max_verband;
			$stg_obj->max_gruppe = $row->max_gruppe;
			$stg_obj->erhalter_kz = $row->erhalter_kz;
			$stg_obj->bescheid = $row->bescheid;
			$stg_obj->bescheidbgbl1 = $row->bescheidbgbl1;
			$stg_obj->bescheidbgbl2 = $row->bescheidbgbl2;
			$stg_obj->bescheidgz = $row->bescheidgz;
			$stg_obj->bescheidvom = $row->bescheidvom;
			$stg_obj->ext_id = $row->ext_id;
			$stg_obj->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$stg_obj->orgform_kurzbz = $row->orgform_kurzbz;
			$stg_obj->zusatzinfo_html = $row->zusatzinfo_html;
			$stg_obj->sprache = $row->sprache;
			$stg_obj->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
			$stg_obj->studienplaetze = $row->studienplaetze;
			$stg_obj->oe_kurzbz = $row->oe_kurzbz;
			$stg_obj->lgartcode = $row->lgartcode;
<<<<<<< HEAD
            $stg_obj->telefon=$row->telefon;
            $stg_obj->titelbescheidvom=$row->titelbescheidvom;
            $stg_obj->aktiv=$this->db_parse_bool($row->aktiv);
			$stg_obj->moodle=$this->db_parse_bool($row->moodle);
			$stg_obj->mischform=$this->db_parse_bool($row->mischform);
			$stg_obj->projektarbeit_note_anzeige=$this->db_parse_bool($row->projektarbeit_note_anzeige);
			
			$stg_obj->bezeichnung_arr['German']=$row->bezeichnung;
			$stg_obj->bezeichnung_arr['English']=$row->english;
			$this->result[] = $stg_obj;
			$this->kuerzel_arr[$row->studiengang_kz]=$stg_obj->kuerzel;
=======
			$stg_obj->telefon = $row->telefon;
			$stg_obj->titelbescheidvom = $row->titelbescheidvom;
			$stg_obj->aktiv = $this->db_parse_bool($row->aktiv);
			$stg_obj->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
			$stg_obj->moodle = $this->db_parse_bool($row->moodle);
			$stg_obj->mischform = $this->db_parse_bool($row->mischform);
			$stg_obj->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);

			$stg_obj->bezeichnung_arr['German'] = $row->bezeichnung;
			$stg_obj->bezeichnung_arr['English'] = $row->english;
			$this->result[] = $stg_obj;
			$this->kuerzel_arr[$row->studiengang_kz] = $stg_obj->kuerzel;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}

		return true;
	}
<<<<<<< HEAD
	
=======

    /**
     * Gibt alle Studiengaenge zurueck, fuer die man sich online bewerben kann
     * @return boolean
     */
    public function getAllForBewerbung()
    {
        $qry = 'SELECT DISTINCT studiengang_kz, typ, organisationseinheittyp_kurzbz, studiengangbezeichnung, standort, studiengangbezeichnung_englisch, lgartcode, tbl_lgartcode.bezeichnung '
                . 'FROM lehre.vw_studienplan '
                . 'LEFT JOIN bis.tbl_lgartcode USING (lgartcode) '
                . 'WHERE onlinebewerbung IS TRUE '
                . 'ORDER BY typ, studiengangbezeichnung, tbl_lgartcode.bezeichnung ASC';

		if(!$result = $this->db_query($qry))
		{
			$this->errormsg = 'Datensatz konnte nicht geladen werden';
			return false;
		}

		while($row = $this->db_fetch_object($result))
		{
			$this->result[] = $row;
		}

		return true;
    }

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Studientypen in das Attribut studiengang_typ_array
	 */
	public function getAllTypes()
	{
		$qry='SELECT * FROM public.tbl_studiengangstyp';
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
<<<<<<< HEAD
				$this->studiengang_typ_arr[$row->typ]=$row->typ.' - '.$row->bezeichnung;
=======
				$this->studiengang_typ_arr[$row->typ]=$row->bezeichnung;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			}
		}
		else
			$this->errormsg = 'Fehler beim Laden der Studiengangstypen';
	}

	/**
<<<<<<< HEAD
=======
	 * Gibt aktive OrgFormen eines Studiengangs zurück.
	 * @return array
	 */
	public function getOrgForm($studiengang_kz)
	{
		$qry = 'SELECT distinct orgform_kurzbz '
				. 'FROM lehre.tbl_studienordnung '
				. 'JOIN lehre.tbl_studienplan '
				. 'USING (studienordnung_id) '
				. 'WHERE aktiv '
				. 'AND studiengang_kz = ' . $this->db_add_param($studiengang_kz, FHC_INTEGER)
				. ' AND orgform_kurzbz!='. $this->db_add_param('DDP');

		if($result = $this->db_query($qry))
		{
			$ret = array();

			while($row = $this->db_fetch_object($result))
			{
				$ret[] = $row->orgform_kurzbz;
			}
		}

		return $ret;
	}

	/**
	 * Gibt aktive Sprachen eines Studiengangs zurück.
	 * @return array
	 */
	public function getSprache($studiengang_kz)
	{
		$qry = 'SELECT distinct sprache '
				. 'FROM lehre.tbl_studienordnung '
				. 'JOIN lehre.tbl_studienplan '
				. 'USING (studienordnung_id) '
				. 'WHERE aktiv '
				. 'AND studiengang_kz = ' . $this->db_add_param($studiengang_kz, FHC_INTEGER);

		if($result = $this->db_query($qry))
		{
			$ret = array();

			while($row = $this->db_fetch_object($result))
			{
				$ret[] = $row->sprache;
			}
		}

		return $ret;
	}

	/**
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Laedt die Studiengaenge die als Array uebergeben werden
	 * @param $stgs Array mit den Kennzahlen
	 * @param $order Sortierreihenfolge
	 * @param $aktiv wenn true dann nur aktive sonst alle
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function loadArray($kennzahlen, $order=null, $aktiv=true)
	{
		if(count($kennzahlen)==0)
			return true;
<<<<<<< HEAD
		
		$kennzahlen = $this->implode4SQL($kennzahlen);
						
=======

		$kennzahlen = $this->implode4SQL($kennzahlen);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$qry = 'SELECT * FROM public.tbl_studiengang WHERE studiengang_kz in('.$kennzahlen.')';
		if ($aktiv)
			$qry.=' AND aktiv=true';

		if($order!=null)
		 	$qry .=" ORDER BY $order";

		if(!$result = $this->db_query($qry))
		{
			$this->errormsg = 'Datensatz konnte nicht geladen werden';
			return false;
<<<<<<< HEAD
		} 
		
=======
		}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		while($row = $this->db_fetch_object($result))
		{
			$stg_obj = new studiengang();

<<<<<<< HEAD
			$stg_obj->studiengang_kz=$row->studiengang_kz;
			$stg_obj->kurzbz=$row->kurzbz;
			$stg_obj->kurzbzlang=$row->kurzbzlang;
			$stg_obj->bezeichnung=$row->bezeichnung;
			$stg_obj->english=$row->english;
			$stg_obj->typ=$row->typ;
			$stg_obj->farbe=$row->farbe;
			$stg_obj->email=$row->email;
			$stg_obj->max_semester=$row->max_semester;
			$stg_obj->max_verband=$row->max_verband;
			$stg_obj->max_gruppe=$row->max_gruppe;
			$stg_obj->erhalter_kz=$row->erhalter_kz;
			$stg_obj->bescheid=$row->bescheid;
			$stg_obj->bescheidbgbl1=$row->bescheidbgbl1;
			$stg_obj->bescheidbgbl2=$row->bescheidbgbl2;
			$stg_obj->bescheidgz=$row->bescheidgz;
			$stg_obj->bescheidvom=$row->bescheidvom;
			$stg_obj->ext_id=$row->ext_id;
			$stg_obj->kuerzel = mb_strtoupper($row->typ.$row->kurzbz);
=======
			$stg_obj->studiengang_kz = $row->studiengang_kz;
			$stg_obj->kurzbz = $row->kurzbz;
			$stg_obj->kurzbzlang = $row->kurzbzlang;
			$stg_obj->bezeichnung = $row->bezeichnung;
			$stg_obj->english = $row->english;
			$stg_obj->typ = $row->typ;
			$stg_obj->farbe = $row->farbe;
			$stg_obj->email = $row->email;
			$stg_obj->max_semester = $row->max_semester;
			$stg_obj->max_verband = $row->max_verband;
			$stg_obj->max_gruppe = $row->max_gruppe;
			$stg_obj->erhalter_kz = $row->erhalter_kz;
			$stg_obj->bescheid = $row->bescheid;
			$stg_obj->bescheidbgbl1 = $row->bescheidbgbl1;
			$stg_obj->bescheidbgbl2 = $row->bescheidbgbl2;
			$stg_obj->bescheidgz = $row->bescheidgz;
			$stg_obj->bescheidvom = $row->bescheidvom;
			$stg_obj->ext_id = $row->ext_id;
			$stg_obj->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			$stg_obj->orgform_kurzbz = $row->orgform_kurzbz;
			$stg_obj->zusatzinfo_html = $row->zusatzinfo_html;
			$stg_obj->sprache = $row->sprache;
			$stg_obj->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
			$stg_obj->studienplaetze = $row->studienplaetze;
			$stg_obj->oe_kurzbz = $row->oe_kurzbz;
			$stg_obj->lgartcode = $row->lgartcode;
<<<<<<< HEAD
            $stg_obj->telefon=$row->telefon;
            $stg_obj->titelbescheidvom=$row->titelbescheidvom;
            $stg_obj->aktiv=$this->db_parse_bool($row->aktiv);
			$stg_obj->moodle=$this->db_parse_bool($row->moodle);
			$stg_obj->mischform=$this->db_parse_bool($row->mischform);
			$stg_obj->projektarbeit_note_anzeige=$this->db_parse_bool($row->projektarbeit_note_anzeige);
			
			$stg_obj->bezeichnung_arr['German']=$row->bezeichnung;
			$stg_obj->bezeichnung_arr['English']=$row->english;
			
			$this->result[] = $stg_obj;
			$this->kuerzel_arr[$row->studiengang_kz]=$stg_obj->kuerzel;
=======
			$stg_obj->telefon = $row->telefon;
			$stg_obj->titelbescheidvom = $row->titelbescheidvom;
			$stg_obj->aktiv = $this->db_parse_bool($row->aktiv);
			$stg_obj->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
			$stg_obj->moodle = $this->db_parse_bool($row->moodle);
			$stg_obj->mischform = $this->db_parse_bool($row->mischform);
			$stg_obj->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);

			$stg_obj->bezeichnung_arr['German'] = $row->bezeichnung;
			$stg_obj->bezeichnung_arr['English'] = $row->english;

			$this->result[] = $stg_obj;
			$this->kuerzel_arr[$row->studiengang_kz] = $stg_obj->kuerzel;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}

		return true;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Prueft die Gueltigkeit der Variablen
	 * @return true wenn ok, false im Fehlerfall
	 */
	private function validate()
	{
		//Laenge Pruefen
		if(mb_strlen($this->bezeichnung)>128)
		{
			$this->errormsg = 'Bezeichnung darf nicht laenger als 128 Zeichen sein.';
			return false;
		}
		if(mb_strlen($this->kurzbz)>5)
		{
			$this->errormsg = 'Kurzbez darf nicht laenger als 5 Zeichen sein.';
			return false;
		}
		if(mb_strlen($this->kurzbzlang)>10)
		{
			$this->errormsg = 'Kurzbezlang darf nicht laenger als 10 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->english)>128)
		{
			$this->errormsg = 'english darf nicht laenger als 128 Zeichen sein';
			return false;
		}
		if(!is_numeric($this->studiengang_kz))
		{
			$this->errormsg = 'studiengang_kz ungueltig!';
			return false;
		}
		$this->errormsg = '';
		return true;
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Speichert den aktuellen Datensatz
	 * @param $new boolean Legt fest ob der Datensatz neu angelegt wird oder nicht
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save($new=null)
	{
		if(is_null($new))
			$new = $this->new;
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//Gueltigkeit der Variablen pruefen
		if(!$this->validate())
		{
			return false;
		}

		if($new)
		{
			//Neuen Datensatz anlegen
			$qry = 'INSERT INTO public.tbl_studiengang (studiengang_kz, kurzbz, kurzbzlang, bezeichnung, english,
				typ, farbe, email, telefon, max_verband, max_semester, max_gruppe, erhalter_kz, bescheid, bescheidbgbl1,
<<<<<<< HEAD
				bescheidbgbl2, bescheidgz, bescheidvom, titelbescheidvom, aktiv, ext_id, orgform_kurzbz, zusatzinfo_html, 
=======
				bescheidbgbl2, bescheidgz, bescheidvom, titelbescheidvom, aktiv, onlinebewerbung, orgform_kurzbz, zusatzinfo_html,
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				oe_kurzbz, moodle, sprache, testtool_sprachwahl, studienplaetze, lgartcode, mischform,projektarbeit_note_anzeige) VALUES ('.
				$this->db_add_param($this->studiengang_kz, FHC_INTEGER).', '.
				$this->db_add_param($this->kurzbz).', '.
				$this->db_add_param($this->kurzbzlang).', '.
				$this->db_add_param($this->bezeichnung).', '.
				$this->db_add_param($this->english).', '.
				$this->db_add_param($this->typ).', '.
				$this->db_add_param($this->farbe).', '.
				$this->db_add_param($this->email).', '.
				$this->db_add_param($this->telefon).', '.
				$this->db_add_param($this->max_verband).', '.
				$this->db_add_param($this->max_semester).', '.
				$this->db_add_param($this->max_gruppe).', '.
				$this->db_add_param($this->erhalter_kz).', '.
				$this->db_add_param($this->bescheid).', '.
				$this->db_add_param($this->bescheidbgbl1).', '.
				$this->db_add_param($this->bescheidbgbl2).', '.
				$this->db_add_param($this->bescheidgz).', '.
				$this->db_add_param($this->bescheidvom).', '.
				$this->db_add_param($this->titelbescheidvom).', '.
				$this->db_add_param($this->aktiv, FHC_BOOLEAN).', '.
<<<<<<< HEAD
				$this->db_add_param($this->ext_id).', '.
=======
				$this->db_add_param($this->onlinebewerbung, FHC_BOOLEAN).', '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->db_add_param($this->orgform_kurzbz).', '.
				$this->db_add_param($this->zusatzinfo_html).', '.
				$this->db_add_param($this->oe_kurzbz).', '.
				$this->db_add_param($this->moodle, FHC_BOOLEAN).', '.
				$this->db_add_param($this->sprache).', '.
				$this->db_add_param($this->testtool_sprachwahl, FHC_BOOLEAN).', '.
				$this->db_add_param($this->studienplaetze).', '.
				$this->db_add_param($this->lgartcode).', '.
				$this->db_add_param($this->mischform, FHC_BOOLEAN).','.
				$this->db_add_param($this->projektarbeit_note_anzeige, FHC_BOOLEAN).');';
		}
		else
		{
			//bestehenden Datensatz akualisieren

			$qry = 'UPDATE public.tbl_studiengang SET '.
				'studiengang_kz='.$this->db_add_param($this->studiengang_kz, FHC_INTEGER).', '.
				'kurzbz='.$this->db_add_param($this->kurzbz).', '.
				'kurzbzlang='.$this->db_add_param($this->kurzbzlang).', '.
				'bezeichnung='.$this->db_add_param($this->bezeichnung).', '.
				'english='.$this->db_add_param($this->english).', '.
				'typ='.$this->db_add_param($this->typ).', '.
				'farbe='.$this->db_add_param($this->farbe).', '.
				'email='.$this->db_add_param($this->email).', '.
				'max_verband='.$this->db_add_param($this->max_verband).', '.
				'max_semester='.$this->db_add_param($this->max_semester).', '.
				'max_gruppe='.$this->db_add_param($this->max_gruppe).', '.
				'erhalter_kz='.$this->db_add_param($this->erhalter_kz).', '.
				'bescheid='.$this->db_add_param($this->bescheid).', '.
				'bescheidbgbl1='.$this->db_add_param($this->bescheidbgbl1).', '.
				'bescheidbgbl2='.$this->db_add_param($this->bescheidbgbl2).', '.
				'bescheidgz='.$this->db_add_param($this->bescheidgz).', '.
				'bescheidvom='.$this->db_add_param($this->bescheidvom).', '.
				'titelbescheidvom='.$this->db_add_param($this->titelbescheidvom).', '.
<<<<<<< HEAD
				'ext_id='.$this->db_add_param($this->ext_id).', '.
				'telefon='.$this->db_add_param($this->telefon).', '.
				'orgform_kurzbz='.$this->db_add_param($this->orgform_kurzbz).', '.
				'aktiv='.$this->db_add_param($this->aktiv, FHC_BOOLEAN).', '.
				'oe_kurzbz='.$this->db_add_param($this->oe_kurzbz).','.
				'zusatzinfo_html='.$this->db_add_param($this->zusatzinfo_html).', '.
				'moodle='.$this->db_add_param($this->moodle, FHC_BOOLEAN).', '.
				'projektarbeit_note_anzeige='.$this->db_add_param($this->projektarbeit_note_anzeige, FHC_BOOLEAN).', '.			
=======
				'telefon='.$this->db_add_param($this->telefon).', '.
				'orgform_kurzbz='.$this->db_add_param($this->orgform_kurzbz).', '.
				'aktiv='.$this->db_add_param($this->aktiv, FHC_BOOLEAN).', '.
				'onlinebewerbung='.$this->db_add_param($this->onlinebewerbung, FHC_BOOLEAN).', '.
				'oe_kurzbz='.$this->db_add_param($this->oe_kurzbz).','.
				'zusatzinfo_html='.$this->db_add_param($this->zusatzinfo_html).', '.
				'moodle='.$this->db_add_param($this->moodle, FHC_BOOLEAN).', '.
				'projektarbeit_note_anzeige='.$this->db_add_param($this->projektarbeit_note_anzeige, FHC_BOOLEAN).', '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				'sprache='.$this->db_add_param($this->sprache).', '.
				'testtool_sprachwahl='.$this->db_add_param($this->testtool_sprachwahl, FHC_BOOLEAN).', '.
				'studienplaetze='.$this->db_add_param($this->studienplaetze).', '.
				'lgartcode='.$this->db_add_param($this->lgartcode).', '.
				'mischform='.$this->db_add_param($this->mischform, FHC_BOOLEAN).' '.
				'WHERE studiengang_kz='.$this->db_add_param($this->studiengang_kz, FHC_INTEGER, false).';';
		}

		if($this->db_query($qry))
		{
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Speichern des Datensatzes';
			return false;
		}
	}

	/**
	 * Setzt Studiengaenge aktiv/inaktiv
	 * benoetigt studiengang_kz und 'on'/'off'
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function toggleAktiv($studiengang_kz)
	{
		if(!is_numeric($studiengang_kz))
		{
			$this->errormsg = 'Studiengang_kz muss eine gueltige Zahl sein';
			return false;
		}
		$qry = "UPDATE public.tbl_studiengang SET aktiv = NOT aktiv WHERE studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

		if($this->db_query($qry))
		{
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Speichern des Datensatzes';
			return false;
		}

	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert die UIDs der Studiengangsleiter
	 *
	 * @param $studiengang_kz wenn gesetzt werden die Leiter dieses Studienganges geliefert
	 * 						  wenn null werden alle Stgl zurueckgeliefert
	 */
	public function getLeitung($studiengang_kz=null)
	{
		$stgl = array();
<<<<<<< HEAD
		
		$qry = "SELECT 
					uid
				FROM 
					public.tbl_benutzerfunktion 
					JOIN public.tbl_studiengang USING(oe_kurzbz) 
				WHERE 
					funktion_kurzbz='Leitung' AND
					(datum_von is null OR datum_von<=now()) AND
					(datum_bis is null OR datum_bis>=now())";
		
		if(!is_null($studiengang_kz))
			$qry.=" AND studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);
		
=======

		$qry = "SELECT
					uid
				FROM
					public.tbl_benutzerfunktion
					JOIN public.tbl_studiengang USING(oe_kurzbz)
				WHERE
					funktion_kurzbz='Leitung' AND
					(datum_von is null OR datum_von<=now()) AND
					(datum_bis is null OR datum_bis>=now())";

		if(!is_null($studiengang_kz))
			$qry.=" AND studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				$stgl[] = $row->uid;
			}
			return $stgl;
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Studiengangsleiter';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt einen Studiengang anhand seiner Organisationseinheit
	 * @param $oe_kurzbz
	 * @return boolean
	 */
	public function getStudiengangFromOe($oe_kurzbz)
	{
<<<<<<< HEAD
		$qry ="SELECT * FROM public.tbl_studiengang WHERE oe_kurzbz =".$this->db_add_param($oe_kurzbz); 
		
=======
		$qry ="SELECT * FROM public.tbl_studiengang WHERE oe_kurzbz =".$this->db_add_param($oe_kurzbz);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
<<<<<<< HEAD
				$this->studiengang_kz=$row->studiengang_kz;
				$this->kurzbz=$row->kurzbz;
				$this->kurzbzlang=$row->kurzbzlang;
				$this->bezeichnung=$row->bezeichnung;
				$this->english=$row->english;
				$this->typ=$row->typ;
				$this->farbe=$row->farbe;
				$this->email=$row->email;
				$this->max_semester=$row->max_semester;
				$this->max_verband=$row->max_verband;
				$this->max_gruppe=$row->max_gruppe;
				$this->erhalter_kz=$row->erhalter_kz;
				$this->bescheid=$row->bescheid;
				$this->bescheidbgbl1=$row->bescheidbgbl1;
				$this->bescheidbgbl2=$row->bescheidbgbl2;
				$this->bescheidgz=$row->bescheidgz;
				$this->bescheidvom=$row->bescheidvom;
				$this->ext_id=$row->ext_id;
				$this->kuerzel = mb_strtoupper($row->typ.$row->kurzbz);
=======
				$this->studiengang_kz = $row->studiengang_kz;
				$this->kurzbz = $row->kurzbz;
				$this->kurzbzlang = $row->kurzbzlang;
				$this->bezeichnung = $row->bezeichnung;
				$this->english = $row->english;
				$this->typ = $row->typ;
				$this->farbe = $row->farbe;
				$this->email = $row->email;
				$this->max_semester = $row->max_semester;
				$this->max_verband = $row->max_verband;
				$this->max_gruppe = $row->max_gruppe;
				$this->erhalter_kz = $row->erhalter_kz;
				$this->bescheid = $row->bescheid;
				$this->bescheidbgbl1 = $row->bescheidbgbl1;
				$this->bescheidbgbl2 = $row->bescheidbgbl2;
				$this->bescheidgz = $row->bescheidgz;
				$this->bescheidvom = $row->bescheidvom;
				$this->ext_id = $row->ext_id;
				$this->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->orgform_kurzbz = $row->orgform_kurzbz;
				$this->zusatzinfo_html = $row->zusatzinfo_html;
				$this->sprache = $row->sprache;
				$this->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
				$this->studienplaetze = $row->studienplaetze;
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->lgartcode = $row->lgartcode;
<<<<<<< HEAD
	            $this->telefon=$row->telefon;
	            $this->titelbescheidvom=$row->titelbescheidvom;
	            $this->aktiv=$this->db_parse_bool($row->aktiv);
				$this->moodle=$this->db_parse_bool($row->moodle);
				$this->mischform=$this->db_parse_bool($row->mischform);
				$this->projektarbeit_note_anzeige=$this->db_parse_bool($row->projektarbeit_note_anzeige);
				
				$this->bezeichnung_arr['German']=$this->bezeichnung;
				$this->bezeichnung_arr['English']=$this->english;
				return true; 
			}
		}
		else 
		{
			$this->errormsg = "Fehler bei der Datenbankabfrage aufgetreten."; 
			return false; 
		}
	}
	
		
=======
				$this->telefon = $row->telefon;
				$this->titelbescheidvom = $row->titelbescheidvom;
				$this->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
				$this->moodle = $this->db_parse_bool($row->moodle);
				$this->mischform = $this->db_parse_bool($row->mischform);
				$this->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);

				$this->bezeichnung_arr['German'] = $this->bezeichnung;
				$this->bezeichnung_arr['English'] = $this->english;
				return true;
			}
		}
		else
		{
			$this->errormsg = "Fehler bei der Datenbankabfrage aufgetreten.";
			return false;
		}
	}


>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * @return Array mit allen Semestern des Studienganges
	 */
	public function getSemesterFromStudiengang($studiengang_kz)
	{
		$qry = "SELECT DISTINCT semester from lehre.tbl_lehrveranstaltung where studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER)." order by semester asc;";
		if(!$this->db_query($qry))
		{
			$this->errormsg = 'Datensatz konnte nicht geladen werden';
			return false;
		}
		$result = array();
		while ($row = $this->db_fetch_object()) {
			$result[]= $row->semester;
		}
		return $result;
	}
<<<<<<< HEAD
    
    public function getStudiengangTyp($typ)
    {
        $qry = "SELECT * FROM public.tbl_studiengangstyp WHERE typ =".$this->db_add_param($typ,FHC_STRING).";"; 
        
=======

    public function getStudiengangTyp($typ)
    {
        $qry = "SELECT * FROM public.tbl_studiengangstyp WHERE typ =".$this->db_add_param($typ,FHC_STRING).";";

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
        if($result = $this->db_query($qry))
        {
            if($row = $this->db_fetch_object($result))
            {
<<<<<<< HEAD
                $this->typ = $row->typ; 
                $this->bezeichnung = $row->bezeichnung; 
                $this->beschreibung = $row->beschreibung; 
            }
            
            return true; 
        }
        else 
        {
            $this->errormsg = "Fehler bei der Abfrage aufgetreten"; 
            return false; 
        }
    }
}
?>
=======
                $this->typ = $row->typ;
                $this->bezeichnung = $row->bezeichnung;
                $this->beschreibung = $row->beschreibung;
            }

            return true;
        }
        else
        {
            $this->errormsg = "Fehler bei der Abfrage aufgetreten";
            return false;
        }
    }

    /**
     * @param $studiengaenge array
     * @return array|bool
     */
    public function getTypes($studiengaenge) {

        $qry = 'SELECT distinct typ ' .
            'FROM public.tbl_studiengang ' .
            'WHERE studiengang_kz IN (' . implode(',', $studiengaenge) . ')';

        $types = array();

        if($result = $this->db_query($qry))
        {
            while($row = $this->db_fetch_object($result)) {

                $types[] = $row->typ;

            }

            return $types;
        }
        else
        {
            $this->errormsg = "Fehler bei der Abfrage aufgetreten";
            return false;
        }
    }

	/**
	 * Sucht nach einem Studiengang
	 * @param type $searchItem
	 * @return boolean true, wenn ok; false, im Fehlerfall
	 */
	public function search($searchItem)
	{
	    $qry = 'SELECT * FROM public.tbl_studiengang WHERE
	    		LOWER(bezeichnung) LIKE LOWER(\'%'.$this->db_escape((implode(' ',$searchItem))).'%\') OR
	    		LOWER(english) LIKE LOWER(\'%'.$this->db_escape((implode(' ',$searchItem))).'%\')
	    		ORDER BY typ,bezeichnung;';

	    if($this->db_query($qry))
	    {
			while($row = $this->db_fetch_object())
			{
				$obj = new studiengang();

				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->kurzbz = $row->kurzbz;
				$obj->kurzbzlang = $row->kurzbzlang;
				$obj->bezeichnung = $row->bezeichnung;
				$obj->english = $row->english;
				$obj->typ = $row->typ;
				$obj->farbe = $row->farbe;
				$obj->email = $row->email;
				$obj->max_semester = $row->max_semester;
				$obj->max_verband = $row->max_verband;
				$obj->max_gruppe = $row->max_gruppe;
				$obj->erhalter_kz = $row->erhalter_kz;
				$obj->bescheid = $row->bescheid;
				$obj->bescheidbgbl1 = $row->bescheidbgbl1;
				$obj->bescheidbgbl2 = $row->bescheidbgbl2;
				$obj->bescheidgz = $row->bescheidgz;
				$obj->bescheidvom = $row->bescheidvom;
				$obj->ext_id = $row->ext_id;
				$obj->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
				$obj->orgform_kurzbz = $row->orgform_kurzbz;
				$obj->zusatzinfo_html = $row->zusatzinfo_html;
				$obj->sprache = $row->sprache;
				$obj->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
				$obj->studienplaetze = $row->studienplaetze;
				$obj->oe_kurzbz = $row->oe_kurzbz;
				$obj->lgartcode = $row->lgartcode;
				$obj->telefon = $row->telefon;
				$obj->titelbescheidvom = $row->titelbescheidvom;
				$obj->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
				$obj->moodle = $this->db_parse_bool($row->moodle);
				$obj->mischform = $this->db_parse_bool($row->mischform);
				$obj->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);
				$obj->aktiv = $this->db_parse_bool($row->aktiv);

				$this->result[] = $obj;
			}
			return true;
	    }
	    else
	    {
			$this->errormsg = 'Fehler beim Laden des Studiengangs';
			return false;
	    }
	}

	/**
	 * Laedt alle Studiengaenge in einer Organisationseinheit
	 * @param varchar $oe_kurzbz Organisationseinheit
	 * @param boolean $aktiv Wenn true dann werden nur aktive Studiengaenge geliefert
	 * @return boolean
	 */
	public function getStudiengaengeFromOe($oe_kurzbz, $aktiv=true)
	{
		$qry ="WITH RECURSIVE oes(oe_kurzbz) as
			   (
					SELECT oe_kurzbz FROM public.tbl_organisationseinheit WHERE oe_kurzbz=".$this->db_add_param($oe_kurzbz)."
					UNION
					SELECT tbl_organisationseinheit.oe_kurzbz FROM public.tbl_organisationseinheit JOIN oes ON(oe_parent_kurzbz=oes.oe_kurzbz)
				)
				SELECT * FROM public.tbl_studiengang JOIN oes USING(oe_kurzbz) WHERE oe_kurzbz = oes.oe_kurzbz";

		if($aktiv===true)
		{
			$qry.=" AND tbl_studiengang.aktiv";
		}

		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new studiengang();

				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->kurzbz = $row->kurzbz;
				$obj->kurzbzlang = $row->kurzbzlang;
				$obj->bezeichnung = $row->bezeichnung;
				$obj->english = $row->english;
				$obj->typ = $row->typ;
				$obj->farbe = $row->farbe;
				$obj->email = $row->email;
				$obj->max_semester = $row->max_semester;
				$obj->max_verband = $row->max_verband;
				$obj->max_gruppe = $row->max_gruppe;
				$obj->erhalter_kz = $row->erhalter_kz;
				$obj->bescheid = $row->bescheid;
				$obj->bescheidbgbl1 = $row->bescheidbgbl1;
				$obj->bescheidbgbl2 = $row->bescheidbgbl2;
				$obj->bescheidgz = $row->bescheidgz;
				$obj->bescheidvom = $row->bescheidvom;
				$obj->ext_id = $row->ext_id;
				$obj->kuerzel = mb_strtoupper($row->typ . $row->kurzbz);
				$obj->orgform_kurzbz = $row->orgform_kurzbz;
				$obj->zusatzinfo_html = $row->zusatzinfo_html;
				$obj->sprache = $row->sprache;
				$obj->testtool_sprachwahl = $this->db_parse_bool($row->testtool_sprachwahl);
				$obj->studienplaetze = $row->studienplaetze;
				$obj->oe_kurzbz = $row->oe_kurzbz;
				$obj->lgartcode = $row->lgartcode;
				$obj->telefon = $row->telefon;
				$obj->titelbescheidvom = $row->titelbescheidvom;
				$obj->onlinebewerbung = $this->db_parse_bool($row->onlinebewerbung);
				$obj->moodle = $this->db_parse_bool($row->moodle);
				$obj->mischform = $this->db_parse_bool($row->mischform);
				$obj->projektarbeit_note_anzeige = $this->db_parse_bool($row->projektarbeit_note_anzeige);

				$obj->bezeichnung_arr['German'] = $obj->bezeichnung;
				$obj->bezeichnung_arr['English'] = $obj->english;

				$this->result[] = $obj;
			}
			return true;
		}
		else
		{
			$this->errormsg = "Fehler bei der Datenbankabfrage aufgetreten.";
			return false;
		}
	}

	/**
	 * Laedt die Lehrgangstypen
	 * @return boolean true wenn ok sonst false
	 */
	public function getLehrgangstyp()
	{
		$qry = "SELECT * FROM bis.tbl_lgartcode";

		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				$obj = new stdClass();

				$obj->lgartcode = $row->lgartcode;
				$obj->kurzbz = $row->kurzbz;
				$obj->bezeichnung = $row->bezeichnung;
				$obj->beantragung = $this->db_parse_bool($row->beantragung);
				$obj->lgart_biscode = $row->lgart_biscode;
			
				$this->result[]= $obj;
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
}
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
