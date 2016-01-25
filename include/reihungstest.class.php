<?php
/* Copyright (C) 2007 Technikum-Wien
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
/**
<<<<<<< HEAD
 * Klasse Reihungstest 
=======
 * Klasse Reihungstest
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 * @create 10-01-2007
 */
require_once(dirname(__FILE__).'/basis_db.class.php');

<<<<<<< HEAD
class reihungstest extends basis_db 
=======
class reihungstest extends basis_db
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
{
	public $new;			//  boolean
	public $done=false;		//  boolean
	public $result = array();
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	//Tabellenspalten
	public $reihungstest_id;//  integer
	public $studiengang_kz;	//  integer
	public $ort_kurzbz;		//  string
	public $anmerkung;		//  string
	public $datum;			//  date
	public $uhrzeit;		//  time without time zone
	public $ext_id;			//  integer
	public $insertamum;		//  timestamp
	public $insertvon;		//  bigint
	public $updateamum;		//  timestamp
	public $updatevon;		//  bigint
	public $freigeschaltet=false;	//  boolean
	public $oeffentlich=false;	//  boolean
	public $max_teilnehmer;	//  integer
<<<<<<< HEAD
	
=======
	public $studiensemester_kurzbz; //string

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor
	 * @param $reihungstest_id ID der Adresse die geladen werden soll (Default=null)
	 */
	public function __construct($reihungstest_id=null)
	{
		parent::__construct();
<<<<<<< HEAD
		
		if(!is_null($reihungstest_id))
			$this->load($reihungstest_id);
	}
	
=======

		if(!is_null($reihungstest_id))
			$this->load($reihungstest_id);
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt den Reihungstest mit der ID $reihungstest_id
	 * @param  $reihungstest_id ID des zu ladenden Reihungstests
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load($reihungstest_id)
	{
		if(!is_numeric($reihungstest_id))
		{
			$this->errormsg = 'Reihungstest_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT * FROM public.tbl_reihungstest WHERE reihungstest_id=".$this->db_add_param($reihungstest_id, FHC_INTEGER, false);
		
=======

		$qry = "SELECT * FROM public.tbl_reihungstest WHERE reihungstest_id=".$this->db_add_param($reihungstest_id, FHC_INTEGER, false);

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->reihungstest_id = $row->reihungstest_id;
				$this->studiengang_kz = $row->studiengang_kz;
				$this->ort_kurzbz = $row->ort_kurzbz;
				$this->anmerkung = $row->anmerkung;
				$this->datum = $row->datum;
				$this->uhrzeit = $row->uhrzeit;
				$this->ext_id = $row->ext_id;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->max_teilnehmer = $row->max_teilnehmer;
				$this->oeffentlich = $this->db_parse_bool($row->oeffentlich);
				$this->freigeschaltet = $this->db_parse_bool($row->freigeschaltet);
<<<<<<< HEAD
				return true;				
			}
			else 
=======
				$this->studiensemester_kurzbz =$row->studiensemester_kurzbz;
				return true;
			}
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg = 'Reihungstest existiert nicht';
				return false;
			}
		}
<<<<<<< HEAD
		else 
=======
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Reihungstests';
			return false;
		}
	}
<<<<<<< HEAD
	
	/**
	 * Liefert alle Reihungstests
	 * wenn ein Datum uebergeben wird, dann werden alle Reihungstests ab diesem 
=======

	/**
	 * Liefert alle Reihungstests
	 * wenn ein Datum uebergeben wird, dann werden alle Reihungstests ab diesem
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Datum zurueckgeliefert
	 */
	public function getAll($datum=null)
	{
		$qry = "SELECT * FROM public.tbl_reihungstest ";
		if($datum!=null)
			$qry.=" WHERE datum>=".$this->db_add_param($datum);
		$qry.=" ORDER BY datum DESC, uhrzeit";
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new reihungstest();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->reihungstest_id = $row->reihungstest_id;
				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->ort_kurzbz = $row->ort_kurzbz;
				$obj->anmerkung = $row->anmerkung;
				$obj->datum = $row->datum;
				$obj->uhrzeit = $row->uhrzeit;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
				$obj->max_teilnehmer = $row->max_teilnehmer;
				$obj->oeffentlich = $this->db_parse_bool($row->oeffentlich);
				$obj->freigeschaltet = $this->db_parse_bool($row->freigeschaltet);
<<<<<<< HEAD
				
=======
				$obj->studiensemester_kurzbz =$row->studiensemester_kurzbz;

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
			$this->errormsg = 'Fehler beim Laden der Reihungstests';
			return false;
		}
	}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Prueft die Variablen auf Gueltigkeit
	 * @return true wenn ok, false im Fehlerfall
	 */
	private function validate()
