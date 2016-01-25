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
 * Klasse Betriebsmittelperson 
=======
 * Klasse Betriebsmittelperson
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
 * @create 13-01-2007
 */
require_once(dirname(__FILE__).'/basis_db.class.php');

class betriebsmittelperson extends basis_db
{
	public $debug=false;   	// boolean

	public $new;       			// boolean
	public $result = array();
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	//Tabellenspalten
	public $betriebsmittelperson_id;
	public $betriebsmittel_id;	//  integer
	public $person_id;			//  integer
	public $betriebsmittel_id_old;	//  integer
	public $person_id_old;			//  integer
	public $anmerkung;			//  string
	public $kaution;			//  numeric(5,2)
	public $ausgegebenam;		//  date
	public $retouram;			//  date
	public $ext_id;				//  integer
	public $insertamum;			//  timestamp
	public $insertvon;			//  bigint
	public $updateamum;			//  timestamp
	public $updatevon;			//  bigint
<<<<<<< HEAD
	
	public $nummer;
	public $betriebsmitteltyp;
	public $beschreibung;
	public $oe_kurzbz;	
	public $nummer2;
	public $uid;
	
=======

	public $nummer;
	public $betriebsmitteltyp;
	public $beschreibung;
	public $oe_kurzbz;
	public $nummer2;
	public $uid;

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Konstruktor
	 * @param $betriebsmittel_id
	 *        $person_id
	 */
	public function __construct($betriebsmittelperson_id=null)
	{
		parent::__construct();
<<<<<<< HEAD
		
		if(!is_null($betriebsmittelperson_id))
			$this->load($betriebsmittelperson_id);
	}
	
=======

		if(!is_null($betriebsmittelperson_id))
			$this->load($betriebsmittelperson_id);
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt das Betriebsmittel mit der ID $betriebsmittelperson_id
	 * @param  $betriebsmittelperson_id ID des zu ladenden Zuordnung
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load($betriebsmittelperson_id)
	{
		if(!is_numeric($betriebsmittelperson_id))
		{
			$this->errormsg = 'Betriebsmittelperson_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = "SELECT 
					tbl_betriebsmittel.*,
					tbl_betriebsmittelperson.*
				FROM wawi.tbl_betriebsmittel JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
=======

		$qry = "SELECT
					tbl_betriebsmittel.*,
					tbl_betriebsmittelperson.*
				FROM wawi.tbl_betriebsmittel JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				WHERE betriebsmittelperson_id=".$this->db_add_param($betriebsmittelperson_id, FHC_INTEGER);
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$this->betriebsmittel_id = $row->betriebsmittel_id;
				$this->beschreibung = $row->beschreibung;
				$this->betriebsmitteltyp = $row->betriebsmitteltyp;
				$this->nummer = $row->nummer;
				$this->inventarnummer = $row->inventarnummer;
				$this->reservieren = $this->db_parse_bool($row->reservieren);
				$this->person_id = $row->person_id;
				$this->anmerkung = $row->anmerkung;
				$this->kaution = $row->kaution;
				$this->ausgegebenam = $row->ausgegebenam;
				$this->retouram = $row->retouram;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->ext_id = $row->ext_id;
				$this->ort_kurzbz = $row->ort_kurzbz;
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->nummer2 = $row->nummer2;
				$this->uid = $row->uid;
				return true;
			}
<<<<<<< HEAD
			else 
=======
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg = 'Es wurde kein passender Datensatz gefunden';
				return false;
			}
<<<<<<< HEAD
		}	
		else 
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}		
	}
	