<<<<<<< HEAD
	{		
=======
	{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		//Zahlenfelder pruefen
		if(!is_numeric($this->studiengang_kz))
		{
			$this->errormsg='studiengang_kz enthaelt ungueltige Zeichen';
			return false;
		}
		//Gesamtlaenge pruefen
		if(mb_strlen($this->ort_kurzbz)>32)
		{
			$this->errormsg = 'Ort_kurzbz darf nicht länger als 16 Zeichen sein';
			return false;
		}
		if(mb_strlen($this->anmerkung)>64)
		{
			$this->errormsg = 'Anmerkung darf nicht länger als 64 Zeichen sein';
			return false;
		}
<<<<<<< HEAD
				
		$this->errormsg = '';
		return true;		
	}
	
	/**
	 * Speichert den aktuellen Datensatz in die Datenbank	 
=======

		$this->errormsg = '';
		return true;
	}

	/**
	 * Speichert den aktuellen Datensatz in die Datenbank
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Wenn $neu auf true gesetzt ist wird ein neuer Datensatz angelegt
	 * andernfalls wird der Datensatz mit der ID in $reihungstest_id aktualisiert
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save()
	{
		if(!$this->validate())
			return false;
<<<<<<< HEAD
		
		if($this->new)
		{
			//Neuen Datensatz einfuegen
					
			$qry='BEGIN; INSERT INTO public.tbl_reihungstest (studiengang_kz, ort_kurzbz, anmerkung, datum, uhrzeit, 
				ext_id, insertamum, insertvon, updateamum, updatevon, max_teilnehmer, oeffentlich, freigeschaltet) VALUES('.
=======

		if($this->new)
		{
			//Neuen Datensatz einfuegen

			$qry='BEGIN; INSERT INTO public.tbl_reihungstest (studiengang_kz, ort_kurzbz, anmerkung, datum, uhrzeit,
				 insertamum, insertvon, updateamum, updatevon, max_teilnehmer, oeffentlich, freigeschaltet, studiensemester_kurzbz) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->studiengang_kz, FHC_INTEGER).', '.
			     $this->db_add_param($this->ort_kurzbz).', '.
			     $this->db_add_param($this->anmerkung).', '.
			     $this->db_add_param($this->datum).', '.
<<<<<<< HEAD
			     $this->db_add_param($this->uhrzeit).', '.
			     $this->db_add_param($this->ext_id, FHC_INTEGER).',  now(), '.
=======
			     $this->db_add_param($this->uhrzeit).', now(), '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->insertvon).', now(), '.
			     $this->db_add_param($this->updatevon).','.
			     $this->db_add_param($this->max_teilnehmer).','.
			     $this->db_add_param($this->oeffentlich, FHC_BOOLEAN).','.
<<<<<<< HEAD
			     $this->db_add_param($this->freigeschaltet, FHC_BOOLEAN).');';
		}
		else
		{			
			$qry='UPDATE public.tbl_reihungstest SET '.
				'studiengang_kz='.$this->db_add_param($this->studiengang_kz, FHC_INTEGER).', '. 
				'ort_kurzbz='.$this->db_add_param($this->ort_kurzbz).', '.
				'anmerkung='.$this->db_add_param($this->anmerkung).', '.  
				'datum='.$this->db_add_param($this->datum).', '. 
				'uhrzeit='.$this->db_add_param($this->uhrzeit).', '.
				'ext_id='.$this->db_add_param($this->ext_id, FHC_INTEGER).', '. 
=======
			     $this->db_add_param($this->freigeschaltet, FHC_BOOLEAN).','.
			     $this->db_add_param($this->studiensemester_kurzbz).');';
		}
		else
		{
			$qry='UPDATE public.tbl_reihungstest SET '.
				'studiengang_kz='.$this->db_add_param($this->studiengang_kz, FHC_INTEGER).', '.
				'ort_kurzbz='.$this->db_add_param($this->ort_kurzbz).', '.
				'anmerkung='.$this->db_add_param($this->anmerkung).', '.
				'datum='.$this->db_add_param($this->datum).', '.
				'uhrzeit='.$this->db_add_param($this->uhrzeit).', '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		     	'updateamum= now(), '.
		     	'updatevon='.$this->db_add_param($this->updatevon).', '.
		     	'max_teilnehmer='.$this->db_add_param($this->max_teilnehmer).', '.
				'oeffentlich='.$this->db_add_param($this->oeffentlich, FHC_BOOLEAN).', '.
<<<<<<< HEAD
				'freigeschaltet='.$this->db_add_param($this->freigeschaltet, FHC_BOOLEAN).' '.
				'WHERE reihungstest_id='.$this->db_add_param($this->reihungstest_id, FHC_INTEGER, false).';';					
=======
				'freigeschaltet='.$this->db_add_param($this->freigeschaltet, FHC_BOOLEAN).', '.
				'studiensemester_kurzbz='.$this->db_add_param($this->studiensemester_kurzbz).' '.
				'WHERE reihungstest_id='.$this->db_add_param($this->reihungstest_id, FHC_INTEGER, false).';';
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		}
		
		if($this->db_query($qry))
		{
			if($this->new)
			{
				$qry = "SELECT currval('public.tbl_reihungstest_reihungstest_id_seq') as id";
				if($this->db_query($qry))
				{
					if($row = $this->db_fetch_object())
					{
						$this->reihungstest_id = $row->id;
						$this->db_query('COMMIT');
						return true;
					}
<<<<<<< HEAD
					else 
=======
					else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
					{
						$this->errormsg = 'Fehler beim Auslesen der Sequence';
						$this->db_query('ROLLBACK');
						return false;
					}
				}
<<<<<<< HEAD
				else 
=======
				else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				{
					$this->errormsg = 'Fehler beim Auslesen der Sequence';
					$this->db_query('ROLLBACK');
					return false;
				}
			}
			return true;
		}
		else
		{
			$this->errormsg = 'Fehler beim Speichern der Daten';
			return false;
		}
	}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Liefert die Reihungstests eines Studienganges
	 *
	 * @param $studiengang_kz
	 * @param $order (optional)
	 * @return true wenn ok, sonst false
	 */
<<<<<<< HEAD
	public function getReihungstest($studiengang_kz,$order=null)
	{
		$qry = "SELECT * FROM public.tbl_reihungstest WHERE studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER, false);
		
		if ($order!=null)
			$qry .=" ORDER BY ".$order.";";
		
=======
	public function getReihungstest($studiengang_kz,$order=null,$studiensemester_kurzbz=null)
	{
		$qry = "SELECT * FROM public.tbl_reihungstest WHERE studiengang_kz=".$this->db_add_param($studiengang_kz, FHC_INTEGER, false);

		if ($studiensemester_kurzbz!=null)
			$qry .=" AND studiensemester_kurzbz=".$this->db_add_param($studiensemester_kurzbz, FHC_STRING, false);
		
		if ($order!=null)
			$qry .=" ORDER BY ".$order;
		
		
		$qry.= ";";

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new reihungstest();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->reihungstest_id = $row->reihungstest_id;
				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->ort_kurzbz = $row->ort_kurzbz;
				$obj->anmerkung = $row->anmerkung;
				$obj->datum = $row->datum;
				$obj->uhrzeit = $row->uhrzeit;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
				$obj->max_teilnehmer = $row->max_teilnehmer;
				$obj->oeffentlich = $this->db_parse_bool($row->oeffentlich);
				$obj->freigeschaltet = $this->db_parse_bool($row->freigeschaltet);
<<<<<<< HEAD
				
=======
				$obj->studiensemester_kurzbz =$row->studiensemester_kurzbz;

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
			$this->errormsg = 'Fehler beim Laden der Reihungstests';
			return false;
		}
	}

	/**
	 * Liefert die Reihungstests der Zukunft und einer bestimmten ID
	 * Und sortiert diese so, dass die des uebergebenen Studienganges zuerst geliefert werden
	 * @param $include_id
	 * @param $studiengang_kz
	 * @return true wenn ok, sonst false
	 */
	public function getZukuenftige($include_id, $studiengang_kz)
	{
		$qry = "SELECT *, '1' as sortierung,(SELECT upper(typ || kurzbz) FROM public.tbl_studiengang WHERE studiengang_kz=tbl_reihungstest.studiengang_kz) as stg FROM public.tbl_reihungstest WHERE datum>=now()-'1 days'::interval AND studiengang_kz=".$this->db_add_param($studiengang_kz)."
<<<<<<< HEAD
			UNION 
=======
			UNION
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			SELECT *, '2' as sortierung,(SELECT upper(typ || kurzbz) FROM public.tbl_studiengang WHERE studiengang_kz=tbl_reihungstest.studiengang_kz) as stg FROM public.tbl_reihungstest WHERE datum>=now()-'1 days'::interval AND studiengang_kz!=".$this->db_add_param($studiengang_kz)."
			UNION
			SELECT *, '0' as sortierung,(SELECT upper(typ || kurzbz) FROM public.tbl_studiengang WHERE studiengang_kz=tbl_reihungstest.studiengang_kz) as stg FROM public.tbl_reihungstest WHERE reihungstest_id=".$this->db_add_param($include_id)."
			ORDER BY sortierung, stg, datum";
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$obj = new reihungstest();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->reihungstest_id = $row->reihungstest_id;
				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->ort_kurzbz = $row->ort_kurzbz;
				$obj->anmerkung = $row->anmerkung;
				$obj->datum = $row->datum;
				$obj->uhrzeit = $row->uhrzeit;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
				$obj->max_teilnehmer = $row->max_teilnehmer;
				$obj->oeffentlich = $this->db_parse_bool($row->oeffentlich);
				$obj->freigeschaltet = $this->db_parse_bool($row->freigeschaltet);
<<<<<<< HEAD
				
=======
				$obj->studiensemester_kurzbz =$row->studiensemester_kurzbz;

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
			$this->errormsg = 'Fehler beim Laden der Reihungstests';
			return false;
		}
	}