=======
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Prueft die Variablen vor dem Speichern
	 *
	 * @return true wenn ok, sonst false
	 */
	protected function validate()
	{
		if($this->kaution=='')
			$this->kaution=0;
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(!is_numeric($this->kaution))
		{
			$this->errormsg = 'Kaution ist ungueltig';
			return false;
		}
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->ausgegebenam!='' && !mb_ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$this->ausgegebenam)
								   && !mb_ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})",$this->ausgegebenam))
		{
			$this->errormsg = 'Ausgegeben am Datum ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->retouram!='' && !mb_ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$this->retouram)
							   && !mb_ereg("([0-9]{2}).([0-9]{2}).([0-9]{4})",$this->retouram))
		{
			$this->errormsg = 'Ausgegeben am Datum ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(mb_strlen($this->anmerkung)>256)
		{
			$this->errormsg = 'Anmerkung darf nicht laenger als 256 Zeichen sein';
			return false;
		}
<<<<<<< HEAD
						
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->kaution!='' && $this->kaution>9999.99)
		{
			$this->errormsg = 'Kaution darf nicht groesser als 9999.99 sein';
			return false;
		}
<<<<<<< HEAD
		
		return true;
	}
		
	/**
	 * Speichert den aktuellen Datensatz in die Datenbank	 
=======

		return true;
	}

	/**
	 * Speichert den aktuellen Datensatz in die Datenbank
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	 * Wenn $neu auf true gesetzt ist wird ein neuer Datensatz angelegt
	 * andernfalls wird der Datensatz mit der ID $betriebsmittelperson_id aktualisiert
	 * @param $new
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function save($new=null)
	{
		if(!$this->validate())
			return false;
<<<<<<< HEAD
			
		if(is_null($new))
			$new = $this->new;
				
		if($new)
		{
			//Neuen Datensatz einfuegen
			$qry='BEGIN;INSERT INTO wawi.tbl_betriebsmittelperson (betriebsmittel_id, person_id, anmerkung, kaution, 
			ausgegebenam, retouram, ext_id, insertamum, insertvon, updateamum, updatevon, uid) VALUES('.
=======

		if(is_null($new))
			$new = $this->new;

		if($new)
		{
			//Neuen Datensatz einfuegen
			$qry='BEGIN;INSERT INTO wawi.tbl_betriebsmittelperson (betriebsmittel_id, person_id, anmerkung, kaution,
			ausgegebenam, retouram, insertamum, insertvon, updateamum, updatevon, uid) VALUES('.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->betriebsmittel_id, FHC_INTEGER).', '.
			     $this->db_add_param($this->person_id, FHC_INTEGER).', '.
			     $this->db_add_param($this->anmerkung).', '.
			     $this->db_add_param($this->kaution).', '.
			     $this->db_add_param($this->ausgegebenam).', '.
<<<<<<< HEAD
			     $this->db_add_param($this->retouram).', '.
			     $this->db_add_param($this->ext_id).',  now(), '.
=======
			     $this->db_add_param($this->retouram).', now(), '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			     $this->db_add_param($this->insertvon).', now(), '.
			     $this->db_add_param($this->updatevon).', '.
			     $this->db_add_param($this->uid).');';
		}
		else
<<<<<<< HEAD
		{	
=======
		{
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			//Pruefen ob betriebsmittelperson_id eine gueltige Zahl ist
			if(!is_numeric($this->betriebsmittelperson_id))
			{
				$this->errormsg = 'betriebsmittel_id und Person_id muessen gueltige Zahlen sein';
				return false;
			}
<<<<<<< HEAD
						
			$qry='UPDATE wawi.tbl_betriebsmittelperson SET '.
				'betriebsmittel_id='.$this->db_add_param($this->betriebsmittel_id, FHC_INTEGER).', '. 
				'person_id='.$this->db_add_param($this->person_id, FHC_INTEGER).', '. 
				'anmerkung='.$this->db_add_param($this->anmerkung).', '. 
				'kaution='.$this->db_add_param($this->kaution).', '. 
				'ausgegebenam='.$this->db_add_param($this->ausgegebenam).', '.
				'retouram='.$this->db_add_param($this->retouram).', '.
				'ext_id='.$this->db_add_param($this->ext_id).', '. 
=======

			$qry='UPDATE wawi.tbl_betriebsmittelperson SET '.
				'betriebsmittel_id='.$this->db_add_param($this->betriebsmittel_id, FHC_INTEGER).', '.
				'person_id='.$this->db_add_param($this->person_id, FHC_INTEGER).', '.
				'anmerkung='.$this->db_add_param($this->anmerkung).', '.
				'kaution='.$this->db_add_param($this->kaution).', '.
				'ausgegebenam='.$this->db_add_param($this->ausgegebenam).', '.
				'retouram='.$this->db_add_param($this->retouram).', '.
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				'updateamum= now(), '.
				'updatevon='.$this->db_add_param($this->updatevon).', '.
				'uid = '.$this->db_add_param($this->uid).' '.
				'WHERE betriebsmittelperson_id='.$this->db_add_param($this->betriebsmittelperson_id, FHC_INTEGER).';';
		}
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($new)
			{
				$qry = "SELECT currval('wawi.seq_betriebsmittelperson_betriebsmittelperson_id') as id";
				if($result = $this->db_query($qry))
				{
					if($row = $this->db_fetch_object($result))
					{
						$this->betriebsmittelperson_id = $row->id;
						$this->db_query('COMMIT;');
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
					}
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
				}
			}
			return true;
		}
<<<<<<< HEAD
		else 
		{
			$this->errormsg = 'Fehler beim Speichern der Betriebsmittelperson';			
			return false;
		}
	}
	
=======
		else
		{
			$this->errormsg = 'Fehler beim Speichern der Betriebsmittelperson';
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Loescht den Datenensatz mit der ID die uebergeben wird
	 * @param $betriebsmittelperson_id ID die geloescht werden soll
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function delete($betriebsmittelperson_id)
	{
		if(!is_numeric($betriebsmittelperson_id))
		{
			$this->errormsg = 'Betriebsmittelperson_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = 'DELETE FROM wawi.tbl_betriebsmittelperson 
=======

		$qry = 'DELETE FROM wawi.tbl_betriebsmittelperson
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				WHERE betriebsmittelperson_id='.$this->db_add_param($betriebsmittelperson_id, FHC_INTEGER);
		if($this->db_query($qry))
			return true;
		else
		{
			$this->errormsg = 'Fehler beim Loeschen der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Loescht ALLE zuordnungen zu einem Betriebsmittel
	 * @param $betriebsmittel_id ID die geloescht werden soll
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function delete_betriebsmittel($betriebsmittel_id)
	{
		if(!is_numeric($betriebsmittel_id))
		{
			$this->errormsg = 'Betriebsmittel_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry = 'DELETE FROM wawi.tbl_betriebsmittelperson 
=======

		$qry = 'DELETE FROM wawi.tbl_betriebsmittelperson
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				WHERE betriebsmittel_id='.$this->db_add_param($betriebsmittel_id, FHC_INTEGER);
		if($this->db_query($qry))
			return true;
		else
		{
			$this->errormsg = 'Fehler beim Loeschen der Daten';
			return false;
		}
	}
<<<<<<< HEAD
	
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Betriebsmittel einer Person
	 * Optional kann auch ein Typ uebergeben werden
	 * @param $person_id ID der Person
	 * @param $betriebsmitteltyp Typ auf den gefiltert werden soll
	 * @return true wenn ok, false wenn Fehler
	 */
	public function getBetriebsmittelPerson($person_id, $betriebsmitteltyp=null)
	{
		$this->result=array();
		$this->errormsg = '';
		if(!is_numeric($person_id))
		{
			$this->errormsg = 'Person_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		$qry = "SELECT * FROM wawi.tbl_betriebsmittel JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
=======
		$qry = "SELECT * FROM wawi.tbl_betriebsmittel JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				WHERE person_id=".$this->db_add_param($person_id, FHC_INTEGER);
		if(!is_null($betriebsmitteltyp))
			$qry.=" AND betriebsmitteltyp=".$this->db_add_param($betriebsmitteltyp);
		$qry.=" ORDER BY betriebsmitteltyp, nummer";
<<<<<<< HEAD
		
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$bm = new betriebsmittelperson();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$bm->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$bm->betriebsmittel_id = $row->betriebsmittel_id;
				$bm->beschreibung = $row->beschreibung;
				$bm->betriebsmitteltyp = $row->betriebsmitteltyp;
				$bm->nummer = $row->nummer;
				$bm->inventarnummer = $row->inventarnummer;
				$bm->verwendung = $row->verwendung;
				$bm->reservieren = $this->db_parse_bool($row->reservieren);
				$bm->ort_kurzbz = $row->ort_kurzbz;
				$bm->person_id = $row->person_id;
				$bm->anmerkung = $row->anmerkung;
				$bm->kaution = $row->kaution;
				$bm->ausgegebenam = $row->ausgegebenam;
				$bm->retouram = $row->retouram;
				$bm->insertamum = $row->insertamum;
				$bm->insertvon = $row->insertvon;
				$bm->updateamum = $row->updateamum;
				$bm->updatevon = $row->updatevon;
				$bm->ext_id = $row->ext_id;
				$bm->oe_kurzbz = $row->oe_kurzbz;
<<<<<<< HEAD
				$bm->nummer2 = $row->nummer2;	
				$bm->uid = $row->uid;				
				$this->result[] = $bm;
			}
			
			return true;
		}
		else 
=======
				$bm->nummer2 = $row->nummer2;
				$bm->uid = $row->uid;
				$this->result[] = $bm;
			}

			return true;
		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

	/**
	 * Laedt die Betriebsmittelzuordnung der Person, welche das Betriebsmittel zuletzt hatte
	 * bzw die Letzte Zuordnung von einer bestimmten Person
	 * @param  $betriebsmittel_id ID des zu ladenden Betriebsmittels
	 * @param  $person_id ID der Person (optional)
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function load_betriebsmittelpersonen($betriebsmittel_id, $person_id=null)
	{
		$this->result=array();
		$this->errormsg='';
<<<<<<< HEAD
			
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(!is_numeric($betriebsmittel_id))
		{
			$this->errormsg = 'Betriebsmittel_id ist ungueltig';
			return false;
		}
<<<<<<< HEAD
		
		$qry='
			SELECT 
				* 
			FROM 
				wawi.tbl_betriebsmittel 
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
			WHERE betriebsmittel_id='.$this->db_add_param($betriebsmittel_id, FHC_INTEGER);
		
		if(!is_null($person_id))
			$qry.=" AND person_id=".$this->db_add_param($person_id, FHC_INTEGER);
			
		$qry.=' ORDER BY ausgegebenam desc, retouram desc LIMIT 1';
		
=======

		$qry='
			SELECT
				*
			FROM
				wawi.tbl_betriebsmittel
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
			WHERE betriebsmittel_id='.$this->db_add_param($betriebsmittel_id, FHC_INTEGER);

		if(!is_null($person_id))
			$qry.=" AND person_id=".$this->db_add_param($person_id, FHC_INTEGER);

		$qry.=' ORDER BY ausgegebenam desc, retouram desc LIMIT 1';

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$this->betriebsmittel_id = $row->betriebsmittel_id;
				$this->beschreibung = $row->beschreibung;
				$this->betriebsmitteltyp = $row->betriebsmitteltyp;
				$this->nummer = $row->nummer;
				$this->inventarnummer = $row->inventarnummer;
				$this->reservieren = $this->db_parse_bool($row->reservieren);
				$this->ort_kurzbz = $row->ort_kurzbz;
				$this->person_id = $row->person_id;
				$this->anmerkung = $row->anmerkung;
				$this->kaution = $row->kaution;
				$this->ausgegebenam = $row->ausgegebenam;
				$this->retouram = $row->retouram;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->ext_id = $row->ext_id;
<<<<<<< HEAD
				$this->oe_kurzbz = $row->oe_kurzbz;		
				$this->nummer2 = $row->nummer2;		
				$this->uid = $row->uid;
				return true;	
			}
			else 
=======
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->nummer2 = $row->nummer2;
				$this->uid = $row->uid;
				return true;
			}
			else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			{
				$this->errormsg ='Es wurde kein Eintrag gefunden';
				return false;
			}
<<<<<<< HEAD
		}	
		else 
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}		
	}
	
=======
		}
		else
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
	/**
	 * Laedt alle Zuordnungen zu diesem Betriebsmittel
	 * @param  $betriebsmittel_id ID des zu ladenden Betriebsmittels
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function getbetriebsmittelpersonen($betriebsmittel_id)
	{
		$this->result=array();
		$this->errormsg='';
<<<<<<< HEAD
			
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		if(!is_numeric($betriebsmittel_id))
		{
			$this->errormsg = 'Betriebsmittel_id ist ungueltig';
			return false;
		}
		$qry='
<<<<<<< HEAD
			SELECT 
				*
			FROM 
				wawi.tbl_betriebsmittel 
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
=======
			SELECT
				*
			FROM
				wawi.tbl_betriebsmittel
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			WHERE betriebsmittel_id='.$this->db_add_param($betriebsmittel_id, FHC_INTEGER).'
			ORDER BY ausgegebenam desc, retouram desc';

		if($this->db_query($qry))
		{
			while($row = $this->db_fetch_object())
			{
				$bm = new betriebsmittelperson();
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$bm->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$bm->betriebsmittel_id = $row->betriebsmittel_id;
				$bm->beschreibung = $row->beschreibung;
				$bm->betriebsmitteltyp = $row->betriebsmitteltyp;
				$bm->nummer = $row->nummer;
				$bm->inventarnummer = $row->inventarnummer;
				$bm->reservieren = $this->db_parse_bool($row->reservieren);
				$bm->ort_kurzbz = $row->ort_kurzbz;
				$bm->person_id = $row->person_id;
				$bm->anmerkung = $row->anmerkung;
				$bm->kaution = $row->kaution;
				$bm->ausgegebenam = $row->ausgegebenam;
				$bm->retouram = $row->retouram;
				$bm->insertamum = $row->insertamum;
				$bm->insertvon = $row->insertvon;
				$bm->updateamum = $row->updateamum;
				$bm->updatevon = $row->updatevon;
				$bm->ext_id = $row->ext_id;
				$bm->oe_kurzbz = $row->oe_kurzbz;
				$bm->nummer2 = $row->nummer2;
				$bm->uid = $row->uid;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				$this->result[] = $bm;
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
	 * Sucht welche Person die uebergebene Kartennummer hat
	 * @param  $nummer Kartennummer
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function getKartenzuordnung($nummer)
	{
		// fuehrende Nullen bei Kartennummern auch checken
		$qry='
<<<<<<< HEAD
			SELECT 
				*
			FROM 
				wawi.tbl_betriebsmittel 
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
			WHERE 
=======
			SELECT
				*
			FROM
				wawi.tbl_betriebsmittel
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
			WHERE
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			(tbl_betriebsmittel.nummer='.$this->db_add_param($nummer).'
			OR tbl_betriebsmittel.nummer='.$this->db_add_param('0'.$nummer).'
			OR tbl_betriebsmittel.nummer='.$this->db_add_param('00'.$nummer).'
			OR tbl_betriebsmittel.nummer='.$this->db_add_param('000'.$nummer).'
			OR tbl_betriebsmittel.nummer='.$this->db_add_param('0000'.$nummer).'
			OR tbl_betriebsmittel.nummer='.$this->db_add_param('00000'.$nummer).'
            OR tbl_betriebsmittel.nummer2='.$this->db_add_param($nummer).'
			OR tbl_betriebsmittel.nummer2='.$this->db_add_param('0'.$nummer).'
			OR tbl_betriebsmittel.nummer2='.$this->db_add_param('00'.$nummer).'
			OR tbl_betriebsmittel.nummer2='.$this->db_add_param('000'.$nummer).'
			OR tbl_betriebsmittel.nummer2='.$this->db_add_param('0000'.$nummer).'
			OR tbl_betriebsmittel.nummer2='.$this->db_add_param('00000'.$nummer).'
			)
<<<<<<< HEAD
			AND (ausgegebenam<=now() OR ausgegebenam is NULL) 
=======
			AND (ausgegebenam<=now() OR ausgegebenam is NULL)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			AND (retouram>=now() OR retouram is NULL)';

		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$this->betriebsmittel_id = $row->betriebsmittel_id;
				$this->beschreibung = $row->beschreibung;
				$this->betriebsmitteltyp = $row->betriebsmitteltyp;
				$this->nummer = $row->nummer;
				$this->inventarnummer = $row->inventarnummer;
				$this->reservieren = $this->db_parse_bool($row->reservieren);
				$this->ort_kurzbz = $row->ort_kurzbz;
				$this->person_id = $row->person_id;
				$this->anmerkung = $row->anmerkung;
				$this->kaution = $row->kaution;
				$this->ausgegebenam = $row->ausgegebenam;
				$this->retouram = $row->retouram;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->ext_id = $row->ext_id;
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->nummer2 = $row->nummer2;
				$this->uid = $row->uid;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				return true;
			}
			else
			{
				$this->errormsg = 'Karte ist derzeit nicht ausgegeben';
				return false;
			}
<<<<<<< HEAD
			
		}
		else 
=======

		}
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
	 * Sucht welche Person die uebergebene Kartennummer hat
	 * @param $person_id Person ID
	 * @param $nummer Kartennummer
	 * @return true wenn ok, false im Fehlerfall
	 */
	public function getKartenzuordnungPerson($person_id, $nummer)
	{
		$qry='
<<<<<<< HEAD
			SELECT 
				*
			FROM 
				wawi.tbl_betriebsmittel 
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id) 
=======
			SELECT
				*
			FROM
				wawi.tbl_betriebsmittel
				JOIN wawi.tbl_betriebsmittelperson USING(betriebsmittel_id)
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
			WHERE tbl_betriebsmittel.nummer='.$this->db_add_param($nummer).'
			AND tbl_betriebsmittelperson.person_id='.$this->db_add_param($person_id);

		if($this->db_query($qry))
		{
			if($row = $this->db_fetch_object())
			{
				$this->betriebsmittelperson_id = $row->betriebsmittelperson_id;
				$this->betriebsmittel_id = $row->betriebsmittel_id;
				$this->beschreibung = $row->beschreibung;
				$this->betriebsmitteltyp = $row->betriebsmitteltyp;
				$this->nummer = $row->nummer;
				$this->inventarnummer = $row->inventarnummer;
				$this->reservieren = $this->db_parse_bool($row->reservieren);
				$this->ort_kurzbz = $row->ort_kurzbz;
				$this->person_id = $row->person_id;
				$this->anmerkung = $row->anmerkung;
				$this->kaution = $row->kaution;
				$this->ausgegebenam = $row->ausgegebenam;
				$this->retouram = $row->retouram;
				$this->insertamum = $row->insertamum;
				$this->insertvon = $row->insertvon;
				$this->updateamum = $row->updateamum;
				$this->updatevon = $row->updatevon;
				$this->ext_id = $row->ext_id;
				$this->oe_kurzbz = $row->oe_kurzbz;
				$this->nummer2 = $row->nummer2;
				$this->uid = $row->uid;
<<<<<<< HEAD
				
=======

>>>>>>> fee287127566cd5d18c55b556d178b661711c694
				return true;
			}
			else
			{
				$this->errormsg = 'Karte ist derzeit nicht ausgegeben';
				return false;
			}
<<<<<<< HEAD
			
		}
		else 
=======

		}
		else
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
		{
			$this->errormsg = 'Fehler beim Laden der Daten';
			return false;
		}
	}
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> fee287127566cd5d18c55b556d178b661711c694