<<<<<<< HEAD
	
	public function getStgZukuenftige($stg)
	{	
=======

	public function getStgZukuenftige($stg)
	{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		$qry = "SELECT * "
				. "FROM public.tbl_reihungstest "
				. "WHERE studiengang_kz = ".$this->db_add_param($stg, FHC_INTEGER)." "
				. "AND datum>=now()-'1 days'::interval "
				. "AND oeffentlich;";
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($result = $this->db_query($qry))
		{
			while($row = $this->db_fetch_object($result))
			{
				$obj = new reihungstest();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$obj->reihungstest_id = $row->reihungstest_id;
				$obj->studiengang_kz = $row->studiengang_kz;
				$obj->ort_kurzbz = $row->ort_kurzbz;
				$obj->anmerkung = $row->anmerkung;
				$obj->datum = $row->datum;
				$obj->uhrzeit = $row->uhrzeit;
				$obj->ext_id = $row->ext_id;
				$obj->insertamum = $row->insertamum;
				$obj->insertvon = $row->insertvon;
				$obj->updateamum = $row->updateamum;
				$obj->updatevon = $row->updatevon;
				$obj->max_teilnehmer = $row->max_teilnehmer;
				$obj->oeffentlich = $this->db_parse_bool($row->oeffentlich);
				$obj->freigeschaltet = $this->db_parse_bool($row->freigeschaltet);
<<<<<<< HEAD
				
				$this->result[] = $obj;
			}
			return true; 
		}
		else
			return false; 
=======
				$obj->studiensemester_kurzbz =$row->studiensemester_kurzbz;

				$this->result[] = $obj;
			}
			return true;
		}
		else
			return false;
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	}

	public function getTeilnehmerAnzahl($reihungstest_id) {

		$qry = 'SELECT count(*) AS anzahl '
				. 'FROM public.tbl_prestudent '
				. 'WHERE reihungstest_id = ' . $reihungstest_id;

		$result = $this->db_query($qry);

		$obj = $this->db_fetch_object($result);

		return $obj->anzahl;
	}
}
